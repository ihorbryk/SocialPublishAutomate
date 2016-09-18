jQuery('document').ready(function($) {

	$('body').on('click', '.group-edit', function() {
		var groupId = $('.group-id', $(this).parents('.group')).data('group-id');
		var socialNetwork = $('.group-network', $(this).parents('.group')).data('network');
		var groupName = $('.group-name', $(this).parents('.group')).text();
		var groupPageId = $('.group-page-id', $(this).parents('.group')).text();

		$('#edit_id').val( groupId );
		$('#edit_network').val( socialNetwork );
		$('#edit_group_name').val( groupName );
		$('#edit_group_id').val( groupPageId );
	});
});
