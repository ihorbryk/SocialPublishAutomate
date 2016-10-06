<div class="wrap">

	<h1>
		<?php _e('Accounts', self::$text_domain);?>
		<a href="#TB_inline?width=400&inlineId=add_account_fb" class="page-title-action thickbox"><?php _e('Add Facebook account', self::$text_domain);?></a>
		<a href="#TB_inline?width=400&inlineId=add_account_in" class="page-title-action thickbox"><?php _e('Add LinkedIn account', self::$text_domain);?></a>
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
								<th class="column-title column-primary"><?php _e('Access code', self::$text_domain);?></th>
								<th class="column-title column-primary"><?php _e('Access token', self::$text_domain);?></th>
								<!-- <th class="column-title column-primary"><?php _e('Token expires', self::$text_domain);?></th> -->
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
										<strong>Facebook</strong>
									</td>
								<?php endif; ?>
								<?php if ( $account->network == 2) : ?>
									<td class="account-network" data-network="<?php echo $account->network;?>">
										<strong>Vk</strong>
									</td>
								<?php endif; ?>
								<?php if ( $account->network == 3) : ?>
									<td class="account-network" data-network="<?php echo $account->network;?>">
										<strong>LinkedIn</strong>
									</td>
								<?php endif; ?>
								<td class="account-name"><?php echo $account->name;?></td>
								<td class="account-client-id"><?php echo $account->client_id;?></td>
								<td class="account-client-secret"><?php echo $account->client_secret;?></td>
								<td class="account-code"><?php echo $account->code;?></td>
								<td class="account-token">
									<?php if ( empty($account->token) ) : ?>
										<?php
										if ( $account->network == 1) {
											$link = add_query_arg( array(
												'get_facebook_token' => 'true',
												'id' => $account->id,
											) );
										}
										if ( $account->network == 2) {
											$link = add_query_arg( array(
												'get_facebook_token' => 'true',
												'id' => $account->id,
											) );
										}
										if ( $account->network == 3) {
											$link = add_query_arg( array(
												'get_linkedin_token' => 'true',
												'id' => $account->id,
											) );
										}
										?>
										<a href="<?php echo $link; ?>" class="button">Get token</a>
									<?php else : ?>
										<?php echo $account->token; ?>
									<?php endif; ?>
								</td>
								<!-- <?php if ( intval($account->token_expires) != 0 ) : ?>
									<td class="account-token-expires"><?php echo date('d-m-Y H:i:s', intval($account->token_expires));?></td>
								<?php else : ?>
									<td class="account-token-expires"></td>
								<?php endif; ?> -->
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

<!-- Facebook account -->
<div id="add_account_fb" style="display:none;">
	<p>
		<h2>Add Facebook account</h2>

		<form  method="post">
			<input type="hidden" name="add_spa_account">
			<input type="hidden" name="network" value="1">
			<table class="widefat">
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
						<input type="text" id="client_id" name="client_id" class="widefat">
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
					<td> </td>
					<td>
						<button type="button" class="button hide login-button" id="login_fb"><?php _e('Authorize', self::$text_domain);?></button>
					</td>
				</tr>

				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Code:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="code" class="widefat">
					</td>
				</tr>

				<!-- <tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Token:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<textarea type="text" name="token" class="widefat" rows="4"></textarea>
					</td>
				</tr> -->
				
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
							<strong><?php _e('Code:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="code" class="widefat">
					</td>
				</tr>

				<!-- <tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Token:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<textarea id="edit_token" type="text" name="token" class="widefat" rows="4"></textarea>
					</td>
				</tr> -->
				
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
<!-- End facebook -->

<!-- LinkedIn -->
<div id="add_account_in" style="display:none;">
	<p>
		<h2>Add LinkedIn account</h2>

		<form  method="post">
			<input type="hidden" name="add_spa_account">
			<input type="hidden" name="network" value="3">
			<table class="widefat">
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
						<input type="text" id="client_id" name="client_id" class="widefat">
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
					<td> </td>
					<td>
						<button type="button" class="button hide login-button" id="login_in"><?php _e('Authorize', self::$text_domain);?></button>
					</td>
				</tr>

				<tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Code:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<input type="text" name="code" class="widefat">
					</td>
				</tr>

				<!-- <tr>
					<td class="alignright">
						<label for="">
							<strong><?php _e('Token:', self::$text_domain);?></strong>
						</label>
					</td>
					<td>
						<textarea type="text" name="token" class="widefat" rows="4"></textarea>
					</td>
				</tr> -->
				
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
<!-- End LinkedIn -->
