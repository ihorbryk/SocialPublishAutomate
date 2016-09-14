<?php

class Publisher_facebook
{
	private $token;
	private $users;
	private $groups;

	public function __construct()
	{
		Publisher::getInstance()->subscribe($this);

		add_action( 'post_to_facebook', function( $message, $link, $name, $picture, $description, $token, $destination ) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://graph.facebook.com/v2.7/{$destination}/feed");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "access_token={$token}&message={$message}&link={$link}&name={$name}&description={$description}&picture={$picture}");
			$out = curl_exec($curl);
			curl_close($curl);

			$upload_dir_info = wp_upload_dir();
			file_put_contents($upload_dir_info['path'].'/spa_log.txt', $destination . " -> " . $out . " -- " . date('j m Y H:i:s') . " -- " . "--->" . time() . "\n", FILE_APPEND);
		}, 10, 7 );

	}

	public function publish( $message, $link, $name, $picture, $description )
	{
		$this->users = Account::get_users_by_network( 1 );
		$this->groups = Group::get_groups_by_network( 1 );

		foreach ($this->users as $user) {
			var_dump( $user );

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
			file_put_contents($upload_dir_info['path'].'/spa_token_log.txt', $out->access_token . " -- " . date('j m Y H:i:s') . " -- " . "\n", FILE_APPEND);
			curl_close($curl);

			$new_token = $out->access_token;

			if ( isset( $new_token ) ) {
				$token = $new_token;
			}

			$time_stamp = 0;

			foreach ($this->groups as $group) {

				var_dump($group);

				$destination = $group->group_id;

				wp_schedule_single_event( time() + $time_stamp, 'post_to_facebook', array( $message, $link, $name, $picture, $description, $token, $destination ) );
				
				$time = intval(get_option('time_period'));
				$time_stamp = $time_stamp + $time;
			}
		}
	}
}

new Publisher_facebook();
