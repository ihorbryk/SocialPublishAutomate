<div class="wrap">
	<h1><?php _e('SocialPublishAutomate', self::$text_domain);?></h1>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<h2><?php _e('Accounts', self::$text_domain);?></h2>
			<div id="post-body-content" style="position: relative;">
				<div class="meta-box-sortables ui-sortable">
					<div class="tablenav top">
						<div class="alignleft actions">
							<a href="#TB_inline?width=400&inlineId=add_account" class="button button-primary thickbox">+ <?php _e('Add account', self::$text_domain);?></a>
						</div>
					</div>
					<table class="wp-list-table widefat fixed striped">
						<thead>
							<tr>
								<th class="column-title column-primary">#</th>
								<th class="column-title column-primary"><?php _e('Account name', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Access ID', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Access Token', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Social network', self::$text_domain);?></th>
								<th class="column-title column-primary"></th>
							</tr>
						</thead>
						<tbody class="the-list">
							<?php $accounts = $this->account->get_all(); ?>

							<?php foreach ($accounts as $account) : ?>

								<tr>
									<td><?php echo $account->id;?></td>
									<td><?php echo $account->name;?></td>
									<td><?php echo $account->account_id;?></td>
									<td><?php echo $account->token;?></td>
									<td>
										<?php if ( $account->network == 1) : ?>
											Facebook
										<?php endif; ?>
										<?php if ( $account->network == 2) : ?>
											Vk
										<?php endif; ?>
									</td>
									<td class="alignright">
										<?php $link = add_query_arg( array(
											'delete_account' => 'delete',
											'id' => $account->id,
										) ); ?>

										<a class="button" href="<?php echo $link; ?>"><span class="dashicons dashicons-trash"></span></a>
									</td>
								</tr>

							<?php endforeach; ?>
						</tbody>
					</table>
				</div>


				<h2><?php _e('Groups', self::$text_domain);?></h2>
				<div class="meta-box-sortables ui-sortable">
					<div class="tablenav top">
						<div class="alignleft actions">
							<a href="#TB_inline?width=400&height=250&inlineId=add_group" class="button button-primary thickbox">+ <?php _e('Add account', self::$text_domain);?></a>
						</div>
					</div>
					<table class="wp-list-table widefat fixed striped">
						<thead>
							<tr>
								<th class="column-title column-primary">#</th>
								<th class="column-title column-primary"><?php _e('Group name', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Group ID', self::$text_domain);?></th>
								<th class="column-title column-primary"></th>
							</tr>
						</thead>
						<tbody class="the-list">
							<?php $groups = $this->group->get_all(); ?>

							<?php foreach ($groups as $group) : ?>

								<tr>
									<td><?php echo $group->id;?></td>
									<td><?php echo $group->name;?></td>
									<td><?php echo $group->group_id;?></td>
									<td>
										<?php if ( $group->network == 1) : ?>
											Facebook
										<?php endif; ?>
										<?php if ( $group->network == 2) : ?>
											Vk
										<?php endif; ?>
									</td>
									<td class="alignright">
										<?php $link = add_query_arg( array(
											'delete_group' => 'delete',
											'id' => $group->id,
										) ); ?>

										<a class="button" href="<?php echo $link; ?>"><span class="dashicons dashicons-trash"></span></a>
									</td>
								</tr>

							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

			<div id="postbox-container-1" class="postbox-container">
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
									<option value="<?php echo $term['id'];?>"><?php echo $term['name'];?></option>
									<?php endforeach; ?>
								</select>
							</p>

							<p>
								<label for="">
									<strong><?php _e('Time period (in sec)', self::$text_domain);?></strong>
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

<div id="add_account" style="display:none;">
	<p>
		<h2>Add account</h2>
		<form  method="post">
			<input type="hidden" name="add_spa_account">
			<table class="widefat">
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Name:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="name">
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('ID:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="account_id">
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Token:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="token">
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="network">
							<strong><?php _e('Network:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<select id="network" name="network">
							<option value="1">Facebook</option>
							<option value="2">Vk</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="<?php _e('Save', self::$text_domain);?>">
					</td>
				</tr>
				
			</table>
		</form>
	</p>
</div>

<div id="add_group" style="display:none;">
	<p>
		<h2>Add group</h2>
		<form  method="post">
			<input type="hidden" name="add_spa_group">
			<table class="widefat">
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
							<strong><?php _e('ID:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="group_id">
					</td>
				</tr>
				<tr>
					<td class="alignright">
						<label for="network">
							<strong><?php _e('Network:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<select id="network" name="network">
							<option value="1">Facebook</option>
							<option value="2">Vk</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="<?php _e('Save', self::$text_domain);?>">
					</td>
				</tr>
			</table>
		</form>
	</p>
</div>
