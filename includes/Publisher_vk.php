<?php

class Publisher_vk
{
	private $token;
	private $users;
	private $groups;

	public function __construct()
	{
		Publisher::getInstance()->subscribe($this);

		add_action( 'post_to_facebook', function( $message, $link, $name, $picture, $description, $token, $destination ) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://api.vk.com/method/wall.post");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			/* curl_setopt($curl, CURLOPT_POSTFIELDS, "access_token={$token}&message={$message}&link={$link}&name={$name}&description={$description}&picture={$picture}"); */
			curl_setopt($curl, CURLOPT_POSTFIELDS, "owner_id=-{$destination}&message={$message}&attachments={$link}");
			$out = curl_exec($curl);
			curl_close($curl);

			$upload_dir_info = wp_upload_dir();
			file_put_contents($upload_dir_info['path'].'/spa_log.txt', $destination . " vk -> " . $out . " -- " . date('j m Y H:i:s') . " -- " . "--->" . time() . "\n", FILE_APPEND);
		}, 10, 7 );

	}

	public function publish( $message, $link, $name, $picture, $description )
	{
		$this->users = Account::get_users_by_network( 2 );
		$this->groups = Group::get_groups_by_network( 2 );

		foreach ($this->users as $user) {
			$token = $user->token;
			$code = $user->code;
			$client_id = $user->client_id;
			$client_secret = $user->client_secret;

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://oauth.vk.com/access_token");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "client_id={$client_id}&client_secret={$client_secret}&redirect_uri=http://socialposter.local/verifi&code={$code}");
			$out = curl_exec($curl);
			$out = json_decode( $out );
			var_dump( $out );
			$upload_dir_info = wp_upload_dir();
			file_put_contents($upload_dir_info['path'].'/spa_token_log.txt', $out->access_token . " vk -- " . date('j m Y H:i:s') . " -- " . "\n", FILE_APPEND);
			curl_close($curl);

			$new_token = $out->access_token;

			if ( isset( $new_token ) ) {
				Account::update_token($user->id, $new_token, time() + $out->expires_in);
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

new Publisher_vk();
