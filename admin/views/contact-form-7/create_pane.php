<div id="cf7_nocaptcha_pane" class="hidden">
	<form action="">
		<table>
			<tr><td><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?><br /><input type="text" name="name" class="tg-name oneline" /></td><td></td></tr>
		</table>
		<table>
			<tr>
				<td>
					<input type="checkbox" name="theme:dark" class="option" />&nbsp;<?php echo esc_html( __( "Use dark theme for No CAPTCHA reCAPTCHA?", 'google-nocaptcha-recaptcha-locale' ) ); ?>
				</td>
			</tr>
		</table>
		<div class="tg-tag"><?php echo esc_html( __( "Copy this code and paste it into the form on the left.", 'contact-form-7' ) ); ?><br /><input type="text" name="recaptcha" class="tag wp-ui-text-highlight code" readonly="readonly" onfocus="this.select()" /></div>
	</form>
</div>