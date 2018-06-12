<?php 

// add the admin options page
add_action('admin_menu', 'gpspl_admin_add_page');
function gpspl_admin_add_page() {
add_options_page('GPS Plotter Settings', 'GPS Plotter Menu', 'manage_options', 'gps_plotter', 'gpspl_plugin_options_page');
}

add_action( 'admin_init', 'gpspl_update_extra_post_info' );

function gpspl_update_extra_post_info() {
  register_setting( 'plugin_options', 'gps-plotter-api-key' );
}



 // display the admin options page
function gpspl_plugin_options_page() {
?>
<div>
<h1>GPS Plotter</h1>
<p>To use this plugin, add this shortcode to any page or post:</p> 
    <p>[gps_plotter]</p> 
<p>Next get your Google API key here;</p>
	<p><a href="https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend&keyType=CLIENT_SIDE&reusekey=true&pli=1">Google API Key sign up</a></p>
<!--<p>You will then need to enter your Google API key into the /class-gpsplotter.php file</p>-->
<form method="post" action="options.php">
    <?php settings_fields( 'plugin_options' ); ?>
    <?php do_settings_sections( 'plugin' ); ?>
    <table class="form-table">
      <tr valign="top">
      <th scope="row">You will then need to enter your Google API key:</th>
      <td><input type="text" name="gps-plotter-api-key" value="<?php echo get_option( 'gps-plotter-api-key' ); ?>"/></td>
      </tr>
    </table>
    <?php submit_button(); ?>
  </form>
<p>Next you will need to download the app onto your phone.</p>
<p>For Android go <a href="https://play.google.com/store/apps/details?id=com.websmithing.wp.gpsplotter_cs&hl=en">here</a></p>
</div>
 
<?php
}

 // add the admin settings and such
add_action('admin_init', 'gpspl_plugin_admin_init');
function gpspl_plugin_admin_init(){
register_setting( 'gps_plotter_options', 'gps_plotter_options', 'gpspl_plugin_options_validate' );
add_settings_section('plugin_main', 'Main Settings', 'plotter_section_text', 'gps_plotter');
add_settings_field('plugin_text_string', 'Google API Key', 'gpspl_plugin_setting_string', 'gps_plotter', 'plugin_main');
}

 function gpspl_plotter_section_text() {
echo '<p>Main description of this section here.</p>';
} 

 function gpspl_plugin_setting_string() {
$options = get_option('gps_plotter_options');
echo "<input id='plugin_text_string' name='gps_plotter_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
} 

 // validate our options
function gpspl_plugin_options_validate($input) {
$options = get_option('gps_plotter_options');
$options['text_string'] = trim($input['text_string']);
if(!preg_match('/^[[:print:]]{39}$/i', $options['text_string'])) {
$options['text_string'] = '';
}
return $options;
}




