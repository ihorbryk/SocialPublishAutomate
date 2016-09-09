<?php

class Account
{
	static public $table_name = 'spa_accounts';

	public function __construct()
	{
		if ( isset( $_POST['add_spa_account'] ) ) {
			$name = $_POST['name'];
			$network = $_POST['network'];
			$account_id = $_POST['account_id'];
			$token = $_POST['token'];

			$this->add($name, $account_id, $token, $network);
		}

		if ( isset( $_GET['delete_account'] ) ) {
			$this->delete( $_GET['id'] );
		}
	}

	/**
	 * Add new account to database
	 *
	 */
	public function add($name, $account_id, $token, $network)
	{
		global $wpdb;
		$result = $wpdb->query("
				INSERT INTO
				{$this->table_name}
				(name, account_id, token, network)
				VALUE
				('{$name}', '{$account_id}', '{$token}', '{$network}')
			");

	}

	public function delete( $id )
	{
		global $wpdb;
		$wpdb->query("DELETE FROM {$this->table_name} WHERE id = {$id}");
	}

	public function get_all()
	{
		global $wpdb;
		$result = $wpdb->get_results("SELECT * FROM {$this->table_name}");
		return $result;
	}

	static public function get_users_by_network( $network_id )
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_results("SELECT * FROM {$table_name} WHERE network = {$network_id}");
		return $result;
	}

}
