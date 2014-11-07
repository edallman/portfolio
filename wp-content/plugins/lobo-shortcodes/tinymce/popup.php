<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new lobo_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="lobo-popup">

	<div id="lobo-shortcode-wrap">
		
		<div id="lobo-sc-form-wrap">
		
			<div id="lobo-sc-form-head">
			
				<?php echo $shortcode->popup_title; ?>
			
			</div>
			<!-- /#lobo-sc-form-head -->
			
			<form method="post" id="lobo-sc-form">
			
				<table id="lobo-sc-form-table">
				
					<?php echo $shortcode->output; ?>
					
					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button-primary lobo-insert">Insert Shortcode</a></td>							
						</tr>
					</tbody>
				
				</table>
				<!-- /#lobo-sc-form-table -->
				
			</form>
			<!-- /#lobo-sc-form -->
		
		</div>
		<!-- /#lobo-sc-form-wrap -->
		
		<div class="clear"></div>
		
	</div>
	<!-- /#lobo-shortcode-wrap -->

</div>
<!-- /#lobo-popup -->

</body>
</html>