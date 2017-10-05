<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package fitvault
**/

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="hfeed site" id="page">

  <!-- ******************* The Navbar Area ******************* -->
	<div class="wrapper-fluid wrapper-navbar" id="wrapper-navbar">

    <a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content',
		'fitvault' ); ?></a>

    <nav class="navbar navbar-expand-md navbar-dark">

    <?php if ( 'container' == $container ) : ?>
		  <div class="container">
		<?php endif; ?>

        <!-- Your site title as branding in the menu -->
        <?php if ( ! has_custom_logo() ) { ?>

          <?php if ( is_front_page() ) : ?>

            <h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?> <sup>&copy;</sup></a></h1>

          <?php else : ?>

            <a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>

          <?php endif; ?>


        <?php } else {
          the_custom_logo();
        } ?><!-- end custom logo -->

				<button class="navbar-toggler collapsed" type="button" data-toggle="modal" data-target="#nav-modal" data-backdrop="static" data-keyboard="false" aria-controls="nav-modal" aria-label="Toggle navigation">
          <span class="bar"></span>
					<span class="bar"></span>
					<span class="bar"></span>
        </button>

				<div id="nav-modal" class="modal fade">
					<div class="modal-dialog" role="document">
						<div class="modal-nav-content">
							<div class="modal-nav-body">

								<!-- The WordPress Menu goes here -->
								<?php wp_nav_menu(
									array(
										'theme_location'  => 'primary',
										'container_class' => 'navbar-collapse',
										'container_id'    => 'primary-nav-container',
										'menu_class'      => 'navbar-nav',
										'fallback_cb'     => '',
										'menu_id'         => 'main-menu',
										'walker'          => new WP_Bootstrap_Navwalker(),
									)
								); ?>

								<?php get_sidebar( 'mobile-menu' ); ?>

							</div>
						</div>
					</div>
				</div>

				<?php if ( 'container' == $container ) : ?>
				</div>
				<?php endif; ?>

    </nav>

  </div>
