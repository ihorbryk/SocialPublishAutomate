<?php

class Publisher_facebook
{
	private $token;
	private $users;
	private $groups;

	public function __construct()
	{
		Publisher::getInstance()->subscribe($this);
	}

	public function publish( $message, $link, $name, $picture, $description )
	{
		$this->users = Account::get_users_by_network( 1 );
		$this->groups = Group::get_groups_by_network( 1 );

		foreach ($this->users as $user) {
			foreach ($this->groups as $group) {
				$this->token = $user->token;
				$this->message = $message;
				$this->link = $link;
				$this->name = $name;
				$this->picture = $picture;
				$this->description = $description;

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, "https://graph.facebook.com/v2.7/{$group->group_id}/feed");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, "access_token={$this->token}&message={$this->message}&link={$this->link}&name={$this->name}&description={$this->description}&picture={$this->picture}");
				$out = curl_exec($curl);
				curl_close($curl);
			}
		}
	}
}

new Publisher_facebook();
