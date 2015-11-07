<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<?php if(has_post_thumbnail()): ?>
		<a class="alignLeft" href="<?php the_permalink(); ?>">
			<?php 
				the_post_thumbnail('thumbnail',array('class' => 'media-object'));
			?>
		</a>
	<?php endif; ?>
	
	<div class="media-body">
		<h1 class="media-heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<section class="entry">
			<?php the_excerpt(); ?>
		</section>
	</div>
	
	<nav>
		<?php wp_link_pages(); ?>
	</nav>
</article>