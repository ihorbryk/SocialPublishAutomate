<div class="wrap">

	<h1>
		<?php _e('Groups lists', self::$text_domain);?>
		<a href="#TB_inline?width=400&height=250&inlineId=add_group_list" class="page-title-action thickbox">+ <?php _e('Add list', self::$text_domain);?></a>
	</h1>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-3">
			<div id="post-body-content" style="position: relative;">
				<div class="meta-box-sortables ui-sortable">
					<div class="tablenav top">
						<div class="alignleft actions">
						</div>
					</div>
					<table class="wp-list-table widefat fixed striped">
						<thead>
							<tr>
								<th class="column-title column-primary" style="width: 30px;">#</th>
								<th class="column-title column-primary"><?php _e('List name', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Connected tag', self::$text_domain);?></th>
								<th class="column-title column-primary"></th>
								<th class="column-title column-primary"></th>
							</tr>
						</thead>
						<tbody class="the-list">
							<?php $lists = $this->group_lists->get_all(); ?>

							<?php
							$counter = 1;
							foreach ($lists as $list) : ?>

							<tr class="group-list">
								<td class="group-list-id" data-group-list-id="<?php echo $list->id;?>"><?php echo $counter;?></td>
								<td class="group-list-name"><?php echo $list->name;?></td>
								<td class="group-list-connected-tag">
									<?php
										$term = get_term( $list->connected_tag_id );
										if ( !is_wp_error($term) ) {
											echo $term->name;
										} else {
											echo 'Error term not find';
										}
									?>
								</td>
								<td class="group-list-view-groups">
									<?php $link = add_query_arg( array(
									'page' => 'spa_groups_page.php',
									'group_list' => $list->id,
									) ); ?>
										<a class="button" href="<?php echo $link; ?>">View groups</a>
								</td>
								
								<td class="alignright">

									<a class="button group-list-edit thickbox" href="#TB_inline?width=400&inlineId=edit_group_list"><span class="dashicons dashicons-edit"></span></a>
									<form method="post" style="display:inline-block;">
										<input type="hidden" name="delete_spa_group_list" value="delete">
										<input type="hidden" name="id" value="<?php echo $list->id; ?>">
										<button class="button"><span class="dashicons dashicons-trash"></button>
									</form>
								</td>
							</tr>

							<?php
							$counter++;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="add_group_list" style="display:none;">
	<p>
		<h2>Add list</h2>
		<form  method="post">
			<input type="hidden" name="add_spa_group_list">
			<table class="widefat">
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('List name:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="name">
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Connected tag name:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="connected_tag_name">
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input class="button button-primary" type="submit" value="<?php _e('Save', self::$text_domain);?>">
					</td>
				</tr>
			</table>
		</form>
	</p>
</div>

<div id="edit_group_list" style="display:none;">
	<p>
		<h2>Edit list</h2>
		<form  method="post">
			<input type="hidden" name="update_spa_group_list">
			<input type="hidden" name="id" id="edit_id">
			<table class="widefat">
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('List name:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input id="edit_group_list_name" type="text" name="name">
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Connected tag name:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" id="edit_connected_tag_name" name="connected_tag_name">
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input class="button button-primary" type="submit" value="<?php _e('Update', self::$text_domain);?>">
					</td>
				</tr>
			</table>
		</form>
	</p>
</div>
