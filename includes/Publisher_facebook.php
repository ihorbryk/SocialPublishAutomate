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
			curl_setopt($curl, CURLOPT_POSTFIELDS, "access_token={$this->token}&message={$this->message}&link={$this->link}&name={$this->name}&description={$this->description}&picture={$this->picture}");
			$out = curl_exec($curl);
			curl_close($curl);

			file_put_contents('spa_log.txt', $out . " -- " . date('j m Y H:i:s') . " -- " . "\n", FILE_APPEND);
		}, 10, 7 );
	}

	public function publish( $message, $link, $name, $picture, $description )
	{
		$this->users = Account::get_users_by_network( 1 );
		$this->groups = Group::get_groups_by_network( 1 );

		foreach ($this->users as $user) {
			foreach ($this->groups as $group) {
				$token = $user->token;
				$message = $message;
				$link = $link;
				$name = $name;
				$picture = $picture;
				$description = $description;
				$destination = $group->group_id;


				if ( !isset( $time_stamp ) ) {
					$time_stamp = 0;
				}

				wp_schedule_single_event( time() + $time_stamp, 'post_to_facebook', array( $message, $link, $name, $picture, $description, $token, $destination ) );
				
				$time = get_option('time_period');

				if (!isset( $time ) && !empty( $time )) {
					$time_stamp += $time;
				}
			}
		}
	}
}

new Publisher_facebook();
