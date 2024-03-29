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

// remove_theme_mod( 'themename_theme_option_text_input' ); // remove custom theme mod from database

// function themename_remove_core_panels_and_sections( $wp_customize ) {
//   $wp_customize->remove_panel( 'themes' ); // remove core panel 'Active theme' from customizer
//   $wp_customize->remove_section( 'title_tagline' ); // remove core section 'Site Identity' from customizer
//   $wp_customize->remove_section( 'static_front_page' ); // remove core section 'Homepage Settings' from customizer
//   $wp_customize->remove_section( 'custom_css' ); // remove core section 'Additional CSS' from customizer
// }

// add_action( 'customize_register', 'themename_remove_core_panels_and_sections' );

// function themename_remove_core_menu_panel( $wp_customize ) {
//   remove_action( 'customize_controls_enqueue_scripts', array( $wp_customize->nav_menus, 'enqueue_scripts' ) );
//   remove_action( 'customize_register', array( $wp_customize->nav_menus, 'customize_register' ) );
//   remove_filter( 'customize_dynamic_setting_args', array( $wp_customize->nav_menus, 'filter_dynamic_setting_args' ) );
//   remove_filter( 'customize_dynamic_setting_class', array( $wp_customize->nav_menus, 'filter_dynamic_setting_class' ) );
//   remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->nav_menus, 'print_templates' ) );
//   remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->nav_menus, 'available_items_template' ) );
//   remove_action( 'customize_preview_init', array( $wp_customize->nav_menus, 'customize_preview_init' ) );
// }

// add_action( 'customize_register', 'themename_remove_core_menu_panel' ); // remove core panel 'Menus' from customizer

