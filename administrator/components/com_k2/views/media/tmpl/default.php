<?php
/**
 * @version		$Id: default.php 1618 2012-09-21 11:23:08Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die; ?>
<script type="text/javascript">
	$K2(document).ready(function() {
		var basePath = '<?php echo JURI::root(true); ?>';
		var elf = $K2('#elfinder').elfinder({
			url : '<?php echo JURI::base(true); ?>/index.php?option=com_k2&view=media&task=connector',
			<?php if($this->mimes): ?>
			onlyMimes: [<?php echo $this->mimes; ?>],
			<?php endif; ?>
			<?php if($this->fieldID): ?>
			getFileCallback : function(path) {
				value = path.replace(basePath, '');
				parent.elFinderUpdate('<?php echo $this->fieldID; ?>', value);
			}
			<?php else: ?>
			height: 600
			<?php endif; ?>
		}).elfinder('instance');
	});
</script>
<div id="elfinder"></div>
