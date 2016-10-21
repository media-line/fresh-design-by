/**
 * @version		$Id: k2tags.js 1595 2012-06-07 11:57:51Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

$K2(document).ready(function() {

	$K2('.tagRemove').click(function(event) {
		event.preventDefault();
		$K2(this).parent().remove();
	});
	$K2('ul.tags').click(function() {
		$K2('#search-field').focus();
	});
	$K2('#search-field').keypress(function(event) {
		if (event.which == '13') {
			if ($K2(this).val() != '') {
				$K2('<li class="addedTag">' + $K2(this).val() + '<span class="tagRemove" onclick="$K2(this).parent().remove();">x</span><input type="hidden" value="' + $K2(this).val() + '" name="tags[]"></li>').insertBefore('.tags .tagAdd');
				$K2(this).val('');
			}
		}
	});
	$K2('#search-field').autocomplete({
		source : function(request, response) {
			$K2.ajax({
				type : 'post',
				url : K2SitePath + 'index.php?option=com_k2&view=item&task=tags',
				data : 'q=' + request.term,
				dataType : 'json',
				success : function(data) {
					$K2('#search-field').removeClass('tagsLoading');
					response($K2.map(data, function(item) {
						return item;
					}));
				}
			});
		},
		minLength : 3,
		select : function(event, ui) {
			$K2('<li class="addedTag">' + ui.item.label + '<span class="tagRemove" onclick="$K2(this).parent().remove();">x</span><input type="hidden" value="' + ui.item.value + '" name="tags[]"></li>').insertBefore('.tags .tagAdd');
			this.value = '';
			return false;
		},
		search : function(event, ui) {
			$K2('#search-field').addClass('tagsLoading');
		}
	});

})