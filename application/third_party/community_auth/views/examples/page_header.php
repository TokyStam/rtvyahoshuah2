
<div id="menu">
	<ul>
		<?php
			$link_protocol = USE_SSL ? 'https' : NULL;

			if( $this->router->default_controller == 'examples/home' )
			{
		?>
		<li>
			<?php echo anchor( site_url('', $link_protocol ),'Home'); ?>
		</li>
		<?php
			}
		?>
		<li><?php
			if( isset( $auth_user_id ) ){
				echo anchor( site_url('examples/logout', $link_protocol ),'Logout');
			}else{
				echo anchor( site_url(LOGIN_PAGE . '?redirect=examples', $link_protocol ),'Login','id="login-link"');
			}
		?></li>
		<?php 
			if( ! isset( $auth_user_id ) ){
				echo '<li>' . anchor( site_url('examples/ajax_login', $link_protocol ),'Ajax Login','id="ajax-login-link"') . '</li>';
			}
		?>
		<li>
			<?php echo anchor( site_url('examples/optional_login_test', $link_protocol ),'Optional Login'); ?>
		</li>
		<li>
			<?php echo anchor( site_url('examples/simple_verification', $link_protocol ),'Simple Verification'); ?>
		</li>
		<li>
			<?php echo anchor( site_url('examples/create_user', $link_protocol ),'Create User'); ?>
		</li>
	</ul>
</div>

<?php

/* End of file page_header.php */
/* Location: /community_auth/views/examples/page_header.php */