<?php
/**
Plugin Name: SocialPublishAutomate
Author: Ihor Bryk
Version: 0.0.1
*/

class SocialPublishAutomate
{
	public static $text_domain = 'SocialPublishAutomate';

	public $account;
	public $group;

	public function __construct()
	{
		require_once 'includes/Account.php';
		$this->account = new Account();

		require_once 'includes/Group.php';
		$this->group = new Group();

		add_action( 'admin_menu', array( $this, 'register_admin_pages') );

		register_activation_hook(__FILE__, function () {

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			$sql = "CREATE TABLE " . $this->account->table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name tinytext NOT NULL,
				account_id text NOT NULL,
				token text NOT NULL,
				UNIQUE KEY id (id)

			);";

			dbDelta($sql);

			$sql = "CREATE TABLE " . $this->group->table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name tinytext NOT NULL,
				group_id text NOT NULL,
				UNIQUE KEY id (id)

			);";

			dbDelta($sql);
		});

	}

	/**
	 * Register admin pages
	 *
	 */
	public function register_admin_pages()
	{
		$hook = add_menu_page(
			__('SPA', self::$text_domain),
			__('SPA', self::$text_domain),
			'manage_options',
			'spa_main_page.php',
			array($this, 'main_page_render')
		);
	}

	/**
	 * Render main page template
	 *
	 */
	public function main_page_render()
	{
		add_thickbox();
		require_once('template/main_page.php');
	}

	/**
	 * Get all termr
	 *
	 * @return array
	 *
	 */
	public function get_terms()
	{
		$terms = get_terms();

		$out = [];

		foreach ($terms as $term) {
			$out[] = ['id' => $term->term_id, 'name' => $term->name];
		}

		return $out;
	}
}

new SocialPublishAutomate();

?>
