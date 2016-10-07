<?php

class Publisher_vk
{
	private $token;
	private $users;
	private $groups;

	public function __construct()
	{
		Publisher::getInstance()->subscribe($this);

		add_action( 'post_to_vk', function( $message, $link, $name, $picture, $description, $token, $destination ) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://api.vk.com/method/wall.post");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			/* curl_setopt($curl, CURLOPT_POSTFIELDS, "access_token={$token}&message={$message}&link={$link}&name={$name}&description={$description}&picture={$picture}"); */
			curl_setopt($curl, CURLOPT_POSTFIELDS, "access_token={$token}&owner_id=-{$destination}&message={$message}&attachments={$link}");
			$out = curl_exec($curl);
			curl_close($curl);

			$upload_dir_info = wp_upload_dir();
			file_put_contents($upload_dir_info['path'].'/spa_log.txt', $destination . " vk -> " . $out . " -- " . date('j m Y H:i:s') . " -- " . "--->" . time() . "\n", FILE_APPEND);
		}, 10, 7 );

		if ( isset( $_GET['get_vk_token'] ) ) {
			$this->get_token_by_code( $_GET['id'] );
		}
	}

	public function publish( $message, $link, $name, $picture, $description )
	{
		$this->users = Account::get_users_by_network( 2 );

		foreach ($this->users as $user) {
			$token = $user->token;
			$code = $user->code;
			$client_id = $user->client_id;
			$client_secret = $user->client_secret;
			$client_secret = $user->client_secret;

			$this->groups = Group::get_groups_by_network( $user->network );

			$time_stamp = 0;

			foreach ($this->groups as $group) {

				$destination = $group->group_id;

				wp_schedule_single_event( time() + $time_stamp, 'post_to_vk', array( $message, $link, $name, $picture, $description, $token, $destination ) );
				
				$time = intval(get_option('time_period'));
				$time_stamp = $time_stamp + $time;
			}
		}
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
			var_dump( $out );
			$upload_dir_info = wp_upload_dir();
			curl_close($curl);

			if ( isset($out->access_token) ) {
				$wpdb->query("UPDATE {$table_name} SET code = '', token = '{$out->access_token}' WHERE id = {$id}");
			}
		}
	}
}

new Publisher_vk();