get_role('contributor')->add_cap('edit_theme_options'); // gives contributors access to customizer
// get_role('contributor')->remove_cap('edit_theme_options'); // removes contributors access to customizer
get_role('editor')->add_cap('edit_theme_options'); // gives editors access to customizer
// get_role('editor')->remove_cap('edit_theme_options'); // removes editors access to customizer
get_role('author')->add_cap('edit_theme_options'); // gives authors access to customizer
// get_role('author')->remove_cap('edit_theme_options'); // removes authors access to customizer

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
    'title'           => __('Customizer Section', 'themename'),
    'description'     => __('Custom Customizer Section Description', 'themename'),
    'panel'           => 'themename_panel',
    'active_callback' => 'is_front_page',
    'priority'        => 1,
  ));

  $wp_customize->add_section('themename_sample_page_section', array(
    'title'           => __('Sample page Section', 'themename'),
    'description'     => __('Custom Customizer Section Description', 'themename'),
    'panel'           => 'themename_panel',
    'active_callback' => 'themename_is_sample_page', // custom function to check if it is a page with 'sample-page' slug
    'priority'        => 2,
  ));

  //  =============================
  //  = Text Input                =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_text_input', array(
    'default'           => 'Theme customizer input text.',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'sanitize_text_field', // converts value to text only (no HTML tags)
    'transport'         => 'refresh',
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
    'default'           => 0,
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'absint', // converts value to a non-negative integer
    'transport'         => 'refresh',
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
      'min'       => -20,
      'max'       => 20,
      'step'      => 2,
      'oninput'   => 'if (document.getElementById("rangeInputValue")) {document.getElementById("rangeInputValue").innerText = this.value}',
    ),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_range_input',
    'priority'    => 3,
  ));

  //  =============================
  //  = URL Input                 =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_url_input', array(
    'default'           => 'https://imasz.net',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'esc_url_raw', // cleans URL from all invalid characters
    'transport'         => 'refresh',
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
    'default'           => '+48 123 456 789',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'transport'         => 'refresh',
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
  //  = Email Input               =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_email_input', array(
    'default'           => 'testing@hotmail.com',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'sanitize_email', // removes all invalid characters
    'transport'         => 'refresh',
    'validate_callback' => 'validate_email_input',
  ));

  $wp_customize->add_control('themename_email_control', array(
    'type'        => 'email',
    'label'       => __('Email input', 'themename'),
    'description' => __('This is email input option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_email_input',
    'priority'    => 6,
  ));

  //  =============================
  //  = Time Input                =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_time_input', array(
    'default'           => '12:00',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'transport'         => 'refresh',
    'validate_callback' => 'validate_time_input',
  ));

  $wp_customize->add_control('themename_time_control', array(
    'type'        => 'time',
    'label'       => __('Time input', 'themename'),
    'description' => __('This is time input option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_time_input',
    'priority'    => 7,
  ));

  //  =============================
  //  = Date Input                =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_date_input', array(
    'default'           => '1983-01-01',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'transport'         => 'refresh',
    'validate_callback' => 'validate_date_input',
  ));

  $wp_customize->add_control('themename_date_control', array(
    'type'        => 'date',
    'label'       => __('Date input', 'themename'),
    'description' => __('This is date input option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_date_input',
    'priority'    => 8,
  ));

  //  =============================
  //  = DateTime Local Input      =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_datetime_input', array(
    'default'           => '1983-01-01T12:00',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'transport'         => 'refresh',
    'validate_callback' => 'validate_datetime_input',
  ));

  $wp_customize->add_control('themename_datetime_control', array(
    'type'        => 'datetime-local',
    'label'       => __('DateTime local input', 'themename'),
    'description' => __('This is DateTime local input option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_datetime_input',
    'priority'    => 9,
  ));

  //  =============================
  //  = Checkbox Input            =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_checkbox_input', array(
    'default'           => '',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'themename_sanitize_checkbox', // custom sanitization function
    'transport'         => 'refresh',
  ));

  $wp_customize->add_control('themename_checkbox_control', array(
    'type'        => 'checkbox',
    'label'       => __('Checkbox input', 'themename'),
    'description' => __('This is checkbox input option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_checkbox_input',
    'priority'    => 10,
  ));

  //  =============================
  //  = Radio Input               =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_radio_input', array(
    'default'    => 'Chosen radio option three',
    'capability' => 'edit_theme_options',
    'type'       => 'theme_mod',
    'transport'  => 'refresh',
  ));

  $wp_customize->add_control('themename_radio_control', array(
    'type'                        => 'radio',
    'label'                       => __('Radio input', 'themename'),
    'description'                 => __('This is radio input option description.', 'themename'),
    'choices'                     => array(
      'Chosen radio option one'   => __('Choice One', 'themename'),
      'Chosen radio option two'   => __('Choice Two', 'themename'),
      'Chosen radio option three' => __('Choice Three', 'themename')
    ),
    'section'                     => 'themename_section',
    'settings'                    => 'themename_theme_option_radio_input',
    'priority'                    => 10,
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
    'priority'    => 12,
  )));

  //  =============================
  //  = Textarea                  =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_textarea', array(
    'default'           => 'Theme customizer textarea.',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'sanitize_text_field', // converts value to text only (no HTML tags)
    'transport'         => 'refresh',
    'validate_callback' => 'validate_textarea',
  ));

  $wp_customize->add_control('themename_textarea_control', array(
    'type'        => 'textarea',
    'label'       => __('Textarea', 'themename'),
    'description' => __('This is textarea option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_textarea',
    'priority'    => 13,
  ));

  //  =============================
  //  = Select                    =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_select', array(
    'default'    => 'Chosen select option two',
    'capability' => 'edit_theme_options',
    'type'       => 'theme_mod',
    'transport'  => 'refresh',
  ));

  $wp_customize->add_control('themename_select_control', array(
    'type'                         => 'select',
    'label'                        => __('Select', 'themename'),
    'description'                  => __('This is select option description.', 'themename'),
    'choices'                      => array(
      'Chosen select option one'   => __('Choice One', 'themename'),
      'Chosen select option two'   => __('Choice Two', 'themename'),
      'Chosen select option three' => __('Choice Three', 'themename')
    ),
    'section'                      => 'themename_section',
    'settings'                     => 'themename_theme_option_select',
    'priority'                     => 14,
  ));

  //  =============================
  //  = Dropdown-Pages            =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_dropdown_pages', array(
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'absint', // input value is a page ID so it must be a positive integer
    'transport'         => 'refresh',
  ));

  $wp_customize->add_control('themename_dropdown_pages_control', array(
    'type'           => 'dropdown-pages',
    'label'          => __('Dropdown-Pages', 'themename'),
    'description'    => __('This is dropdown-pages option description.', 'themename'),
    'allow_addition' => true,
    'section'        => 'themename_section',
    'settings'       => 'themename_theme_option_dropdown_pages',
    'priority'       => 15,
  ));

  //  =============================
  //  = Media uploader            =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_media_uploader', array(
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'absint', // media uploader returns attachment ID so it must be a positive integer
    'transport'         => 'refresh',
  ));

  $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'themename_media_uploader_control', array(
    'mime_type'   => 'image', // also accepts 'audio' and 'video'
    'label'       => __('Media uploader', 'themename'),
    'description' => __('This is media uploader option description.', 'themename'),
    'section'     => 'themename_section',
    'settings'    => 'themename_theme_option_media_uploader',
    'priority'    => 16,
  )));

  //  =============================
  //  = Sample page text          =
  //  =============================

  $wp_customize->add_setting('themename_theme_option_sample_page_text', array(
    'default'           => 'Theme customizer sample page text.',
    'capability'        => 'edit_theme_options',
    'type'              => 'theme_mod',
    'sanitize_callback' => 'sanitize_text_field', // converts value to text only (no HTML tags)
    'transport'         => 'refresh',
    'validate_callback' => 'validate_text_input',
  ));

  $wp_customize->add_control('themename_sample_page_text_control', array(
    'type'            => 'text',
    'label'           => __('Sample page text', 'themename'),
    'description'     => __('This is sample page text option description.', 'themename'),
    'section'         => 'themename_sample_page_section',
    'settings'        => 'themename_theme_option_sample_page_text',
    'active_callback' => 'themename_is_sample_page', // custom function to check if it is a page with 'sample-page' slug
    'priority'        => 1,
  ));

  // Alternate way to attach active callback (works only for custom panels, sections and controls after they calls)
  // $wp_customize->get_panel( 'themename_panel' )->active_callback = 'is_front_page'; // hides panel
  // $wp_customize->get_section( 'themename_section' )->active_callback = function () { return false; }; // hide section
  // $wp_customize->get_control( 'themename_text_control' )->active_callback = function () { return false; }; // hide control
}

