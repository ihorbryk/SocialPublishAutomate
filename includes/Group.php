<?php

class Group
{
	public $table_name = 'spa_groups';

	public function __construct()
	{
		if ( isset( $_POST['add_spa_group'] ) ) {
			$name = $_POST['name'];
			$account_id = $_POST['group_id'];

			$this->add($name, $account_id);
		}

		if ( isset( $_GET['delete_group'] ) ) {
			$this->delete( $_GET['id'] );
		}
	}

	/**
	 * Add new account to database
	 *
	 */
	public function add($name, $group_id)
	{

		global $wpdb;
		$result = $wpdb->query("
				INSERT INTO
				{$this->table_name}
				(name, group_id)
				VALUE
				('{$name}', '{$group_id}')
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
