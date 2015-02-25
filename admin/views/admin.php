<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Wdm_Google_Nocaptcha_Recaptcha
 * @author    WisdmLabs <support@wisdmlabs.com>
 * @license   GPL-2.0+
 * @link      http://wisdmlabs.com
 * @copyright 2014 WisdmLabs 
 */
?>

<div class="wrap">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<form method="post" action="options.php"> 
		<?php @settings_fields( $this->option_name ); ?>
		<?php do_settings_sections( $this->plugin_slug ); ?>
    
		<?php submit_button(); ?>
	</form>

</div>
