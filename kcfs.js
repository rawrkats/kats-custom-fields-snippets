$ = jQuery;
$(document).ready(function() {
	var lastSnippetButtonClick;
	var BrowseSnippetsButton = $('<a href="#TB_inline?width=600&height=550&inlineId=kcfs-list" class="thickbox kcfs-browse-snippets wp-media-buttons-icon button button-small">Snippets</a>');
	BrowseSnippetsButton.clone().insertAfter($('#metavalue'));
	BrowseSnippetsButton.clone().insertAfter($('#the-list div.submit :input:last-child'));

	$('body').on('click','.kcfs-browse-snippets',function() {
		lastSnippetButtonClick = $(this);
	});
	$('.kcfs-load-snippet').on('click',function(event) {
		var data = $(this).parent('li').data('text');
		var customField = lastSnippetButtonClick.parents('tr').find('textarea');
		console.log(customField);
		customField.val(data);
		$('#TB_closeWindowButton').click();
	});
	$('.kcfs-append-snippet').on('click',function() {
		var data = $(this).parent('li').data('text');
		var customField = lastSnippetButtonClick.parents('tr').find('textarea');
		var olddata = customField.val();
		customField.val(olddata + data);
		$('#TB_closeWindowButton').click();
	});
});
