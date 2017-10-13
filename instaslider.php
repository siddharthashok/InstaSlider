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

    $script_params = array(
      'instaUserID' => get_option('instaslider_insta_user_id'),
      'instaAccessToken' => get_option('instaslider_insta_access_token'),
      'fileDirectory' => plugin_dir_url(__FILE__)
  );

  wp_localize_script( 'instaslider-script', 'scriptParams', $script_params );
}
add_action( 'wp_enqueue_scripts', 'enqueue_css_instaslider' );

function instaslider_register_settings() {
  add_option( 'instaslider_insta_user_id', '');
  add_option( 'instaslider_insta_access_token', '');
  register_setting( 'instaslider_options_group', 'instaslider_insta_user_id');
  register_setting( 'instaslider_options_group', 'instaslider_insta_access_token');
}
add_action( 'admin_init', 'instaslider_register_settings' );

function instaslider_register_options_page() {
  add_options_page('InstaSlider', 'InstaSlider', 'manage_options', 'instaslider', 'instaslider_options_page');
}
add_action('admin_menu', 'instaslider_register_options_page');

function instaslider_options_page()
{
?>
  <div>
  <?php screen_icon(); ?>
  <h2>My Plugin Page Title</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'instaslider_options_group' ); ?>
  <h3>This is my option</h3>
  <p>Some text here.</p>
  <table>
  <tr valign="top">
  <th scope="row"><label for="instaslider_insta_user_id">Instagram UserId</label></th>
  <td><input type="text" id="instaslider_insta_user_id" name="instaslider_insta_user_id" value="<?php echo get_option('instaslider_insta_user_id'); ?>" /></td>
  </tr>
  <tr valign="top">
  <th scope="row"><label for="instaslider_insta_access_token">Instagram Access Token</label></th>
  <td><input type="text" id="instaslider_insta_access_token" name="instaslider_insta_access_token" value="<?php echo get_option('instaslider_insta_access_token'); ?>" /></td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
}

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
