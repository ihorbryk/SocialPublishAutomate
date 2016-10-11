<?php wp_nonce_field( 'spa_custom_box', 'spa_custom_box' );?>

<div class="form-field">
	<p>
		<label for="spa_custom_title"><?php _e('Custom title:', self::$text_domain);?> </label>
		<input class="widefat" type="text" name="spa_custom_title" value="<?php if (isset( $_GET['post'] )) { echo get_post_meta( $_GET['post'], 'spa_custom_title', true ); }?>">
	</p>
</div>

<div class="form-field">
	<p>
		<label for="spa_custom_message"><?php _e('Message:', self::$text_domain);?> </label>
		<textarea class="widefat" id="spa_custom_message" name="spa_custom_message" rows="5"><?php if ( isset( $_GET['post'] ) ) { echo get_post_meta( $_GET['post'], 'spa_custom_message', true ); }?></textarea>
	</p>
</div>

<div class="form-field">
	<p>
		<label for="spa_custom_description"><?php _e('Custom description:', self::$text_domain);?></label>
		<textarea class="widefat" id="spa_custom_description" name="spa_custom_description" rows="5"><?php if ( isset( $_GET['post'] ) ) { echo get_post_meta( $_GET['post'], 'spa_custom_description', true ); }?></textarea>
	</p>
</div>

<div class="form-field">
	<p>
		<label for="spa_custom_link"><?php _e('Custom link:', self::$text_domain);?></label>
		<input class="widefat" type="text" id="spa_custom_link" name="spa_custom_link" value="<?php if ( isset( $_GET['post'] ) ) { echo get_post_meta( $_GET['post'], 'spa_custom_link', true ); }?>">
	</p>
</div>
