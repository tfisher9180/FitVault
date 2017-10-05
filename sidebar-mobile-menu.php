<?php
/**
 * The sidebar containing the mobile navigation widget area.
 *
 * @package fitvault
 */

if ( ! is_active_sidebar( 'mobile-menu-sidebar' ) ) {
	return;
}
?>

<div class="widget-area" role="complementary">

	<?php dynamic_sidebar( 'mobile-menu-sidebar' ); ?>

</div><!-- #secondary -->
