<?php 







// Custom Post Type


add_action('init', 'create_project_cpt');
// Register Custom Post Type project
function create_project_cpt() {

	$labels = array(
		'name' => _x( 'projects', 'Post Type General Name', 'my-basics-plugin' ),
		'singular_name' => _x( 'project', 'Post Type Singular Name', 'my-basics-plugin' ),
		'menu_name' => _x( 'projects', 'Admin Menu text', 'my-basics-plugin' ),
		'name_admin_bar' => _x( 'project', 'Add New on Toolbar', 'my-basics-plugin' ),
		'archives' => __( 'project Archives', 'my-basics-plugin' ),
		// 'attributes' => __( 'Name', 'my-basics-plugin' ),
		'parent_item_colon' => __( 'Parent project:', 'my-basics-plugin' ),
		'all_items' => __( 'All projects', 'my-basics-plugin' ),
		'add_new_item' => __( 'Add New project', 'my-basics-plugin' ),
		'add_new' => __( 'Add New', 'my-basics-plugin' ),
		'new_item' => __( 'New project', 'my-basics-plugin' ),
		'edit_item' => __( 'Edit project', 'my-basics-plugin' ),
		'update_item' => __( 'Update project', 'my-basics-plugin' ),
		'view_item' => __( 'View project', 'my-basics-plugin' ),
		'view_items' => __( 'View projects', 'my-basics-plugin' ),
		'search_items' => __( 'Search project', 'my-basics-plugin' ),
		'not_found' => __( 'Not found', 'my-basics-plugin' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'my-basics-plugin' ),
		'featured_image' => __( 'Featured Image', 'my-basics-plugin' ),
		'set_featured_image' => __( 'Set featured image', 'my-basics-plugin' ),
		'remove_featured_image' => __( 'Remove featured image', 'my-basics-plugin' ),
		'use_featured_image' => __( 'Use as featured image', 'my-basics-plugin' ),
		'insert_into_item' => __( 'Insert into project', 'my-basics-plugin' ),
		'uploaded_to_this_item' => __( 'Uploaded to this project', 'my-basics-plugin' ),
		'items_list' => __( 'projects list', 'my-basics-plugin' ),
		'items_list_navigation' => __( 'projects list navigation', 'my-basics-plugin' ),
		'filter_items_list' => __( 'Filter projects list', 'my-basics-plugin' ),
	);
	$args = array(
		'label' => __( 'project', 'my-basics-plugin' ),
		'description' => __( 'This is Just an sample Text.', 'my-basics-plugin' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-admin-generic',
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments', 'post-formats'),
		'taxonomies' => array( 'category', 'post_tag' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'rewrite'     => array( 'slug' => 'project' )

	);

	register_post_type( 'project', $args );
}













// // Meta New




 function register_metabox(){

      add_meta_box( "cpt-id", "Details", "call_metabox","project","side","high");

 }

 add_action("add_meta_boxes","register_metabox");



 function call_metabox($post){
?>
    <p>
     <label> Name </label>
	 <?php  $name = get_post_meta($post->ID,"post_name",true) ?>
	 <input type="text" value="<?php echo $name ?>" name="textName" placeholder="Name"/>
    </p>

    <p>
     <label> Email </label>
	 <?php  $email = get_post_meta($post->ID,"post_email",true) ?>
	 <input type="email" value="<?php echo $email ?>" name="textEmail" placeholder="Email"/>
    </p>

<?php


 }



// getting data from (custom field) metabox 



 add_action("save_post","save_values",10,2);

 function save_values($post_id, $post){

	$textName = isset($_POST['textName'])?$_POST['textName']:"";
	$textEmail = isset($_POST['textEmail'])?$_POST['textEmail']:"";

	update_post_meta( $post_id,"post_name",$textName);
	update_post_meta( $post_id,"post_email",$textEmail);
 }






// ShortCode

 function shortcode_movie_post_type()
{
    $curentpage = get_query_var('paged');
    $args = array(
                    'post_type'      => 'project',
                    'posts_per_page' => '3',
                    'publish_status' => 'published',
                    'paged' => $curentpage
                 );
  
    $query = new WP_Query($args);
  
    $result = '';
    if($query->have_posts()) :
  
        while($query->have_posts()) :
  
            $query->the_post();
          
            $result = $result . "<h2>" . get_the_title() . "</h2>";
            $result = $result . get_the_post_thumbnail();
            $result = $result . "<p>" . get_the_content() . "</p>";

        endwhile;
        
        wp_reset_postdata();
        
           
        echo paginate_links(array(
            'total' => $query->max_num_pages
        )); 
    endif;    

    return $result;
            
}
  
add_shortcode( 'list', 'shortcode_movie_post_type' ); 
  
// shortcode code ends here



//Equeue Styles
function themeslug_enqueue() {
    wp_enqueue_style( 'my-theme',get_stylesheet_uri());
	wp_enqueue_script( 'script', get_template_directory_uri() . '../js/script.js');
}
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue');