<?php
/**
Plugin Name: SocialPublishAutomate
Author: Ihor Bryk
Version: 0.0.1
*/

class SocialPublishAutomate
{
	static $instance;

	public $customers_obj;

	public static $text_domain = 'SocialPublishAutomate';

	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'register_admin_pages') );
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
