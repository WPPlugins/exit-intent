<?php
/*
Plugin Name: Exit Intent
Plugin URI: http://www.activeconvert.com
Description: Exit Intent helps you convert abandoning visitors into leads. To get started: 1) Click the "Activate" link to the left of this description, 2) Go to your Exit Intent plugin Settings page, and click Get My API Key.
Version: 1.0.10
Author: ActiveConvert
Author URI: http://www.activeconvert.com/
*/

$acei_domain = plugins_url();
add_action('init', 'acei_init');
add_action('admin_notices', 'acei_notice');
add_filter('plugin_action_links', 'acei_plugin_actions', 10, 2);
add_action('wp_footer', 'acei_insert',4);
add_action('admin_footer', 'aceiRedirect');
define('acei_DASHBOARD_URL', "https://www.activeconvert.com/dashboard.do?wp=true");
define('acei_SMALL_LOGO',plugin_dir_url( __FILE__ ).'ac-small-white.png');
function acei_init() {
    if(function_exists('current_user_can') && current_user_can('manage_options')) {
        add_action('admin_menu', 'acei_add_settings_page');
        add_action('admin_menu', 'acei_create_menu');
    }
}
function acei_insert() {

    global $current_user;
    if(strlen(get_option('acei_widgetID')) == 32 ) {
	echo("\n<!-- Exit Intent by ActiveConvert (www.activeconvert.com) -->\n<script src='//www.activeconvert.com/api/activeconvert.1.0.js#".get_option('acei_widgetID')."' async='async'></script>\n");
    }
}

function acei_notice() {
    if(!get_option('acei_widgetID')) echo('<div class="error" style="padding:10px;"><p><strong><a style="text-decoration:none;border-radius:3px;color:white;padding:10px; ;background:#029dd6;border-color:#06b9fd #029dd6 #029dd6;margin-right:20px;"'.sprintf(__('href="%s">Activate your Exit Intent account</a></strong>  Almost done - Activate your account and say hello to beautiful exit intent popups!' ), admin_url('options-general.php?page=exit-intent')).'</p></div>');
}

function acei_plugin_actions($links, $file) {
    static $this_plugin;
    $acei_domain = plugins_url();
    if(!$this_plugin) $this_plugin = plugin_basename(__FILE__);
    if($file == $this_plugin && function_exists('admin_url')) {
        $settings_link = '<a href="'.admin_url('options-general.php?page=exit-intent').'">'.__('Settings', $acei_domain).'</a>';
        array_unshift($links, $settings_link);
    }
    return($links);
}

function acei_add_settings_page() {
    function acei_settings_page() {
        global $acei_domain ?>
	<div class="wrap">
        <p style="margin-left:4px;font-size:16px;"><strong>Exit Intent</strong> by <?php wp_nonce_field('update-options') ?>
		<a href="http://www.activeconvert.com/exitintents.jsp" target="_blank" title="ActiveConvert"><?php echo '<img src="'.plugins_url( 'activeconvert.png' , __FILE__ ).'" height="17" style="margin-bottom:-1px;"/>';?></a> helps convert your abandoning visitors into customers.</p>
 		
	<div id="acei_register" class="inside" style="padding: -30px 10px"></p>	
        	<div class="postbox" style="max-width:600px;height:50px;padding:30px;">
            	
		<div style="float:left">	
			<b>Activate Exit Intent</b> <br>
			<p>Login or sign up now for free.</p>
		</div>
		<div><a href='https://www.activeconvert.com/exitintents.jsp' class="right button button-primary" target="_blank">Get My API Key</a></div>
		</div>

   		<div class="postbox" style="max-width:600px;height:50px;padding:30px;">
            	<div style="float:left">
			<b>Enter Your API Key</b> <br>
			<p>If you already know your API Key.</p>
		</div>
		<div class="">
		<form id="saveSettings" method="post" action="options.php">
                   <?php wp_nonce_field('update-options') ?>
			<div style="float:right">
			<input type="text" name="acei_widgetID" id="acei_widgetID" placeholder="Your API Key" value="<?php echo(get_option('acei_widgetID')) ?>" style="margin-right:10px;" />
                        <input type="hidden" name="page_options" value="acei_widgetID" />
			<input type="hidden" name="action" value="update" />
                        <input type="submit" class="right button button-primary" name="acei_submit" id="acei_submit" value="<?php _e('Save Key', $acei_domain) ?>" /> 
			</div>
                </form>
		</div>
               
            	
	</div>
	</div>
	

	<div id="acei_registerComplete" class="inside" style="padding: -20px 10px;display:none;">
	<div class="postbox" style="max-width:600px;height:250px;padding:30px;padding-top:5px">
<h3 class=""><span id="sicp_noAccountSpan">Exit Intent Settings</span></h3>
		<p>Customize your popup by selecting 'Customize' below. By default your popup is triggered when a visitor is leaving your site.  You can change this to trigger immediately, or after a configurable amount of time.</p>
		<p>
		<div style="text-align:center">
		
		<a href='https://www.activeconvert.com/dashboard.do?wp=true' class="button button-primary" target="_ac">Dashboard</a>&nbsp;
<a href='https://www.activeconvert.com/campaigns.do' class="button button-primary" target="_ac">Customize</a>&nbsp;
		
<a href='https://www.activeconvert.com/exitintentspreview.do?wid=<?php echo(get_option('acei_widgetID')) ?>' class="button button-primary" target="_ac">Popup Preview</a>&nbsp;
		<br><br><a id="changeWidget" class="" target="_blank">Enter Different API Key</a>&nbsp;
		</div>
		</p>* The popup is only triggered once per browser session.  Open a new browser window to test multiple times.

</div>
</div>
<script>
jQuery(document).ready(function($) {

var acei_wid= $('#acei_widgetID').val();
if (acei_wid=='') 
{}
else
{

	$( "#acei_enterwidget" ).hide();
	$( "#acei_register" ).hide();
	$( "#acei_registerComplete" ).show();
	$( "#acei_noAccountSpan" ).html("Exit Intent Plugin Settings");

}

$(document).on("click", "#acei_inputSaveSettings", function () {
	$( "#saveDetailSettings" ).submit();
});

$(document).on("click", "#changeWidget", function () {
$( "#acei_register" ).show();
$( "#acei_inputSaveSettings" ).hide();
});


});
</script>
<?php }
$acei_domain = plugins_url();
add_submenu_page('options-general.php', __('Exit Intent', $acei_domain), __('Exit Intent', $acei_domain), 'manage_options', 'exit-intent', 'acei_settings_page');
}
function addaceiLink() {
$dir = plugin_dir_path(__FILE__);
include $dir . 'options.php';
}
function acei_create_menu() {
  $optionPage = add_menu_page('Exit Intent', 'Exit Intent', 'administrator', 'acei_dashboard', 'addaceiLink', plugins_url('ac-small-white.png', __FILE__ ));
}
function aceiRedirect() {
$redirectUrl = "https://www.activeconvert.com/dashboard.do?wp=true";
echo "<script> jQuery('a[href=\"admin.php?page=acei_dashboard\"]').attr('href', '".$redirectUrl."').attr('target', '_blank') </script>";}
?>