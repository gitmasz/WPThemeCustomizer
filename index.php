<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Theme Customizer</title>
	<?php wp_head(); ?>
</head>
<body>
  <div class="fullpage-message">
    <div class="content fullpage-message__content">
      <h1>Theme Customizer</h1>
      <p><?php echo get_theme_mod( 'themename_theme_option_text_input', 'Theme customizer input text.' ); ?></p>
      <p>Number from customizer input is: <?php echo get_theme_mod( 'themename_theme_option_number_input', 'NOT SET' ); ?></p>
    </div>
  </div>
  <?php wp_footer(); ?>
</body>
</html>