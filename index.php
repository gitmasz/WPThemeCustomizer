<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Theme Customizer</title>
	<?php wp_head(); ?>
</head>
<body>
  <div class="fullpage-message" style="background-color:<?php echo get_theme_mod( 'themename_theme_option_color_picker', '#00aad4' ); ?>">
    <div class="content fullpage-message__content">
      <h1>Theme Customizer</h1>
      <p><?php echo get_theme_mod( 'themename_theme_option_text_input', 'Theme customizer input text.' ); ?></p>
      <p>Number from customizer input is: <?php echo get_theme_mod( 'themename_theme_option_number_input', '0' ); ?></p>
      <p>Number from customizer range is: <?php echo get_theme_mod( 'themename_theme_option_range_input', '6' ); ?></p>
      <p>Address from URL input: <?php echo get_theme_mod( 'themename_theme_option_url_input', 'https://imasz.net' ); ?></p>
      <p>Phone number from tel input: <?php echo get_theme_mod( 'themename_theme_option_tel_input', '+48 123 456 789' ); ?></p>
      <p>Email address from email input: <?php echo get_theme_mod( 'themename_theme_option_email_input', 'testing@hotmail.com' ); ?></p>
      <p>Time from time input: <?php echo get_theme_mod( 'themename_theme_option_time_input', '12:00' ); ?></p>
    </div>
  </div>
  <?php wp_footer(); ?>
</body>
</html>