<!DOCTYPE html>
<?php tha_html_before(); ?>
<html <?php language_attributes(); ?>>
    <head>
		<?php tha_head_top(); ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
		<link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
        <title><?php wp_title(); ?></title>
		<?php tha_head_bottom(); ?>
        <?php wp_head(); ?>
    </head>

	<body <?php body_class(); ?>>
		<?php tha_body_top(); ?>
		<div class="container">
			<?php if(get_header_image()): ?>
				<?php tha_header_before(); ?>
				<header class="row header-image">
					<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" />
			<?php else: ?>
				<header class="row">
			<?php endif; ?>
				<?php tha_header_top(); ?>
				<hgroup class="col-sm-12">
					<h2>
						<a href=<?php echo home_url(); ?>" title="<?php bloginfo('title'); ?>">
							<?php bloginfo('title'); ?>
						</a>
					</h2>
					
					<h3>
						<?php bloginfo('description'); ?>
					</h3>
					
					<nav class="navbar" role="navigation">
						<?php
							wp_nav_menu(
								array(
									'container_class' => 'navbar-inner nav-collapse',
									'menu_class' => 'nav',
									'theme_location' => 'header',
									'fallback_cb' => false,
									'walker' => new wp_bootstrap_navwalker,
								)
							);
						?>
					</nav>
				</hgroup>
			</header>
			<?php tha_content_top(); ?>