add_action('customize_register', 'themename_customize_register');

function themename_is_sample_page() {
  return is_page('sample-page');
}

function themename_sanitize_checkbox( $input ){
  return ( isset( $input ) && $input == 1 ? true : false ); // returns true if checkbox is checked
}

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

function validate_email_input( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value || !preg_match('/^[\-0-9a-zA-Z\.\+_]+@[\-0-9a-zA-Z\.\+_]+\.[a-zA-Z]{2,5}$/', $value) ) {
      $validity->add( 'required', __( 'You have to enter correct email.', 'themename' ) );
  }
  return $validity;
}

function validate_time_input( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value || !preg_match('/^(([0-1]?[0-9]|2[0-3]):[0-5][0-9])$/', $value) ) {
      $validity->add( 'required', __( 'You have to enter correct time in HH:MM format.', 'themename' ) );
  }
  return $validity;
}

function validate_date_input( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value || !preg_match('/^(([1-9][0-9]{3})(-)((01|03|05|07|08|10|12)(-)((0|1|2)[0-9]|30|31))|([1-9][0-9]{3})(-)((04|06|09|11)(-)((0|1|2)[0-9]|30))|([1-9][0-9]{3})(-)((02)(-)((0|1|2)[0-9])))$/', $value) ) {
      $validity->add( 'required', __( 'You have to enter correct date in YYYY-MM-DD format.', 'themename' ) );
  }
  return $validity;
}

function validate_datetime_input( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value || !preg_match('/^(([1-9][0-9]{3})(-)((01|03|05|07|08|10|12)(-)((0|1|2)[0-9]|30|31))|([1-9][0-9]{3})(-)((04|06|09|11)(-)((0|1|2)[0-9]|30))|([1-9][0-9]{3})(-)((02)(-)((0|1|2)[0-9])))(T)(([0-1]?[0-9]|2[0-3]):[0-5][0-9])$/', $value) ) {
      $validity->add( 'required', __( 'You have to enter correct date and time in YYYY-MM-DDTHH:MM format.', 'themename' ) );
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

function validate_textarea( $validity, $value ) {
  $value = trim($value ?? '');
  if ( !$value ) {
    $validity->add( 'required', __( 'You must type some text.', 'themename' ) );
  }
  if ( $value && !preg_match('/^(.|\s){1,1000}$/', $value) ) {
    $validity->add( 'required', __( 'Text can\'t be longer than 1000 characters.', 'themename' ) );
  }
  return $validity;
}