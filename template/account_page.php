<div class="wrap">

	<h1>
		<?php _e('Accounts', self::$text_domain);?>
		<a href="#TB_inline?width=400&inlineId=add_account" class="page-title-action thickbox"><?php _e('Add account', self::$text_domain);?></a>
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
								<th class="column-title column-primary"><?php _e('Social network', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Account name', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Client ID', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Client secret', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Access Token', self::$text_domain);?></th>
								<th class="column-title column-primary"></th>
							</tr>
						</thead>
						<tbody class="the-list">
							<?php $accounts = $this->account->get_all(); ?>

							<?php foreach ($accounts as $account) : ?>

							<tr class="account">
								<td class="account-id"><?php echo $account->id;?></td>
								<?php if ( $account->network == 1) : ?>
									<td class="account-network" data-network="<?php echo $account->network;?>">
										Facebook
									</td>
								<?php endif; ?>
								<?php if ( $account->network == 2) : ?>
									<td class="account-network" data-network="<?php echo $account->network;?>">
										Vk
									</td>
								<?php endif; ?>
								<td class="account-name"><?php echo $account->name;?></td>
								<td class="account-client-id"><?php echo $account->client_id;?></td>
								<td class="account-client-secret"><?php echo $account->client_secret;?></td>
								<td class="account-token"><?php echo $account->token;?></td>
								
								<td class="alignright">
									<?php $link = add_query_arg( array(
									'delete_account' => 'delete',
									'id' => $account->id,
									) ); ?>

									<a class="button account-edit thickbox" href="#TB_inline?width=400&inlineId=edit_account"><span class="dashicons dashicons-edit"></span></a>
									<a class="button" href="<?php echo $link; ?>"><span class="dashicons dashicons-trash"></span></a>
								</td>
							</tr>

							<?php endforeach; ?>
						</tbody>
					</table>
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
						<label for="network">
							<strong><?php _e('Network:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<select id="network" name="network" class="widefat">
							<option value="1">Facebook</option>
							<option value="2">Vk</option>
						</select>
					</td>
				</tr>

				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Name:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="name" class="widefat">
					</td>
				</tr>

				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('App id:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="client_id" class="widefat">
					</td>
				</tr>

				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('App secret:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="client_secret" class="widefat">
					</td>
				</tr>

				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Token:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<textarea type="text" name="token" class="widefat" rows="4"></textarea>
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

<div id="edit_account" style="display:none;">
	<p>
		<h2>Edit account</h2>
		<form  method="post">
			<input type="hidden" name="update_spa_account">
			<input type="hidden" id="edit_account_id" name="account_id" value="">
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
							<strong><?php _e('Name:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input id="edit_name" type="text" name="name" class="widefat">
					</td>
				</tr>

				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('App id:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input id="edit_client_id" type="text" name="client_id" class="widefat">
					</td>
				</tr>

				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('App secret:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input id="edit_client_secret" type="text" name="client_secret" class="widefat">
					</td>
				</tr>

				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Token:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<textarea id="edit_token" type="text" name="token" class="widefat" rows="4"></textarea>
					</td>
				</tr>
				
				<tr>
					<td></td>
					<td>
						<input type="submit" value="<?php _e('Update', self::$text_domain);?>">
					</td>
				</tr>
			</table>
		</form>
	</p>
</div>
