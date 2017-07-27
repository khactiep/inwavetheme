<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package inmedical
 */

if(is_active_sidebar('sidebar-jobs-1')){
?>
<div id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar('sidebar-jobs-1'); ?>
</div><!-- #secondary -->
<?php } ?>