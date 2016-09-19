<div class="wrap">

	<h1>
		<?php _e('Proxy', self::$text_domain);?>
		<a href="#TB_inline?width=400&height=250&inlineId=add_group" class="page-title-action thickbox">+ <?php _e('Add proxy', self::$text_domain);?></a>
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
								<th class="column-title column-primary"><?php _e('Social work', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Group name', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Group ID', self::$text_domain);?></th>
								<th class="column-title column-primary"></th>
							</tr>
						</thead>
						<tbody class="the-list">
							<?php $groups = $this->group->get_all(); ?>

							<?php
							$counter = 1;
							foreach ($groups as $group) : ?>

							<tr class="group">
								<td class="group-id" data-group-id="<?php echo $group->id;?>"><?php echo $counter;?></td>
								<?php if ( $group->network == 1) : ?>
									<td class="group-network" data-network="<?php echo $group->network;?>">
										Facebook
									</td>
								<?php endif; ?>
								<?php if ( $group->network == 2) : ?>
									<td class="group-network" data-network="<?php echo $group->network;?>">
										Vk
									</td>
								<?php endif; ?>
								<td class="group-name"><?php echo $group->name;?></td>
								<td class="group-page-id"><?php echo $group->group_id;?></td>
								
								<td class="alignright">
									<?php $link = add_query_arg( array(
									'delete_group' => 'delete',
									'id' => $group->id,
									) ); ?>

									<a class="button group-edit thickbox" href="#TB_inline?width=400&inlineId=edit_group"><span class="dashicons dashicons-edit"></span></a>
									<a class="button" href="<?php echo $link; ?>"><span class="dashicons dashicons-trash"></span></a>
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

<div id="add_group" style="display:none;">
	<p>
		<h2>Add group</h2>
		<form  method="post">
			<input type="hidden" name="add_spa_group">
			<table class="widefat">
				<tr>
					<td class="alignright">
						<label for="network">
							<strong><?php _e('Network:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<select id="network" name="network">
							<option value="1">Facebook</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Group name:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="name">
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Group ID:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="group_id">
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

<div id="edit_group" style="display:none;">
	<p>
		<h2>Edit group</h2>
		<form  method="post">
			<input type="hidden" name="update_spa_group">
			<input type="hidden" name="id" id="edit_id">
			<table class="widefat">
				<tr>
					<td class="alignright">
						<label for="network">
							<strong><?php _e('Network:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<select id="edit_network" name="network" class="widefat">
							<option value="1">Facebook</option>
							<option value="2">Vk</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Group name:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input id="edit_group_name" type="text" name="name" class="widefat">
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Group ID:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input id="edit_group_id" type="text" name="group_id" class="widefat">
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