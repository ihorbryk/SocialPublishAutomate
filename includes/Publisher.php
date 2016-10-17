<?php

class Publisher
{
	static private $instance;

	static public $triger_term_id;

	static private $subscribers = [];

	public function __construct()
	{

	}

	static public function getInstance()
	{
		if (self::$instance == NULL)
		{
			self::$instance = new Publisher();
		}

		self::$triger_term_id = get_option( 'triger_term_id' );

		add_action('save_post', array(self::$instance, 'publish_to_social_network_when_save_post')); 

		return self::$instance;
	}

	public function publish_to_social_network_when_save_post( $post_id ) {
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$upload_dir_info = wp_upload_dir();
		self::check_post( $post_id );
	}

	static public function publish( $post_id, $group_lists )
	{
		$message = get_post_meta( $post_id, 'spa_custom_message', true );

		$link = get_post_meta( $post_id, 'spa_custom_link', true );

		if ( empty( $link ) ) {
			$link = get_post_permalink( $post_id );
		}


		$name = get_post_meta( $post_id, 'spa_custom_title', true );
		if ( empty( $name ) ) {
			$name = get_the_title( $post_id );
		}

		$picture = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
		$picture = $picture[0];

		if ( empty( $picture ) ) {
			$picture = '';
		}

		$description = get_post_meta( $post_id, 'spa_custom_description', true );

		if ( empty( $description ) ) {
			$content_post = get_post($post_id);
			$content = $content_post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$description = strip_tags( $content );
		}

		foreach ( self::$subscribers as $subscriber ) {
			$subscriber->publish( $message, $link, $name, $picture, $description, $group_lists );
		}

	}

	public function subscribe( $subscriber )
	{
		self::$subscribers[] = $subscriber;
	}


	static public function check_post( $post_id )
	{
		$terms = get_terms('spa_connected_tag');
		$group_lists = array();

		foreach ($terms as $term) {
			$group_lists[] = $term->term_id;
		}

		self::publish( $post_id, $group_lists );
	}
}
