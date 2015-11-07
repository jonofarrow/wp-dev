<hr />
<footer>
	<nav>
		<?php
			wp_nav_menu(
				array(
					'menu_class' => 'nav nav-pills',
					'theme_location' => 'footer',
					'fallback_cb' => false
				)
			);
		?>
	</nav>
</footer>
</div><!--closes .container-->
<?php wp_footer(); ?>
</body>
</html>