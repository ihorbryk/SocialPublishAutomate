<?php

class Group_lists
{
	static public $table_name = 'spa_lists';
	static public $id;
	static public $name;
	static public $connected_tag_name;
	static public $term_id;

	public function __construct()
	{
		add_action('init', function () {
			register_taxonomy( 'spa_connected_tag', 'post', array(
				'labels' => array(
					'name' => __('Group lists', SocialPublishAutomate::$text_domain),
					'singular_name' => __('Group list', SocialPublishAutomate::$text_domain),
					'choose_from_most_used' => __('Choose from most used lists', SocialPublishAutomate::$text_domain),
					'not_found' => __('Lists not found', SocialPublishAutomate::$text_domain),
					'separate_items_with_commas' => __('Lists separate items with commas', SocialPublishAutomate::$text_domain),
				),
				'public' => true,
				'show_in_menu' => false,
				'hierarchical' => true
			));
		}, 0);


		if ( isset( $_POST['add_spa_group_list'] ) ) {
			$name = $_POST['name'];
			$connected_tag_name = $_POST['connected_tag_name'];

			$this->add($name, $connected_tag_name);
		}

		if ( isset( $_POST['update_spa_group_list'] ) ) {
			$id = $_POST['id'];
			$name = $_POST['name'];
			$connected_tag_name = $_POST['connected_tag_name'];

			$this->update($id, $name, $connected_tag_name);
		}

		if ( isset( $_POST['delete_spa_group_list'] ) ) {
			$this->delete( $_POST['id'] );
			unset($_POST['delete_spa_group_list']);
			unset($_POST['id']);
		}

	}

	/**
	 * Add new account to database
	 *
	 */
	public function add($name, $connected_tag_name)
	{

		self::$name = $name;
		self::$connected_tag_name = sanitize_text_field( $connected_tag_name );

		add_action('init', function() {
			$term_id = wp_insert_term(Group_lists::$connected_tag_name, 'spa_connected_tag');

			if ( is_wp_error($term_id) ) {
				if ( isset( $term_id->error_data['term_exists'] ) ) {
					add_action( 'admin_notices', function() {
						$class = 'notice notice-error';
						$message = __( 'Error. List with this connected tag is created before', SocialPublishAutomate::$text_domain  );
						printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message  ); 
					});

					return;
				}
			} 

			if ( is_array($term_id) ) {
				$term_id = $term_id['term_id'];
			}

			global $wpdb;
			$table_name = self::$table_name;
			$name = self::$name;
			$result = $wpdb->query("
					INSERT INTO
					{$table_name}
					(name, connected_tag_id)
					VALUE
					('{$name}', '{$term_id}')
				");
		});

	}
	
	/**
	 * Update
	 *
	 * @param mixed $id
	 * @param mixed $name
	 */
	public function update($id, $name, $connected_tag_name)
	{
		
		self::$id = $id;
		self::$name = $name;
		self::$connected_tag_name = $connected_tag_name;
		self::$term_id = intval($this->get_term_by_list_id($id));

		add_action('init', function() {
			$id = Group_lists::$id;
			$name = Group_lists::$name;
			$connected_tag_name = Group_lists::$connected_tag_name;
			$term_id = Group_lists::$term_id;

			$result = wp_update_term($term_id, 'spa_connected_tag', array(
				'name' => $connected_tag_name,
			));

			if (!is_wp_error($result)) {
				global $wpdb;
				$table_name = self::$table_name;
				$result = $wpdb->query("
					UPDATE
					{$table_name}
					SET name='{$name}'
					WHERE id = {$id}
				");
			} else {
				add_action( 'admin_notices', function() {
					$class = 'notice notice-error';
					$message = __( 'Error. Update operation complete with errors', SocialPublishAutomate::$text_domain  );
					printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message  ); 
				});
			}
		});
	}

	public function delete( $id )
	{

		self::$term_id = intval($this->get_term_by_list_id($id));
		self::$id = $id;

		add_action('init', function() {
			$term_id = Group_lists::$term_id;
			$id = Group_lists::$id;

			$result = wp_delete_term($term_id, 'spa_connected_tag');

			if (!is_wp_error($result)) {
				global $wpdb;
				$table_name = self::$table_name;
				$wpdb->query("DELETE FROM {$table_name} WHERE id = {$id}");
			} else {
				add_action( 'admin_notices', function() {
					$class = 'notice notice-error';
					$message = __( 'Error. Delete operation complete with errors', SocialPublishAutomate::$text_domain  );
					printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message  ); 
				});
			}
		});
	}

	public function get_all()
	{
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_results("SELECT * FROM {$table_name}");
		return $result;
	}

	public function get_term_by_list_id($list_id) {
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_var("SELECT connected_tag_id FROM {$table_name}");
		return $result;
	}

	public static function get_name_by_id($id) {
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_var("SELECT name FROM {$table_name}");
		return $result;
	}

	public static function get_id_by_connected_tag_id($id) {
		global $wpdb;
		$table_name = self::$table_name;
		$result = $wpdb->get_var("SELECT id FROM {$table_name}");
		return $result;
	}
}
