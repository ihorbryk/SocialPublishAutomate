<?php

class Proxy
{
	static public $table_name = 'spa_proxy';

	public function __construct()
	{
		if ( isset( $_POST['add_spa_proxy'] ) ) {
			$proxy_ip = $_POST['proxy_ip'];

			$this->add($proxy_ip);
		}

		if ( isset( $_POST['update_spa_proxy'] ) ) {
			$id = $_POST['id'];
			$proxy_ip = $_POST['proxy_ip'];
			$this->update($id, $proxy_ip);
		}

		if ( isset( $_GET['delete_proxy'] ) ) {
			$this->delete( $_GET['id'] );
		}
	}

	public function add($proxy_ip)
	{

		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->query("
				INSERT INTO
				{$table_name}
				(proxy_ip)
				VALUE
				('{$proxy_ip}')
			");
	}
	
	public function update($id, $proxy_ip)
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->query("
				UPDATE
				{$table_name}
				SET proxy_ip='{$proxy_ip}'
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

}
