<?php

class Publisher_vk
{
	private $token;
	private $users;
	private $groups;
	private $proxy;

	public function __construct()
	{
		require_once __DIR__ . '/lib/Threads.php';

		Publisher::getInstance()->subscribe($this);

		if ( isset( $_GET['get_vk_token'] ) ) {
			$this->get_token_by_code( $_GET['id'] );
		}
	}

	public function publish( $message, $link, $name, $picture, $description, $group_lists ) {

		$users   = $this->users = Account::get_users_by_network( 2 );
		$groups = $this->groups = Group::get_groups_by_network_and_group_lists( 2, $group_lists );
		$proxy_arr  = $this->proxy = Proxy::get_all();

//		Установим время выполнения скрипта
		$time_count = count($groups);
		$time_execution = ($time_count * 60) + 1000;

		set_time_limit($time_execution);

		$Thread = new Thread();

		$Thread->Create( function () use ( $users, $groups, $proxy_arr, $message, $link, $name, $picture, $description, $group_lists ) {

//			Debug option
//			ob_start();

			foreach ( $users as $user_item ) {

				$token         = $user_item->token;

				foreach ( $groups as $group ) {

					$destination = $group->group_id;

					$curl = curl_init();

					if ( ! empty( $proxy_arr ) ) {
						/* Iterate via proxy array */
						$proxy = each( $proxy_arr );

						if ( $proxy !== false ) {
							$proxy = $proxy['value']->proxy_ip;
						} else {
							reset( $proxy_arr );
							$proxy = each( $proxy_arr );
							$proxy = $proxy['value']->proxy_ip;
						}

						if ( ! empty( $proxy ) ) {
							curl_setopt( $curl, CURLOPT_PROXY, $proxy );
						}
					}

					curl_setopt($curl, CURLOPT_URL, "https://api.vk.com/method/wall.post");
					curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, "access_token={$token}&owner_id=-{$destination}&message={$message}&attachments={$link}");
					$out = curl_exec($curl);
					curl_close($curl);

//					var_dump($out);

					$time       = intval( get_option( 'time_period' ) );

					if ( is_int($time) ) {
						sleep($time);
					}

				}
			}

//			$screen = ob_get_contents();
//			file_put_contents('result-screen.txt', $screen . "--**\r\n", FILE_APPEND);
//			ob_end_clean();

		});

		$Thread->Run();
	}

	public function get_token_by_code( $id )
	{
		global $wpdb;
		$table_name = Account::$table_name;

		$account = $wpdb->get_results("SELECT code, client_id, client_secret FROM {$table_name} WHERE id = {$id}");

		if ( isset($account[0]) ) {
			$account = $account[0];

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://oauth.vk.com/access_token");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "client_id={$account->client_id}&client_secret={$account->client_secret}&redirect_uri=http://". $_SERVER['HTTP_HOST'] ."/wp-admin/&code={$account->code}");
			$out = curl_exec($curl);
			$out = json_decode( $out );
			echo $_SERVER['HTTP_HOST'];
			curl_close($curl);

			if ( isset($out->access_token) ) {
				$wpdb->query("UPDATE {$table_name} SET code = '', token = '{$out->access_token}' WHERE id = {$id}");
			}
		}
	}
}

new Publisher_vk();
