<?php

/**
 * Represents the `Purge All` button view for the administration dashboard.
 *
 * @link       http://tangrufus.com
 * @since      1.4.0
 *
 * @package    Sunny
 * @subpackage Sunny/admin/partials
 */
?>

<form action="options.php" method="POST">
	<?php settings_fields( 'sunny_settings_' . $active_tab ); ?>
	<?php do_settings_sections( 'sunny_settings_' . $active_tab ); ?>
	<?php submit_button( $this->button_text, $this->button_type ); ?>
</form>
<br class="clear" />