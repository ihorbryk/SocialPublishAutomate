<div class="wrap">

	<h1>
		<?php _e('Proxy', self::$text_domain);?>
		<a href="#TB_inline?width=400&height=250&inlineId=add_proxy" class="page-title-action thickbox">+ <?php _e('Add proxy', self::$text_domain);?></a>
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
								<th class="column-title column-primary"><?php _e('IP', self::$text_domain);?></th>
								<th class="column-title column-primary"></th>
							</tr>
						</thead>
						<tbody class="the-list">
							<?php $proxy = $this->proxy->get_all(); ?>

							<?php
							$counter = 1;
							foreach ($proxy as $ip) : ?>

							<tr class="proxy">
								<td class="proxy-id" data-proxy-id="<?php echo $ip->id;?>"><?php echo $counter;?></td>
								<td class="proxy-ip"><?php echo $ip->proxy_ip;?></td>
								
								<td class="alignright">
									<?php $link = add_query_arg( array(
									'delete_proxy' => 'delete',
									'id' => $ip->id,
									) ); ?>

									<a class="button proxy-edit thickbox" href="#TB_inline?width=400&height=250&inlineId=edit_proxy"><span class="dashicons dashicons-edit"></span></a>
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

<div id="add_proxy" style="display:none;">
	<p>
		<h2>Add proxy</h2>
		<form  method="post">
			<input type="hidden" name="add_spa_proxy">
			<table class="widefat">
				<tr>
					<td class="alignright">
						<label for="proxy_ip">
							<strong><?php _e('IP:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" id="proxy_ip" name="proxy_ip">
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

<div id="edit_proxy" style="display:none;">
	<p>
		<h2>Edit proxy</h2>
		<form  method="post">
			<input type="hidden" name="update_spa_proxy">
			<input type="hidden" name="id" id="edit_proxy_id">
			<table class="widefat">
				<tr>
					<td class="alignright">
						<label for="proxy_ip">
							<strong><?php _e('IP:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" id="edit_proxy_ip" name="proxy_ip" class="widefat">
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
