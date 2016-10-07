<?php

class Account
{
	public static $table_name = 'spa_accounts';

	public function __construct()
	{
		if ( isset( $_POST['add_spa_account'] ) ) {
			$name = $_POST['name'];
			$client_id = $_POST['client_id'];
			$client_secret = $_POST['client_secret'];
			$network = $_POST['network'];
			$token = $_POST['token'];
			$code = $_POST['code'];

			$this->add($name, $client_id, $client_secret, $code, $token, $network);
		}

		if ( isset( $_POST['update_spa_account'] ) ) {
			$id = $_POST['account_id'];
			$name = $_POST['name'];
			$client_id = $_POST['client_id'];
			$client_secret = $_POST['client_secret'];
			$network = $_POST['network'];
			$code = $_POST['code'];
			$token = $_POST['token'];

			$this->update($id, $name, $client_id, $client_secret, $code,  $token, $network);
		}

		if ( isset( $_GET['delete_account'] ) ) {
			$this->delete( $_GET['id'] );
		}
	}

	/**
	 * Add new account to database
	 *
	 */
	public function add($name, $client_id, $client_secret, $code = '',  $token = '', $network)
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->query("
				INSERT INTO
				{$table_name}
				(name, client_id, client_secret, code,  token, network)
				VALUE
				('{$name}', '{$client_id}', '{$client_secret}', '{$code}', '{$token}', '{$network}')
			");
	}

	/**
	 * Update account
	 *
	 * @param mixed $id
	 * @param mixed $name
	 * @param mixed $client_id
	 * @param mixed $client_secret
	 * @param mixed $token
	 * @param mixed $network
	 */
	public function update($id, $name, $client_id, $client_secret, $code,  $token, $network)
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->query("
				UPDATE
				{$table_name}
				SET name='{$name}', client_id='{$client_id}', client_secret='{$client_secret}', code='{$code}', token='{$token}', network='{$network}'
				WHERE id = {$id}
			");
	}

	public function delete( $id )
	{
		global $wpdb;
		$table_name = self::$table_name;
		$wpdb->query("DELETE FROM {$table_name} WHERE id = {$id}");
	}

	public function get_all()
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_results("SELECT * FROM {$table_name}");
		return $result;
	}

	public static function update_token($id, $token, $expiries)
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_results("UPDATE {$table_name} SET token='{$token}', token_expires='{$expiries}' WHERE id={$id}");
		return $result;
	}

	public static function get_users_by_network( $network_id )
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_results("SELECT * FROM {$table_name} WHERE network = {$network_id}");
		return $result;
	}

}
