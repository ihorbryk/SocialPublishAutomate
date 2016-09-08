<div class="wrap">
	<h1><?php _e('SocialPublishAutomate', self::$text_domain);?></h1>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<div id="post-body-content" style="position: relative;">
				<div class="meta-box-sortables ui-sortable">
					<div class="tablenav top">
						<div class="alignleft actions">
							<a href="#TB_inline?width=400&height=250&inlineId=my-content-id" class="button button-primary thickbox">+ <?php _e('Add account', self::$text_domain);?></a>
						</div>
					</div>
					<table class="wp-list-table widefat fixed striped">
						<thead>
							<tr>
								<th class="column-title column-primary">#</th>
								<th class="column-title column-primary"><?php _e('User id', self::$text_domain);?></th>
							</tr>
						</thead>
						<tbody class="the-list">
							<tr>
								<td>Hello</td>
							</tr>
							<tr>
								<td>world</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div id="postbox-container-1" class="postbox-container">
				<div class="postbox">
				<H2 class="hndle"><?php _e('Settings', self::$text_domain);?></H2>
					<div class="inside">
						<?php $terms = $this->get_terms(); ?>
						
						<p>
							<label>
								<strong><?php _e('Select tag:', self::$text_domain);?></strong>
							</label>
							
							<select id="" name="">
								<?php foreach ($terms as $term) : ?>
								<option value="<?php echo $term['id'];?>"><?php echo $term['name'];?></option>
								<?php endforeach; ?>
							</select>
						</p>

						<p>
							<label for="">
								<strong><?php _e('Time period (in sec)', self::$text_domain);?></strong>
							</label>

							<input type="text" name="time_period">
						</p>
					</div>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>	
</div>

<div id="my-content-id" style="display:none;">
	<p>
		<table class="widefat">
			<tr>
				<td class="alignright">
					<label for="">
						<strong><?php _e('User id:', self::$text_domain);?></strong>
					</label>
				</td>
				<td>
					<input type="text" name="user_id">
				</td>
			</tr>
			<tr>
				<td class="alignright">
					<label for="">
						<strong><?php _e('User tocken:', self::$text_domain);?></strong>
					</label>
				</td>
				<td>
					<input type="text" name="token">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="<?php _e('Save', self::$text_domain);?>">
				</td>
			</tr>
		</table>
	</p>
</div>
