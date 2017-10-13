<?php
/*
Plugin Name: InstaSlider
Description: To Show Instagram Feed slider
Author: Siddharth Ashok
Author URI: http://sidd.id
Version: 1.0
*/

?>

<script type="text/javascript">
  // var instaUserID = "<?php echo get_theme_mod( 'user_id', '' ); ?>";
  // var instaAccessToken = "<?php echo get_theme_mod( 'access_token', '' ); ?>";

  var instaUserID = "212129007";
  var instaAccessToken = "212129007.1677ed0.54011f83990548bc8070b30827050b3d";
  var fileDirectory = "<?php echo plugin_dir_url(__FILE__); ?>";
</script>

<?php
// Enqueue files for Instaslider

function enqueue_css_instaslider() {
    wp_enqueue_style( 'instaslider-owl-carousel', plugin_dir_url(__FILE__) . '/css/owl.carousel.min.css', true);
    wp_enqueue_style( 'instaslider-owl-carousel-theme', plugin_dir_url(__FILE__) . '/css/owl.theme.default.min.css', true);
    wp_enqueue_style( 'instaslider-style', plugin_dir_url(__FILE__) . '/css/style.css', true);
    wp_enqueue_script('instaslider-script-owl-carousel', plugin_dir_url(__FILE__) . '/js/owl.carousel.min.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script('instaslider-script-instafeed', plugin_dir_url(__FILE__) . '/js/instafeed.min.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script('instaslider-script', plugin_dir_url(__FILE__) . '/js/script.js', array( 'jquery' ), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'enqueue_css_instaslider' );

function instaslider_register_options_page() {
  add_options_page('InstaSlider', 'InstaSlider', 'manage_options', 'instaslider', 'instaslider_options_page');
}
add_action('admin_menu', 'instaslider_register_options_page');

function instaslider_register_settings() {
   add_option( 'instaslider_option_name', 'InstaSlider');
   register_setting( 'instaslider_options_group', 'instaslider_option_name', 'instaslider_callback' );
}
add_action( 'admin_init', 'instaslider_register_settings' );

function instaslider_register_settings()
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
  <th scope="row"><label for="instaslider_option_name">Label</label></th>
  <td><input type="text" id="instaslider_option_name" name="instaslider_option_name" value="<?php echo get_option('instaslider_option_name'); ?>" /></td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
}


function instafeed_shortcode_function() {
  $intafeed_template = '<section id="instagram">
    	<div class="account-info">
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

    	<div class="insta-carousel owl-carousel owl-theme" id="instafeed">
     </div>
    </section>';
  return $intafeed_template;
}

add_shortcode('instafeed', 'instafeed_shortcode_function');
