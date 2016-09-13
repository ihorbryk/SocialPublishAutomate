<div class="wrap">
	<h1><?php _e('Social Publish Automate', self::$text_domain);?></h1>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-3">
			<div id="post-body-content" style="position: relative;">
				
				<div class="postbox">
					<H2 class="hndle"><?php _e('Settings', self::$text_domain);?></H2>
					<div class="inside">

						<?php $link = add_query_arg( array(
						'page' => 'spa_main_page.php',
						) ); ?>

						<form method="post" action="<?php echo $link;?>">

							<input type="hidden" name="save_spa_settings">

							<?php $terms = $this->get_terms(); ?>

							<p>
								<label>
									<strong><?php _e('Select tag:', self::$text_domain);?></strong>
								</label>

								<select id="" name="triger_term_id">
									<?php foreach ($terms as $term) : ?>
									<option value="<?php echo $term['id'];?>" <?php selected($term['id'], get_option('triger_term_id')); ?>><?php echo $term['name'];?></option>
									<?php endforeach; ?>
								</select>
							</p>

							<p>
								<label for="">
									<strong><?php _e('Time period to post (in sec)', self::$text_domain);?></strong>
								</label>

								<input type="text" name="time_period" value="<?php if ( null !== get_option('time_period') ) { echo get_option('time_period'); }?>">
							</p>

							<p>
								<input type="submit" class="button button-primary" value="<?php _e('Save', self::$text_domain);?>">
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>	
</div>
