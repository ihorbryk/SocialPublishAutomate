<?php

class Publisher_facebook
{
	private $token;
	private $users;
	private $groups;

	public function __construct()
	{
		Publisher::getInstance()->subscribe($this);

		add_action( 'post_to_facebook', function( $message, $link, $name, $picture, $description, $token, $destination, $proxy ) {
			$curl = curl_init();
			if (!empty($proxy)) {
				curl_setopt($ch, CURLOPT_PROXY, $proxy);
			}
			curl_setopt($curl, CURLOPT_URL, "https://graph.facebook.com/v2.7/{$destination}/feed");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "access_token={$token}&message={$message}&link={$link}&name={$name}&description={$description}&picture={$picture}");
			$out = curl_exec($curl);
			curl_close($curl);

			$upload_dir_info = wp_upload_dir();
		}, 10, 7 );


		if ( isset( $_GET['get_facebook_token'] ) ) {
			$this->get_token_by_code( $_GET['id'] );
		}

	}

	public function publish( $message, $link, $name, $picture, $description, $group_lists )
	{
		$this->users = Account::get_users_by_network( 1 );
		$this->groups = Group::get_groups_by_network_and_group_lists( 1 , $group_lists);
		$this->proxy = Proxy::get_all();

		foreach ($this->users as $user) {

			$token = $user->token;
			$client_id = $user->client_id;
			$client_secret = $user->client_secret;


			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://graph.facebook.com/v2.7/oauth/access_token");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=fb_exchange_token&client_id={$client_id}&client_secret={$client_secret}&fb_exchange_token={$token}");
			$out = curl_exec($curl);
			$out = json_decode( $out );
			$upload_dir_info = wp_upload_dir();
			curl_close($curl);

			$new_token = $out->access_token;

			if ( isset( $new_token ) ) {
				$token = $new_token;
			}

			$time_stamp = 0;

			foreach ($this->groups as $group) {

				$destination = $group->group_id;

				/* Iterate via proxy array */
				$proxy = each($this->proxy);

				if ($proxy !== false) {
					$proxy = $proxy['value']->proxy_ip;
				} else {
					reset($this->proxy);
					$proxy = each($this->proxy);
					$proxy = $proxy['value']->proxy_ip;
				}

				wp_schedule_single_event( time() + $time_stamp, 'post_to_facebook', array( $message, $link, $name, $picture, $description, $token, $destination, $proxy ) );
				
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
			curl_setopt($curl, CURLOPT_URL, "https://graph.facebook.com/v2.7/oauth/access_token");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "client_id={$account->client_id}&redirect_uri=http://". $_SERVER['HTTP_HOST'] ."/wp-admin/admin.php?page=spa_get_token.php&client_secret={$account->client_secret}&code={$account->code}");
			$out = curl_exec($curl);
			$out = json_decode( $out );
			$upload_dir_info = wp_upload_dir();
			curl_close($curl);

			if ( isset($out->access_token) ) {
				$wpdb->query("UPDATE {$table_name} SET code = '', token = '{$out->access_token}' WHERE id = {$id}");
			}
		}
	}
}

new Publisher_facebook();
