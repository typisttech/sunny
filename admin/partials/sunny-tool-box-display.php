<?php
/**
 * Represents the URL Purger view for the administration dashboard.
 *
 * @link       http://tangrufus.com
 * @since      1.1.0
 *
 * @package    Sunny
 * @subpackage Sunny/admin/partials
 */
?>

<?php $id = $metabox['args']['id']; ?>
<?php $desc = $metabox['args']['desc']; ?>
<?php $action = $metabox['args']['action']; ?>
<?php $btn_text = $metabox['args']['btn_text']; ?>

<div id="<?php echo $id; ?>" class="wrap">
	<form id="sunny_<?php echo $id; ?>_form" method="POST" action="/wp-admin/admin-post.php">
		<?php echo $desc ?>
		<br />
		<?php
		// settings_fields($option_group)
		$option_group = 'sunny_tools_' . $id;
		echo "<input type='hidden' name='option_page' value='" . esc_attr($option_group) . "' />";
		echo "<input type='hidden' name='action' value='$action' />";
		wp_nonce_field("$option_group-options");
		?>

		<?php do_settings_sections( 'sunny_tools_' . $id ); ?>
		<?php submit_button( $btn_text, 'primary', $id . '_button' ); ?>
	</form>
	<br class="clear">
	<div id="sunny_<?php echo $id; ?>_result" style="display: none">
		<h3 id="sunny_<?php echo $id; ?>_result_heading">Result</h3>
		<img id="sunny_<?php echo $id; ?>_form_spinner" style="display: none" src="<?php echo admin_url(); ?>images/spinner-2x.gif">
	</div>
</div>
