<?php
/*
Plugin Name: InstaSlider
Description: To Show Instagram Feed slider
Author: Siddharth Ashok
Author URI: http://sidd.id
Version: 1.0
*/

// Enqueue files for Instaslider



function enqueue_css_instaslider() {
    wp_enqueue_style( 'instaslider-owl-carousel', plugin_dir_url(__FILE__) . '/css/owl.carousel.min.css', true);
    wp_enqueue_style( 'instaslider-owl-carousel-theme', plugin_dir_url(__FILE__) . '/css/owl.theme.default.min.css', true);
    wp_enqueue_style( 'instaslider-style', plugin_dir_url(__FILE__) . '/css/style.css', true);
    wp_enqueue_script('instaslider-script-owl-carousel', plugin_dir_url(__FILE__) . '/js/owl.carousel.min.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script('instaslider-script-instafeed', plugin_dir_url(__FILE__) . '/js/instafeed.min.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script('instaslider-script', plugin_dir_url(__FILE__) . '/js/script.js', array( 'jquery' ), '1.0.0', true );

    $options = get_option( 'insta_settings' );
    $script_params = array(
      'instaUserID' => $options['insta_user_id'],
      'instaAccessToken' => $options['insta_access_token'],
      'fileDirectory' => plugin_dir_url(__FILE__)
  );

  wp_localize_script( 'instaslider-script', 'scriptParams', $script_params );
}
add_action( 'wp_enqueue_scripts', 'enqueue_css_instaslider' );

// Settings Page options
// generetaed from http://wpsettingsapi.jeroensormani.com/

function insta_add_admin_menu(  ) {
	add_options_page( 'InstaSlider', 'InstaSlider', 'manage_options', 'instaslider', 'insta_options_page' );
}
add_action( 'admin_menu', 'insta_add_admin_menu' );

function insta_settings_init(  ) {
	register_setting( 'insta_options_group', 'insta_settings' );

	add_settings_section(
		'insta_options_section',
		__( 'Your section description', 'wordpress' ),
		'insta_settings_section_callback',
		'insta_options_group'
	);

	add_settings_field(
		'insta_user_id',
		__( 'Instagram User ID', 'wordpress' ),
		'insta_user_id_render',
		'insta_options_group',
		'insta_options_section'
	);

	add_settings_field(
		'insta_access_token',
		__( 'Instagram Access Token', 'wordpress' ),
		'insta_access_token_render',
		'insta_options_group',
		'insta_options_section'
	);

	// add_settings_field(
	// 	'insta_radio_field_2',
	// 	__( 'Settings field description', 'wordpress' ),
	// 	'insta_radio_field_2_render',
	// 	'insta_options_group',
	// 	'insta_options_section'
	// );
  //
	// add_settings_field(
	// 	'insta_radio_field_3',
	// 	__( 'Settings field description', 'wordpress' ),
	// 	'insta_radio_field_3_render',
	// 	'insta_options_group',
	// 	'insta_options_section'
	// );
  //
	// add_settings_field(
	// 	'insta_radio_field_4',
	// 	__( 'Settings field description', 'wordpress' ),
	// 	'insta_radio_field_4_render',
	// 	'insta_options_group',
	// 	'insta_options_section'
	// );
}
add_action( 'admin_init', 'insta_settings_init' );

function insta_user_id_render(  ) {
	$options = get_option( 'insta_settings' );
	?>
	<input type='text' name='insta_settings[insta_user_id]' value='<?php echo $options['insta_user_id']; ?>'>
	<?php
}

function insta_access_token_render(  ) {
	$options = get_option( 'insta_settings' );
	?>
	<input type='text' name='insta_settings[insta_access_token]' value='<?php echo $options['insta_access_token']; ?>'>
	<?php
}

/*
function insta_radio_field_2_render(  ) {
	$options = get_option( 'insta_settings' );
	?>
	<input type='radio' name='insta_settings[insta_radio_field_2]' <?php checked( $options['insta_radio_field_2'], 1 ); ?> value='1'>
	<?php
}


function insta_radio_field_3_render(  ) {

	$options = get_option( 'insta_settings' );
	?>
	<input type='radio' name='insta_settings[insta_radio_field_3]' <?php checked( $options['insta_radio_field_3'], 1 ); ?> value='1'>
	<?php

}


function insta_radio_field_4_render(  ) {

	$options = get_option( 'insta_settings' );
	?>
	<input type='radio' name='insta_settings[insta_radio_field_4]' <?php checked( $options['insta_radio_field_4'], 1 ); ?> value='1'>
	<?php

}
*/

function insta_settings_section_callback(  ) {

	echo __( 'This section description', 'wordpress' );

}


function insta_options_page(  ) {

	?>
	<form action='options.php' method='post'>

		<h2>InstaSlider</h2>

		<?php
		settings_fields( 'insta_options_group' );
		do_settings_sections( 'insta_options_group' );
		submit_button();
		?>

	</form>
	<?php

}


// SHORTCODE
function instafeed_shortcode_function() {
  $intafeed_template = '<section id="instagram"><div class="account-info">
    		<div class="account-info-wrap">
    			<div class="insta-logo">
    				<img src="<?php echo get_template_directory_uri(); ?>/img/logo-insta.jpg" alt="">
    			</div>
    			<div class="insta-info">
    				<div class="insta-title">Instagram feed of</div>
    				<div class="insta-username">
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="insta-carousel owl-carousel owl-theme" id="instafeed"></div>
    </section>';
  return $intafeed_template;
}
add_shortcode('instafeed', 'instafeed_shortcode_function');
