jQuery('document').ready(function($) {

	$('body').on('click', '.group-list-edit', function() {
		var groupListId = $('.group-list-id', $(this).parents('.group-list')).data('group-list-id');
		var groupListName = $('.group-list-name', $(this).parents('.group-list')).text();
		var groupListTag = $('.group-list-connected-tag', $(this).parents('.group-list')).text();


		$('#edit_id').val( groupListId );
		$('#edit_group_list_name').val( groupListName.trim() );
		$('#edit_connected_tag_name').val( groupListTag.trim() );
	});
});
