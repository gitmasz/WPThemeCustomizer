<?php

function theme_customizer_scripts()
{
  wp_enqueue_style('theme-customizer', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'), 'all');
}
add_action('wp_enqueue_scripts', 'theme_customizer_scripts');

//  ============================================================================
//  = Documentation:                                                           =
//  = https://developer.wordpress.org/themes/customize-api/customizer-objects/ =
//  ============================================================================

// remove_theme_mod( 'themename_theme_option_text_input' );

function themename_customize_register($wp_customize)
{

  $wp_customize->add_panel(
    'themename_panel',
    array(
      'title'       => __('Customizer Panel', 'themename'),
      'description' => __('Custom Customizer Panel Description', 'themename'),
      'priority'    => 1,
    )
  );

  $wp_customize->add_section('themename_section', array(
    'title'       => __('Customizer Section', 'themename'),
    'description' => __('Custom Customizer Section Description', 'themename'),
    'panel'       => 'themename_panel',
    'priority'    => 1,
  ));

  //  =============================
  //  = Text Input                =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_text_input', array(
    'default'    => 'Theme customizer input text.',
    'capability' => 'edit_theme_options',
    'type'       => 'theme_mod',
    'transport'  => 'refresh',
    'validate_callback' => 'validate_text_input',
  ));

  $wp_customize->add_control('themename_text_control', array(
    'type'        => 'text',
    'label'       => __('Text input', 'themename'),
    'description' => __('This is text input option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_text_input',
    'priority'    => 1,
  ));

  //  =============================
  //  = Number Input              =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_number_input', array(
    'default'    => 0,
    'capability' => 'edit_theme_options',
    'type'       => 'theme_mod',
    'transport'  => 'refresh',
    'validate_callback' => 'validate_number_input',
  ));

  $wp_customize->add_control('themename_number_control', array(
    'type'        => 'number',
    'label'       => __('Number input', 'themename'),
    'description' => __('This is number input option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_number_input',
    'priority'    => 2,
  ));

  //  =============================
  //  = Color Picker              =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_color_picker', array(
    'default'           => '#ff0000',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'refresh',
  ));

  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'themename_color_control', array(
    'label'       => __('Color picker', 'themename'),
    'description' => __('This is color picker option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_color_picker',
    'priority'    => 3,
  )));
}

add_action('customize_register', 'themename_customize_register');

function validate_text_input( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value ) {
      $validity->add( 'required', __( 'You must type some text.', 'themename' ) );
  }
  return $validity;
}

function validate_number_input( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value || !is_numeric($value) ) {
      $validity->add( 'required', __( 'You have to enter a number.', 'themename' ) );
  }
  return $validity;
}
