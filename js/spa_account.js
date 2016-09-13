jQuery('document').ready(function($) {

	$('body').on('click', '.account-edit', function() {
		var accountId = $('.account-id', $(this).parents('.account')).text();
		var socialNetwork = $('.account-network', $(this).parents('.account')).data('network');
		var accountName = $('.account-name', $(this).parents('.account')).text();
		var clientId = $('.account-client-id', $(this).parents('.account')).text();
		var clientSecret = $('.account-client-secret', $(this).parents('.account')).text();
		var accountToken = $('.account-token', $(this).parents('.account')).text();

		console.log( socialNetwork );

		$('#edit_account_id').val( accountId );
		$('#edit_network').val( socialNetwork );
		$('#edit_name').val( accountName );
		$('#edit_client_id').val( clientId );
		$('#edit_client_secret').val( clientSecret );
		$('#edit_token').val( accountToken );
	});
});
