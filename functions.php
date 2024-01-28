<?php

function theme_customizer_scripts(){
  wp_enqueue_style( 'theme-customizer', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ), 'all' );
}
add_action( 'wp_enqueue_scripts', 'theme_customizer_scripts' );
