<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fitvault
**/

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="home-page-wrapper">

  <header class="custom-header" style="background-image: url('<?php header_image(); ?>');">

    <?php if ( 'container' == $container ) : ?>
		  <div class="container">
		<?php endif; ?>



    <?php if ( 'container' == $container ) : ?>
      </div>
		<?php endif; ?>

  </header>

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

    <div class="row">
			<div class="col-md-12 content-area" id="primary">
				<main class="site-main" id="main" role="main">

        </main>
      </div>
    </div>

  </div>

</div>

<?php get_footer(); ?>
