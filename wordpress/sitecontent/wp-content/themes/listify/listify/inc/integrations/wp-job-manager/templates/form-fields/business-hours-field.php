<?php
/**
 *
 */

global $wp_locale;

if ( is_admin() ) {
	global $field;
}
?>

<table>
	<tr>
		<th width="50%">&nbsp;</th>
		<th align="left"><?php _e( 'Open', 'listify' ); ?></th>
		<th align="left"><?php _e( 'Close', 'listify' ); ?></th>
	</tr>

	<?php for ( $i = 0; $i <= 6; $i++ ) : ?>
		<tr>
			<td align="left"><?php echo $wp_locale->get_weekday( $i ); ?></td>
			<td align="left" class="business-hour"><input type="text" class="timepicker" name="job_hours[<?php echo $i;
			?>][start]" value="<?php echo isset( $field[ 'value' ][ $i ] ) && isset( $field[ 'value' ][ $i ][ 'start' ] ) ? $field[ 'value' ][ $i ][ 'start' ] : ''; ?>" class="regular-text" /></td>
			<td align="left" class="business-hour"><input type="text" class="timepicker" name="job_hours[<?php echo $i;
			?>][end]" value="<?php echo isset( $field[ 'value' ][ $i ] ) && isset( $field[ 'value' ][ $i ][ 'end' ] )
			?$field[ 'value' ][ $i ][ 'end' ] : ''; ?>" class="regular-text" /></td>
		</tr>
	<?php endfor; ?>
</table>
