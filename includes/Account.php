<?php

class Account
{
	public $table_name = 'spa_accounts';

	public function __construct()
	{
		if ( isset( $_POST['add_spa_account'] ) ) {
			$name = $_POST['name'];
			$account_id = $_POST['account_id'];
			$token = $_POST['token'];

			$this->add($name, $account_id, $token);
		}

		if ( isset( $_GET['delete_account'] ) ) {
			$this->delete( $_GET['id'] );
		}
	}

	/**
	 * Add new account to database
	 *
	 */
	public function add($name, $account_id, $token)
	{
		global $wpdb;
		$result = $wpdb->query("
				INSERT INTO
				{$this->table_name}
				(name, account_id, token)
				VALUE
				('{$name}', '{$account_id}', '{$token}')
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

}
