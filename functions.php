<?php

function theme_customizer_scripts(){
  wp_enqueue_style( 'theme-customizer', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ), 'all' );
}
add_action( 'wp_enqueue_scripts', 'theme_customizer_scripts' );

//  ============================================================================
//  = Documentation:                                                           =
//  = https://developer.wordpress.org/themes/customize-api/customizer-objects/ =
//  ============================================================================

function themename_customize_register($wp_customize){
	
	$wp_customize->add_panel( 'themename_panel',
	   array(
		  'title' => __('Customizer Panel', 'themename'),
		  'description' => __('Custom Customizer Panel Description', 'themename'),
		  'priority' => 1,
	   )
	);
    
    $wp_customize->add_section('themename_section', array(
        'title'    => __('Customizer Section', 'themename'),
		'description' => __('Custom Customizer Section Description', 'themename'),
		'panel' => 'themename_panel',
        'priority' => 1,
    ));

    //  =============================
    //  = Text Input                =
    //  =============================

    $wp_customize->add_setting('themename_theme_option_text_input', array(
        'default'        => 'Text input',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
		'transport' => 'refresh',
    ));

    $wp_customize->add_control('themename_text_control', array(
		'type' => 'text',
        'label'      => __('Text input', 'themename'),
		'description' => __( 'This is text input option description.' ),
        'section'    => 'themename_section',
        'settings'   => 'themename_theme_option_text_input',
		'priority' => 1,
    ));

}

add_action('customize_register', 'themename_customize_register');
