
<div class="control-box">
	<fieldset>
	<!--<legend><?php // echo sprintf( esc_html( $description ), $desc_link );    ?></legend>-->

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="<?php echo esc_attr( $args[ 'content' ] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label></th>
					<td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args[ 'content' ] . '-name' ); ?>" /></td>
				</tr>

				<tr>
					<th scope="row"><label for="<?php echo esc_attr( $args[ 'content' ] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?></label></th>
					<td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args[ 'content' ] . '-id' ); ?>" /></td>
				</tr>

				<tr>
					<th><label>Theme:</label></th>
					<td>
						<input type="checkbox" name="theme:dark" class="option" />&nbsp;<?php echo esc_html( __( "Use dark theme for No CAPTCHA reCAPTCHA?", 'google-nocaptcha-recaptcha-locale' ) ); ?>
					</td>
				</tr>


			</tbody>
		</table>
	</fieldset>
</div>

<div class="insert-box">
	<div class="tg-tag"><?php echo esc_html( __( "Copy this code and paste it into the form on the left.", 'contact-form-7' ) ); ?><br />
		<input type="text" name="recaptcha" class="tag wp-ui-text-highlight code" readonly="readonly" onfocus="this.select()" /></div>

	<div class="submitbox">
		<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
	</div>
</div>


