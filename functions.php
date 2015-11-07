<?php
if(!function_exists('ofarrow_setup_theme')){
	function ofarrow_setup_theme(){
		//theme hook alliance hooks
		require_once(get_template_directory() . '/inc/hooks.php');
		require_once(get_template_directory() . '/inc/navwalker.php');
		
		
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(150,150);
		add_theme_support('custom-background');
		add_theme_support('custom-header',
			array(
				'flex-width' => false,
				'width' => 1160,
				'flex-height' => true,
				'height' => 200
			)
		);
		add_theme_support('post-formats',
			array(
				'aside',
				'gallery',
				'link',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat'
			)
		);
		
		register_nav_menus(
			array(
				'header' => __('Header Navigation', 'ofarrow'),
				'footer' => __('Footer Navigation', 'ofarrow')
			)
		);
		
		register_sidebar(
			array(
				'name' => __('Sidebar', 'ofarrow'),
				'description' => __('This is a regular ofarrow.net sidebar', 'ofarrow'),
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>'
			)
		);
	}
}

add_action('after_setup_theme', 'ofarrow_setup_theme');
/***************************************************************************/
function ofarrow_load_scripts(){
	if(!is_admin()){
		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'));
		
		if(is_singular() && comments_open() && get_option('thread_comments')){
			wp_enqueue_script('comment-reply');
		}
		
		wp_enqueue_style('style',get_stylesheet_uri());
	}
}

