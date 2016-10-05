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
	public $publisher;

	/**
	 * SocialPublishAutomate constructor.
	 */
	public function __construct()
	{
		require_once 'includes/Account.php';
		$this->account = new Account();

		require_once 'includes/Group.php';
		$this->group = new Group();

		require_once 'includes/Proxy.php';
		$this->proxy = new Proxy();

		/* Include publishers */
		require_once 'includes/Publisher.php';
		require_once 'includes/Publisher_facebook.php';

		/* uncoment when work with vk.com */
		/* require_once 'includes/Publisher_vk.php'; */

		add_action( 'admin_menu', array( $this, 'register_admin_pages') );
		add_action( 'add_meta_boxes', array( $this, 'add_custom_box' ));
		add_action( 'save_post', array( $this, 'save_custom_post_data' ), 1);

		register_activation_hook(__FILE__, function () {

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			$sql = "CREATE TABLE " . Account::$table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name tinytext NOT NULL,
				client_id text NOT NULL,
				client_secret text NOT NULL,
				code text NOT NULL,
				token text NOT NULL,
				token_expires text NOT NULL,
				network int NOT NULL,
				UNIQUE KEY (id)
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . Group::$table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name tinytext NOT NULL,
				group_id text NOT NULL,
				network int NOT NULL,
				UNIQUE KEY (id)
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . Proxy::$table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				proxy_ip tinytext NOT NULL,
				UNIQUE KEY (id)
			);";
			dbDelta($sql);

		});

		if ( isset( $_POST['save_spa_settings'] ) ) {
			update_option( 'triger_term_id', $_POST['triger_term_id'] );
			$time_period = intval( $_POST['time_period'] );
			update_option( 'time_period', $time_period );
		}

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

		$accounts = add_submenu_page(
			'spa_main_page.php',
			__('Accounts', self::$text_domain),
			__('Accounts', self::$text_domain),
			'manage_options',
			'spa_accounts_page.php',
			array($this, 'account_page_render')
		);
		$groups = add_submenu_page(
			'spa_main_page.php',
			__('Groups', self::$text_domain),
			__('Groups', self::$text_domain),
			'manage_options',
			'spa_groups_page.php',
			array($this, 'group_page_render')
		);
		$token = add_submenu_page(
			null,
			__('Get token', self::$text_domain),
			__('Get token', self::$text_domain),
			'manage_options',
			'spa_get_token.php',
			array($this, 'token_render')
		);
		$proxy = add_submenu_page(
			'spa_main_page.php',
			__('Proxy', self::$text_domain),
			__('Proxy', self::$text_domain),
			'manage_options',
			'spa_proxy.php',
			array($this, 'proxy_render')
		);
	}

	/**
	 * Render main page template
	 */
	public function main_page_render()
	{
		add_thickbox();
		require_once('template/main_page.php');
	}

	/**
	 * Render account page template
	 */
	public function account_page_render()
	{
		add_thickbox();
		wp_enqueue_style('spa_account', plugin_dir_url( __FILE__ ) . 'css/spa_account.css');
		wp_enqueue_script('spa_account', plugin_dir_url( __FILE__ ) . 'js/spa_account.js', array('jquery'));
		require_once('template/account_page.php');
	}

	/**
	 * Render group page template
	 */
	public function group_page_render()
	{
		add_thickbox();
		wp_enqueue_script('spa_group', plugin_dir_url( __FILE__ ) . 'js/spa_group.js', array('jquery'));
		require_once('template/group.php');
	}

	/**
	 * Render token page template
	 */
	public function token_render()
	{
		wp_enqueue_script('spa_token', plugin_dir_url( __FILE__ ) . 'js/spa_token.js', array('jquery'));
		require_once('template/token.php');
	}

	/**
	 * Render proxy page template
	 */
	public function proxy_render()
	{
		add_thickbox();
		wp_enqueue_script('spa_proxy', plugin_dir_url( __FILE__ ) . 'js/spa_proxy.js', array('jquery'));
		require_once('template/proxy.php');
	}

	/**
	 * Get all termr
	 *
	 * @return array
	 *
	 */
	public function get_terms()
	{
		$terms = get_terms(array(
			'hide_empty' => false
		));

		$out = [];

		foreach ($terms as $term) {
			$out[] = ['id' => $term->term_id, 'name' => $term->name];
		}

		return $out;
	}

	public function add_custom_box()
	{
		$screens = array( 'post', 'page'  );
		foreach ( $screens as $screen  ) {
			add_meta_box( 'spa_section', __('Social Publisher Automate', self::$text_domain), array( $this, 'render_meta_box' ), $screen  );
		}
	}

	public function render_meta_box()
	{
		require_once 'template/metabox.php';
	}

	public function save_custom_post_data( $post_id )
	{
		// проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
		if ( ! isset( $_POST['spa_custom_box'] ) || ! wp_verify_nonce( $_POST['spa_custom_box'], 'spa_custom_box' )  ) {
			return $post_id;
		}

		// проверяем, если это автосохранение ничего не делаем с данными нашей формы.
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) {
			return $post_id;
		}

		// проверяем разрешено ли пользователю указывать эти данные
		if ( 'page' == $_POST['post_type'] && ! current_user_can( 'edit_page', $post_id  )  ) {
			return $post_id;
		} elseif( ! current_user_can( 'edit_post', $post_id  )  ) {
			return $post_id;
		}

		// Убедимся что поле установлено.
		if ( isset( $_POST['spa_custom_title'] )  ) {
			$title = sanitize_text_field( $_POST['spa_custom_title']  );
			update_post_meta( $post_id, 'spa_custom_title', $title  );
		}

		if ( isset( $_POST['spa_custom_description'] ) ) {
			$description = sanitize_text_field( $_POST['spa_custom_description']  );
			update_post_meta( $post_id, 'spa_custom_description', $description  );
		}
		
		if ( isset( $_POST['spa_custom_message'] ) ) {
			$message = sanitize_text_field( $_POST['spa_custom_message']  );
			update_post_meta( $post_id, 'spa_custom_message', $message  );
		}
	}
}

new SocialPublishAutomate();

?>
