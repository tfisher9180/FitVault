<?php

function fitvault_parent_dequeue() {
  wp_dequeue_style( 'understrap-styles' );
  wp_deregister_style( 'understrap-styles' );

  wp_dequeue_script( 'understrap-scripts' );
  wp_deregister_script( 'understrap-scripts' );

  // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'fitvault_parent_dequeue', 20 );

function fitvault_enqueue_scripts() {
  // Get the theme data
	$the_theme = wp_get_theme();

  wp_enqueue_style( 'fitvault-google-fonts', fitvault_google_fonts(), array(), null );
  //wp_enqueue_style( 'fitvault-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
  wp_enqueue_style( 'fitvault-styles', get_stylesheet_directory_uri() . '/css/child-theme.css', array(), $the_theme->get( 'Version' ) );
  wp_enqueue_script( 'fitvault-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'fitvault_enqueue_scripts' );

function fitvault_google_fonts() {
  $fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Roboto, Oswald, or Montserrat, translate this to 'off'. Do not translate
	 * into your own language.
	 */
  $font_families = array();

  $roboto = _x( 'on', 'Roboto font: on or off', 'fitvault' );
  $oswald = _x( 'on', 'Oswald font: on or off', 'fitvault' );
	$montserrat = _x( 'on', 'Libre Franklin font: on or off', 'fitvault' );

  if ( 'off' !== $roboto ) {
    $font_families[] = 'Roboto:300,300i,400,400i,600,600i,700,700i';
  }

  if ( 'off' !== $oswald ) {
    $font_families[] = 'Oswald:400,700';
  }

	if ( 'off' !== $montserrat ) {
		$font_families[] = 'Montserrat:400,600,800';
  }

  if ( in_array( 'on', array( $roboto, $montserrat, $oswald ) ) ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

function fitvault_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'fitvault-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'fitvault_resource_hints', 10, 2 );

function fitvault_custom_header() {
  add_theme_support( 'custom-header', array(
		'default-image'      => get_stylesheet_directory_uri() . '/images/header.jpeg',
		'width'              => 2000,
		'height'             => 1200,
		'flex-height'        => true,
    'uploads'            => true,
	) );
}
add_action( 'after_setup_theme', 'fitvault_custom_header' );

function fitvault_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Mobile Menu Sidebar', 'fitvault' ),
    'id'            => 'mobile-menu-sidebar',
    'description'   => 'Mobile navigation widget area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
}
add_action( 'widgets_init', 'fitvault_widgets_init' );


// Makes custom menu widget output Bootstrap 4 menu
function fitvault_custom_menu_walker( $args ) {
  return array_merge( $args, array(
    // add options
    'menu_class'    => 'navbar-nav',
    'walker'        => new WP_Bootstrap_Navwalker(), 
  ) );
}
add_filter( 'wp_nav_menu_args', 'fitvault_custom_menu_walker' );
