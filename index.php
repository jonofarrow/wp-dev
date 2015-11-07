<?php get_header(); ?>
<div class="row">
	<div class="col-sm-9">
		<?php
			if(have_posts()):
				while(have_posts()):
					the_post();					
					$post_format = get_post_format();
					get_template_part('parts/post', $post_format);
					?>

					<?php
				endwhile;
			endif;
		?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>