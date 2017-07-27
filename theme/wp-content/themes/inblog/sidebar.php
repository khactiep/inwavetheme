<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package injob
 */

$sidebar = Inwave_Helper::getPostOption('sidebar_name');
if(!$sidebar) $sidebar = 'sidebar-default';

if ( ! is_active_sidebar(  $sidebar) ) {
	return;
} 
?>

<div id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar($sidebar); ?>
</div><!-- #secondary -->
