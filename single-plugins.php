<?php get_header(); ?>
<div id="content-wrap" class="row-fluid">
  
  <div id="content" class="span8 plugin-post" itemtype="http://schema.org/Product" itemscope="">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <section <?php post_class() ?> id="post-<?php the_ID(); ?>">
     
	<?php

	global $post;
	$banner	= get_post_meta($post->ID, '_rkv_plugin_img', true);
	$slug	= get_post_meta($post->ID, '_rkv_plugin_slug', true);

	$data	= rkv_plugin_data($slug);
	$data	= unserialize($data);
//	echo preprint( $data );

	// plugin data
	$plugin_name	= $data->name;
	$plugin_slug	= $data->slug;
	$tags			= $data->tags;
	
/*
	$version		= $data->version;
	$requires		= $data->requires;
	$updated		= $data->last_updated;
	$downloaded		= $data->downloaded;
	$dl_link		= $data->download_link;
	$wordpress		= 'http://wordpress.org/extend/plugins/'.$slug.'/';
	$support		= 'http://wordpress.org/support/plugin/'.$slug.'/';
*/	
	// break out sections
	$sections		= $data->sections;
	$description	= $sections['description'];
	$installation	= $sections['installation'];
	$screenshots	= $sections['screenshots'];
	$changelog		= $sections['changelog'];
	$faqs			= $sections['faq'];

//	echo '<a target="_blank" href="'.$wordpress.'">';
	echo '<img src="'.$banner.'" alt="'.$plugin_name.'" title="'.$plugin_name.'">';
//	echo '</a>';
	echo '<h3 itemprop="name">'.$plugin_name.'</h3>';

	echo '<div class="plugin-detail-nav">';
		echo '<a id="description" class="btn"><i class="icon-book"></i> <span class="hidden-phone">Description</span></a>';
		echo '<a id="installation" class="btn"><i class="icon-hdd"></i> <span class="hidden-phone">Installation</span></a>';
		echo '<a id="screenshots" class="btn"><i class="icon-picture"></i> <span class="hidden-phone">Screenshots</span></a>';
		echo '<a id="faqs" class="btn"><i class="icon-question-sign"></i> <span class="hidden-phone">FAQs</span></a>';
		echo '<a id="changelog" class="btn"><i class="icon-bar-chart"></i> <span class="hidden-phone">Changelog</span></a>';
	echo '</div>';

	echo '<div class="plugin-detail-block entry-content">';
		echo '<div class="plugin-detail-data description-data container-fluid" rel="description">';
		echo $description;
		if (!empty($tags)) {
			echo '<p class="plugin-tags"><strong>Tagged:</strong> ';
			foreach ($tags as $tag) {
				echo '<span class="badge">'.$tag.'</span>';
			}
			echo '</p>';
		}		
		echo '</div>';

		echo '<div class="plugin-detail-data installation-data container-fluid" rel="installation">';
		echo $installation;
		echo '</div>';

		echo '<div class="plugin-detail-data screenshots-data container-fluid" rel="screenshots">';
		echo $screenshots;
		echo '</div>';

		echo '<div class="plugin-detail-data faqs-data container-fluid" rel="faqs">';
		echo $faqs;
		echo '</div>';

		echo '<div class="plugin-detail-data changelog-data container-fluid" rel="changelog">';
		echo $changelog;
		echo '</div>';
	
	echo '</div>';

    ?>

    </section>


    <?php endwhile; endif; ?>
  
  </div><!--/span-->
        
	<?php get_sidebar(); ?>

</div><!--/row-->
<?php get_footer(); ?>
