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
			$group_list = $_POST['group_list'];

			$this->add($name, $account_id, $network, $group_list);
		}

		if ( isset( $_POST['update_spa_group'] ) ) {
			$id = $_POST['id'];
			$name = $_POST['name'];
			$account_id = $_POST['group_id'];
			$network = $_POST['network'];
			$group_list = $_POST['group_list'];

			$this->update($id, $name, $account_id, $network, $group_list);
		}

		if ( isset( $_POST['delete_spa_group'] ) ) {
			$this->delete( $_POST['id'] );
		}
	}

	/**
	 * Add new account to database
	 *
	 */
	public function add($name, $group_id, $network, $group_list)
	{

		if ( empty($group_list) ) {
			return;
		}

		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->query("
				INSERT INTO
				{$table_name}
				(name, group_id, network, group_list)
				VALUE
				('{$name}', '{$group_id}', '{$network}', '{$group_list}')
			");
	}
	
	/**
	 * Update
	 *
	 * @param mixed $id
	 * @param mixed $name
	 * @param mixed $group_id
	 * @param mixed $network
	 */
	public function update($id, $name, $group_id, $network, $group_list)
	{
		if ( empty($group_list) ) {
			return;
		}

		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->query("
				UPDATE
				{$table_name}
				SET name='{$name}', group_id='{$group_id}', network={$network}
				WHERE id = {$id}
			");
	}

	public function delete( $id )
	{
		global $wpdb;
		$table_name = self::$table_name;
		$wpdb->query("DELETE FROM {$table_name} WHERE id = {$id}");
	}

	public function get_all($filter = null)
	{
		global $wpdb;
		$table_name = self::$table_name;

		if ( $filter == null ) {
			$result = $wpdb->get_results("SELECT * FROM {$table_name}");
		} else {
			$result = $wpdb->get_results("SELECT * FROM {$table_name} WHERE group_list= {$filter}");
		}
		return $result;
	}


	static public function get_groups_by_network( $network_id )
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_results("SELECT * FROM {$table_name} WHERE network = {$network_id}");
		return $result;
	}

	static public function get_groups_by_network_and_group_lists( $network_id, $group_lists )
	{
		if ( empty( $group_lists ) ) {
			return;
		}

		global $wpdb;
		$table_name = self::$table_name;

		$result = [];

		foreach ($group_lists as $connected_tag_id) {
			$group_list_id = Group_lists::get_id_by_connected_tag_id($connected_tag_id);
			$groups_by_list_id = $wpdb->get_results("SELECT * FROM {$table_name} WHERE network = {$network_id} AND group_list = {$group_list_id}");
			$result = array_merge( $result, $groups_by_list_id );
		}

		return array_unique($result, SORT_REGULAR);
	}
}
