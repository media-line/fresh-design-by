<?php
/**
 * @version		4.1
 * @package		AllVideos (plugin)
 * @author    JoomlaWorks - http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>

<div class="avPlayerWrapper">
	<div style="width:<?php echo $output->playerWidth; ?>px;" class="avPlayerContainer">
		<div id="<?php echo $output->playerID; ?>" class="avPlayerBlock">
			<?php echo $output->player; ?>
		</div>
	</div>
</div>
