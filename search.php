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

				<?php endwhile; ?>
				<ul class="nav nav-pills">
					<li class="alignLeft"><?php previous_posts_link('&laquo; Previous Entries'); ?></li>
					<li class="alignRight"><?php next_posts_link('Next Entries &raquo;',''); ?></li>
				</ul>
			<?php endif; ?>
			
			<section class="searchform">
				<h1 class="page-header">
					<?php
						_e('Not what you were looking for?<br /><small>Enter your search terms to try again.</small>','ofarrow')
					?>
				</h1>
				
				<?php get_search_form(); ?>
			</section>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>