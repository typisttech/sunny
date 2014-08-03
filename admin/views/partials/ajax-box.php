<?php
/**
 * Represents the URL Purger view for the administration dashboard.
 *
 * @package 	Sunny
 * @subpackage 	Sunny_Admin
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @license  	GPL-2.0+
 * @link  		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @since 		1.1.0
 */
?>

<div id="<?php echo $this->option_group; ?>" class="wrap">
	<form id="<?php echo $this->option_group; ?>_form" method="POST">
		<?php wp_nonce_field( $this->option_group, $this->option_group . '_nonce'); ?>
		<?php do_settings_sections( $this->option_group ); ?>
		<?php submit_button( $this->button_text, $this->button_type, $this->option_group . '_button' ); ?>
	</form>
	<br class="clear">
	<div id="<?php echo $this->option_group; ?>_result" style="display: none">
		<h3 id="<?php echo $this->option_group; ?>_result_heading">URL Purger Result</h3>
		<img id="<?php echo $this->option_group; ?>_form_spinner" style="display: none" src="<?php echo admin_url(); ?>images/spinner-2x.gif">
	</div>
</div>
