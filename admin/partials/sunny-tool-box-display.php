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

<?php
$id 		= $metabox['args']['id'];
$desc 		= $metabox['args']['desc'];
$action		= $metabox['args']['action'];
$btn_text 	= $metabox['args']['btn_text'];

$has_result = !empty( $_GET[ 'result' ] ) && $_GET[ 'result'] == $id;
$message	= !empty( $_GET['message'] ) ? $_GET['message'] : '';
// We turned line breaks into !!!!! at sunny-class-tools-handler.php
$message	=  str_replace( '!!!!!', '<br />', $message );
?>

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
		<br class="clear">
		<?php submit_button( $btn_text, 'primary', 'sunny_' . $id . '_button' ); ?>
	</form>
	<br class="clear">

	<?php if ( ! $has_result ) { ?>

	<!--Ajax Result-->
	<div id="sunny_<?php echo $id; ?>_result" style="display: none">
		<h3 id="sunny_<?php echo $id; ?>_result_heading">Result</h3>
		<hr>
		<img id="sunny_<?php echo $id; ?>_form_spinner" style="display: none" src="<?php echo admin_url(); ?>images/spinner-2x.gif">
	</div><!--/Ajax Result-->

	<?php } else { ?>

	<!--Non-Ajax Result-->
	<div id="sunny_<?php echo $id; ?>_result">
		<h3 id="sunny_<?php echo $id; ?>_result_heading">Result</h3>
		<hr>
		<p><?php echo $message; ?></p>
	</div><!--/Non-Ajax Result-->

	<?php } // end else ?>

</div>
