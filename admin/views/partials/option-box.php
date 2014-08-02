<?php
/**
 * Represents the `Purge All` button view for the administration dashboard.
 *
 * @package 	Sunny
 * @subpackage 	Sunny_Admin
 * @author 		Tang Rufus <tangrufus@gmail.com>
 * @license  	GPL-2.0+
 * @link  		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @since 		1.2.0
 */
?>

<form action="options.php" method="POST">
	<?php settings_fields( $this->option_group ); ?>
	<?php do_settings_sections( $this->option_group ); ?>
	<?php submit_button( $this->button_text ); ?>
</form>
<br class="clear" />