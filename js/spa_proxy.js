jQuery('document').ready(function($) {

	$('body').on('click', '.proxy-edit', function() {
		var proxyId = $('.proxy-id', $(this).parents('.proxy')).data('proxy-id');
		var proxyIP = $('.proxy-ip', $(this).parents('.proxy')).text();

		console.log( proxyId, proxyIP );

		$('#edit_proxy_id').val( proxyId );
		$('#edit_proxy_ip').val( proxyIP );
	});


	$('input[name="client_id"]').on('change', function(){
		if ( $(this).val().length > 1 ) {
			$('#login_fb').removeClass('hide');
		}
	});

	$('#login_fb').on('click', function() {
		var app_id = $('#client_id').val();

		var url = 'https://www.facebook.com/dialog/oauth';
		url += '?client_id=' + app_id;
		url += '&redirect_uri=http://' + window.location.hostname + '/wp-admin/admin.php?page=spa_get_token.php';
		url += '&scope=publish_actions';

		window.open(url, '_blank');
	});
});


