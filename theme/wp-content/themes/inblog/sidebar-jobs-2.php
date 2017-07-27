<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package inmedical
 */

if(is_active_sidebar('sidebar-jobs-2')){
?>
<div id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar('sidebar-jobs-2'); ?>
</div><!-- #secondary -->
<?php } ?>