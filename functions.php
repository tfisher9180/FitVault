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

  wp_enqueue_style( 'fitvault-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
  wp_enqueue_script( 'fitvault-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'fitvault_enqueue_scripts' );
