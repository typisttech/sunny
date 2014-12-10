<?php

/**
 * Represents the `Purge All` button view for the administration dashboard.
 *
 * @package    Sunny
 * @subpackage Sunny/admin/partials
 * @author     Tang Rufus <rufus@wphuman.com>
 * @since      1.4.0
 */
?>

<form action="options.php" method="POST">
	<?php settings_fields( 'sunny_settings' ); ?>
	<?php do_settings_sections( 'sunny_settings_' . $active_tab ); ?>
	<?php submit_button(); ?>
</form>
<br class="clear" />
