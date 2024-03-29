<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Theme Customizer</title>
	<?php wp_head(); ?>
</head>
<body>
  <div
    class="fullpage-message"
    style="
      background-color:<?php echo get_theme_mod( 'themename_theme_option_color_picker', '#00aad4' ); ?>;
      background-image:url(<?php echo wp_get_attachment_image_url(get_theme_mod( 'themename_theme_option_media_uploader', '' ), 'full'); ?>);
    "
  >
    <div class="content fullpage-message__content">
      <h1>Theme Customizer</h1>
      <p><?php echo get_theme_mod( 'themename_theme_option_text_input', 'Theme customizer input text.' ); ?></p>
      <p>Number from customizer input is: <?php echo get_theme_mod( 'themename_theme_option_number_input', '0' ); ?></p>
      <p>Number from customizer range is: <?php echo get_theme_mod( 'themename_theme_option_range_input', '6' ); ?></p>
      <p>Address from URL input: <?php echo get_theme_mod( 'themename_theme_option_url_input', 'https://imasz.net' ); ?></p>
      <p>Phone number from tel input: <?php echo get_theme_mod( 'themename_theme_option_tel_input', '+48 123 456 789' ); ?></p>
      <p>Email address from email input: <?php echo get_theme_mod( 'themename_theme_option_email_input', 'testing@hotmail.com' ); ?></p>
      <p>Time from time input: <?php echo get_theme_mod( 'themename_theme_option_time_input', '12:00' ); ?></p>
      <p>Date from date input: <?php echo get_theme_mod( 'themename_theme_option_date_input', '1983-01-01' ); ?></p>
      <p>Date and time from datetime-local input: <?php echo date_format(date_create(get_theme_mod( 'themename_theme_option_datetime_input', '1983-01-01T12:00' )),'H:i d/m/Y'); ?></p>
      <p>Checkbox state from checkbox input: <?php echo get_theme_mod( 'themename_theme_option_checkbox_input' ) ? 'true' : 'false'; ?></p>
      <p>Radio input value from radio input: <?php echo get_theme_mod( 'themename_theme_option_radio_input', 'Chosen radio option three' ); ?></p>
      <p>Text from textarea: <?php echo get_theme_mod( 'themename_theme_option_textarea', 'Theme customizer textarea.' ); ?></p>
      <p>Select option value from select: <?php echo get_theme_mod( 'themename_theme_option_select', 'Chosen select option two' ); ?></p>
      <p>Page ID from dropdown-pages: <?php echo get_theme_mod( 'themename_theme_option_dropdown_pages', '' ); ?></p>
      <h2>Sample page content</h2>
      <?php if(is_page('sample-page')){ ?>
        <p><?php echo get_theme_mod( 'themename_theme_option_sample_page_text', 'Theme customizer sample page text.' ); ?></p>
        <p>Back to <a href="<?php echo get_home_url(); ?>">homepage</a></p>
      <?php }else{ ?>
        <p>Go to <a href="<?php echo get_permalink( get_page_by_path( 'sample-page' ) ); ?>">sample-page</a> to see content from customizer.</p>
      <?php }; ?>
    </div>
  </div>
  <?php wp_footer(); ?>
</body>
</html>