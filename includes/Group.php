<?php

class Group
{
	static public $table_name = 'spa_groups';

	public function __construct()
	{
		if ( isset( $_POST['add_spa_group'] ) ) {
			$name = $_POST['name'];
			$account_id = $_POST['group_id'];
			$network = $_POST['network'];

			$this->add($name, $account_id, $network);
		}

		if ( isset( $_GET['delete_group'] ) ) {
			$this->delete( $_GET['id'] );
		}
	}

	/**
	 * Add new account to database
	 *
	 */
	public function add($name, $group_id, $network)
	{

		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->query("
				INSERT INTO
				{$table_name}
				(name, group_id, network)
				VALUE
				('{$name}', '{$group_id}', '{$network}')
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


	static public function get_groups_by_network( $network_id )
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_results("SELECT * FROM {$table_name} WHERE network = {$network_id}");
		return $result;
	}
}
