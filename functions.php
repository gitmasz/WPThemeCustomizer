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
    'sanitize_callback' => 'sanitize_text_field', // converts value to text only (no HTML tags)
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
    'sanitize_callback' => 'absint', //converts value to a non-negative integer
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
  //  = Range Input               =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_range_input', array(
    'default'    => 6,
    'capability' => 'edit_theme_options',
    'type'       => 'theme_mod',
    'transport'  => 'refresh',
  ));

  $current_range_value = get_theme_mod( 'themename_theme_option_range_input', '6' );

  $wp_customize->add_control('themename_range_control', array(
    'type'        => 'range',
    'label'       => __('Range input', 'themename'),
    'description' => __('This is range input option description. Value: ', 'themename') . '<i id="rangeInputValue">'.$current_range_value.'</i>',
    'input_attrs' => array(
      'min' => -20,
      'max' => 20,
      'step' => 2,
      'oninput' => 'if (document.getElementById("rangeInputValue")) {document.getElementById("rangeInputValue").innerText = this.value}',
    ),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_range_input',
    'priority'    => 3,
  ));

  //  =============================
  //  = URL Input                 =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_url_input', array(
    'default'    => 'https://imasz.net',
    'capability' => 'edit_theme_options',
    'type'       => 'theme_mod',
    'sanitize_callback' => 'esc_url_raw', // cleans URL from all invalid characters
    'transport'  => 'refresh',
    'validate_callback' => 'validate_url_input',
  ));

    $wp_customize->add_control('themename_url_control', array(
    'type'        => 'url',
    'label'       => __('URL input', 'themename'),
    'description' => __('This is URL input option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_url_input',
    'priority'    => 4,
  ));

  //  =============================
  //  = Tel Input                 =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_tel_input', array(
    'default'    => '+48 123 456 789',
    'capability' => 'edit_theme_options',
    'type'       => 'theme_mod',
    'transport'  => 'refresh',
    'validate_callback' => 'validate_tel_input',
  ));

    $wp_customize->add_control('themename_tel_control', array(
    'type'        => 'tel',
    'label'       => __('Tel input', 'themename'),
    'description' => __('This is tel input option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_tel_input',
    'priority'    => 5,
  ));

  //  =============================
  //  = Color Picker              =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_color_picker', array(
    'default'           => '#ff0000',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'sanitize_hex_color', // converts value to hex color
    'transport'         => 'refresh',
    'validate_callback' => 'validate_hex_color',
  ));

  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'themename_color_control', array(
    'label'       => __('Color picker', 'themename'),
    'description' => __('This is color picker option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_color_picker',
    'priority'    => 6,
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

function validate_url_input( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value || !preg_match('/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/', $value) ) {
      $validity->add( 'required', __( 'You have to enter correct URL with HTTP or HTTPS.', 'themename' ) );
  }
  return $validity;
}

function validate_tel_input( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value || !preg_match('/^[\+\s0-9\-_]{3,20}$/', $value) ) {
      $validity->add( 'required', __( 'You have to enter correct phone number.', 'themename' ) );
  }
  return $validity;
}

function validate_hex_color( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value || !preg_match('/^#([a-f0-9]{6}|[a-f0-9]{3})$/', $value) ) {
      $validity->add( 'required', __( 'You have to enter correct hex color.', 'themename' ) );
  }
  return $validity;
}
