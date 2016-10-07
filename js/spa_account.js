jQuery('document').ready(function($) {

	$('body').on('click', '.account-edit', function() {
		var accountId = $('.account-id', $(this).parents('.account')).text();
		var socialNetwork = $('.account-network', $(this).parents('.account')).data('network');
		var accountName = $('.account-name', $(this).parents('.account')).text();
		var clientId = $('.account-client-id', $(this).parents('.account')).text();
		var clientSecret = $('.account-client-secret', $(this).parents('.account')).text();
		var accountCode = $('.account-code', $(this).parents('.account')).text();
		var accountToken = $('.account-token', $(this).parents('.account')).text();

		if (socialNetwork == 1) {
			$('#edit_token').parents('tr').hide();
			$('.edit_login_fb').show();
		} else {
			$('#edit_token').parents('tr').show();
			$('.edit_login_fb').hide();
		}

		if (socialNetwork == 2) {
			$('#edit_code').parents('tr').hide();
			$('.edit_login_vk').show();
		} else {
			$('#edit_code').parents('tr').show();
			$('.edit_login_vk').hide();
		}
		

		$('#edit_account_id').val( accountId );
		$('#edit_network').val( socialNetwork );
		$('#edit_false_network').val( socialNetwork );
		$('#edit_name').val( accountName );
		$('#edit_client_id').val( clientId );
		$('#edit_client_secret').val( clientSecret );
		$('#edit_code').val( accountCode );
		$('#edit_token').val( accountToken.trim() );
	});


	$('input[name="client_id"]').on('change', function(){
		console.log('Put cliend_id in field');
		if ( $(this).val().length > 1 ) {
			$('.login-button', $(this).parents('form')).removeClass('hide');
		}
	});

	$('#login_fb').on('click', function() {
		var app_id = $('#client_id', $(this).parents('form')).val();

		var url = 'https://www.facebook.com/dialog/oauth';
		url += '?client_id=' + app_id;
		url += '&redirect_uri=http://' + window.location.hostname + '/wp-admin/admin.php?page=spa_get_token.php';
		url += '&scope=publish_actions';

		window.open(url, '_blank');
	});

	
	$('#login_in').on('click', function() {
		var app_id = $('#client_id', $(this).parents('form')).val();

		var url = 'https://www.linkedin.com/uas/oauth2/authorization';
		url += '?client_id=' + app_id;
		url += '&response_type=code';
		url += '&state=' + Date.now();
		url += '&redirect_uri=http://' + window.location.hostname + '/wp-admin/admin.php?page=spa_get_token.php';

		window.open(url, '_blank');
	});
	
	$('#login_vk').on('click', function() {
		var app_id = $('#client_id', $(this).parents('form')).val();

		var url = 'https://oauth.vk.com/authorize';
		url += '?client_id=' + app_id;
		url += '&response_type=token';
		url += '&redirect_uri=https://oauth.vk.com/blank.html';
		url += '&scope=wall,offline';
		url += '&revoke=1';

		window.open(url, '_blank');
	});


	$('.delete').on('click', function(event) {
		result = confirm('Delete this account?');
		if (!result) {
			event.preventDefault();
		}
	});
});