add_action('wp_enqueue_scripts', 'ofarrow_load_scripts');
/***************************************************************************/
if(!function_exists('ofarrow_breadcrumbs')){
	function ofarrow_breadcrumbs(){
		global $post, $page;
		
		echo '<ul xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumb">';
			if(!is_home() || !is_front_page() || !is_paged()){
				echo '
					<li>
						<span typeof="v:Breadcrumb">
							<a rel="v:url" property="v:title" href="'.esc_url(get_home_url()).'">'.
							__('Home', 'ofarrow').
							'</a>
						</span>
					</li>
				';
				
				if(is_category()){
					$category = get_the_category();
					if($category){
						foreach($category as $category){
							echo '
								<li>
									<span typeof="v:Breadcrumb">
										<a rel="v:url" property="v:title" href="'.get_category_link($category->term_id).'">'.
										$category->name.
										'</a>
									</span>
								</li>
							';
						
						}
					}
					echo '
						<li>
							<span typeof="v:Breadcrumb">'.
								sprintf(__('Posts filed under <q>%s</q>'),single_cat_title('', false)).
							'</span>
						</li>
					';
				}
				else if(is_day()){
					echo '
						<li>
							<span typeof="v:Breadcrumb">
								<a rel="v:url" property="v:title" href="'.get_year_link(get_the_time('Y')).'">'.
									get_the_time('Y').
								'</a>
							</span>
						</li>
						<li>
							<span typeof="v:Breadcrumb">
								<a rel="v:url" property="v:title" href="'.get_month_link(get_the_time('Y'),get_the_time('m')).'">'.
									get_the_time('F').
								'</a>
							</span>
						</li>
						<li>
							<span typeof="v:Breadcrumb">'.
								get_the_time('d').
							'</span>
						</li>
					';
				}
				else if(is_month()){
					echo '
						<li>
							<span typeof="v:Breadcrumb">
								<a rel="v:url" property="v:title" href="'.get_year_link(get_the_time('Y')).'">'.
									get_the_time('Y').
								'</a>
							</span>
						</li>
						<li>
							<span typeof="v:Breadcrumb">'.
								get_the_time('F').
							'</span>
						</li>
					';
				}
				else if(is_year()){
					echo '
						<li>
							<span typeof="v:Breadcrumb">'.
								get_the_time('Y').
							'</span>
						</li>
					';
				}
				else if(is_single() && !is_attachment()){
					//custom post types (not post formats) may not use categories
					if(get_post_type() != 'post'){
						$post_type = get_post_type_object(get_post_type());
						$slug = $post_type->rewrite;
						echo '
							<li>
								<span typeof="v:Breadcrumb">
									<a rel="v:url" property="v:title" href="'.home_url().'/'.$slug["slug"].'/">'.
										$post_type->labels->singular_name.
									'</a>
								</span>
							</li>
							<li>
								<span typeof="v:Breadcrumb">'.
										get_the_title().
								'</span>
							</li>
						';
					}
					else{
						$category = get_the_category();
						if($category){
							foreach($category as $category){
								echo '
									<li>
										<span typeof="v:Breadcrumb">
											<a rel="v:url" property="v:title" href="'.get_category_link($category->term_id).'">'.
											$category->name.
											'</a>
										</span>
									</li>
								';
							}
						}
						echo '
							<li>
								<span typeof="v:Breadcrumb">'.
										get_the_title().
								'</span>
							</li>
						';
					}
				}
				//may be a post type "archive"
				//either way just display the name of the post type
				else if(!is_single() && !is_page() && get_post_type() != 'post' && !is_404()){
					$post_type = get_post_type_object(get_post_type());
					echo '
						<li>
							<span typeof="v:Breadcrumb">'.
									$post_type->labels->singular_name.
							'</span>
						</li>
					';
				}
				//attachment page
				//a single page which displays an single image or video
				//get the parent post that the attachment is linked to
				else if(is_attachment()){
					$parent = get_post($post->post_parent);
					$category = get_the_category($parent->ID);
					if($category){
						foreach($category as $category){
							echo '
								<li>
									<span typeof="v:Breadcrumb">
										<a rel="v:url" property="v:title" href="'.get_category_link($category->term_id).'">'.
										$category->name.
										'</a>
									</span>
								</li>
							';
						}
					}
					echo '
						<li>
							<span typeof="v:Breadcrumb">'.
									get_the_title().
							'</span>
						</li>
					';
					
				}
				else if(is_page() && !$post->post_parent){
					echo '
						<li>
							<span typeof="v:Breadcrumb">'.
									get_the_title().
							'</span>
						</li>
					';
				}
				else if(is_page() && $post->post_parent){
					$parent_id = $post->post_parent;
					$breadcrumbs = array();
					while($parent_id){
						$page = get_post($parent_id);
						$breadcumbs[] = '
							<li>
								<span typeof="v:Breadcrumb">
									<a rel="v:url" property="v:title" href="'.get_permalink($page->ID).'">'.
									get_the_title($page->ID).
									'</a>
								</span>
							</li>
						';
						$parent_id = $page->post_parent;
					}
					
					$breadcrumbs = array_reverse($breadcrumbs);
					foreach($breadcrumbs as $crumb){
						echo $crumb;
					}
					
					echo '
						<li class="active">
							<span typeof="v:Breadcrumb">'.
									get_the_title().
							'</span>
						</li>
					';
				}
				else if(is_search()){
					echo '
						<li class="active">
							<span typeof="v:Breadcrumb">'.
									sprintf(__('Search results for <q>%s</q>','ofarrow'),esc_attr(get_search_query())).
							'</span>
						</li>
					';
				}
				else if(is_tag()){
					echo '
						<li class="active">
							<span typeof="v:Breadcrumb">'.
									sprintf(__('Posts tagged <q>%s</q>','ofarrow'),single_tag_title('',false)).
							'</span>
						</li>
					';
				}
				else if(is_author()){
					global $author;
					echo '
						<li class="active">
							<span typeof="v:Breadcrumb">'.
									sprintf(__('All posts by %s','ofarrow'),get_the_author_meta('display_name',$author)).
							'</span>
						</li>
					';
				}
				else if(is_404()){
					global $author;
					echo '
						<li class="active">
							<span typeof="v:Breadcrumb">'.
								__('Error 404','ofarrow').
							'</span>
						</li>
					';
				}
			}
			
			if(is_paged()){
				$front_page_ID = get_option('page_for_posts');
				$paged = get_query_var('paged');
				//check to see if we are on any kind of archive page
				if(is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()){
					echo '&nbsp;<span class="active paged">('.sprintf(__('Page %s','ofarrow'),esc_attr($paged)).')</span>';
				}
				else{
					echo '
						<li>
							<span typeof="v:Breadcrumb">
								<a rel="v:url" property="v:title" href="'.esc_url(get_home_url()).'">'.
									__('Home','ofarrow').
								'</a>
							</span>
						</li>
						<li>
							<span typeof="v:Breadcrumb">
								<a rel="v:url" property="v:title" href="'.esc_url(get_home_url()).'/?p='.$front_page_ID.'">'.
									__('Blog','ofarrow').
								'</a>
							</span>
						</li>
						<li class="active paged">'.
							sprintf(_('Page %s','ofarrow'),esc_attr($paged)).
						'</li>
					';
				}
			}
		echo '</ul>';
	}
	
	add_action('tha_content_top', 'ofarrow_breadcrumbs');
}
?>