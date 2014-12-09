<?php
/**
 * @category Virtue Theme
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'virtue_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
//add_filter('cmb_icomoon', 'cmb_icomoon');
add_filter( 'cmb_render_imag_select_taxonomy', 'imag_render_imag_select_taxonomy', 10, 2 );
function imag_render_imag_select_taxonomy( $field, $meta ) {

    wp_dropdown_categories(array(
            'show_option_none' => __( "All", 'virtue' ),
            'hierarchical' => 1,
            'taxonomy' => $field['taxonomy'],
            'orderby' => 'name', 
            'hide_empty' => 0, 
            'name' => $field['id'],
            'selected' => $meta  

        ));
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';
}
add_filter( 'cmb_render_imag_select_category', 'imag_render_imag_select_category', 10, 2 );
function imag_render_imag_select_category( $field, $meta ) {

    wp_dropdown_categories(array(
            'show_option_none' => __( "All Blog Posts", 'virtue' ),
            'hierarchical' => 1,
            'taxonomy' => 'category',
            'orderby' => 'name', 
            'hide_empty' => 0, 
            'name' => $field['id'],
            'selected' => $meta  

        ));
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
add_filter( 'cmb_render_imag_select_sidebars', 'imag_render_imag_select_sidebars', 10, 2 );
function imag_render_imag_select_sidebars( $field, $meta ) {
	global $vir_sidebars;	
	
	 echo '<select name="', $field['id'], '" id="', $field['id'], '">';
  foreach ($vir_sidebars as $side) {
    echo '<option value="', $side['id'], '"', $meta == $side['id'] ? ' selected="selected"' : '', '>', $side['name'], '</option>';
  }
  echo '</select>';
	
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
function virtue_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_kad_';

	$meta_boxes[] = array(
				'id'         => 'subtitle_metabox',
				'title'      => __( "Page Title and Subtitle", 'virtue' ),
				'pages'      => array( 'page', ), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
					array(
						'name' => __( "Subtitle", 'virtue' ),
						'desc' => __( "Subtitle will go below page title", 'virtue' ),
						'id'   => $prefix . 'subtitle',
						'type' => 'textarea_small',
					),
				)
			);

	$meta_boxes[] = array(
				'id'         => 'post_metabox',
				'title'      => __("Post Options", 'virtue'),
				'pages'      => array( 'post',), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __("Head Content", 'virtue' ),
				'desc'    => '',
				'id'      => $prefix . 'blog_head',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Default', 'virtue' ), 'value' => 'default', ),
					array( 'name' => __("None", 'virtue' ), 'value' => 'none', ),
					array( 'name' => __("Image Slider", 'virtue' ), 'value' => 'flex', ),
					array( 'name' => __("Video", 'virtue' ), 'value' => 'video', ),
					array( 'name' => __("Image", 'virtue' ), 'value' => 'image', ),
				),
			),
			array(
				'name' => __("Max Image/Slider Height", 'virtue' ),
				'desc' => __("Default is: 400 <b>(Note: just input number, example: 350)</b>", 'virtue' ),
				'id'   => $prefix . 'posthead_height',
				'type' => 'text_small',
			),
			array(
				'name' => __("Max Image/Slider Width", 'virtue' ),
				'desc' => __("Default is: 770 or 1140 on fullwidth posts <b>(Note: just input number, example: 650, does not apply to carousel slider)</b>", 'virtue' ),
				'id'   => $prefix . 'posthead_width',
				'type' => 'text_small',
			),
			array(
				'name'    => __("Post Summary", 'virtue' ),
				'desc'    => '',
				'id'      => $prefix . 'post_summery',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Default', 'virtue' ), 'value' => 'default', ),
					array( 'name' => __('Text', 'virtue' ), 'value' => 'text', ),
					array( 'name' => __('Portrait Image', 'virtue'), 'value' => 'img_portrait', ),
					array( 'name' => __('Landscape Image', 'virtue'), 'value' => 'img_landscape', ),
					array( 'name' => __('Portrait Image Slider', 'virtue'), 'value' => 'slider_portrait', ),
					array( 'name' => __('Landscape Image Slider', 'virtue'), 'value' => 'slider_landscape', ),
					array( 'name' => __('Video', 'virtue'), 'value' => 'video', ),
				),
			),
			array(
				'name' => __('Display Sidebar?', 'virtue'),
				'desc' => __('Choose if layout is fullwidth or sidebar', 'virtue'),
				'id'   => $prefix . 'post_sidebar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'virtue'), 'value' => 'yes', ),
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
				),
			),
			array(
				'name'    => __('Choose Sidebar', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
			),
			array(
				'name' => __('Author Info', 'virtue'),
				'desc' => __('Display an author info box?', 'virtue'),
				'id'   => $prefix . 'blog_author',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'virtue'), 'value' => 'yes', ),
				),
			),	
			array(
				'name' => __('Posts Carousel', 'virtue'),
				'desc' => __('Display a carousel with similar or recent posts?', 'virtue'),
				'id'   => $prefix . 'blog_carousel_similar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
					array( 'name' => __('Yes - Display Recent Posts', 'virtue'), 'value' => 'recent', ),
					array( 'name' => __('Yes - Display Similar Posts', 'virtue'), 'value' => 'similar', )
				),
				
			),
			array(
				'name' => __('Carousel Title', 'virtue'),
				'desc' => __('ex. Similar Posts', 'virtue'),
				'id'   => $prefix . 'blog_carousel_title',
				'type' => 'text_medium',
			),
		),
	);
$meta_boxes[] = array(
				'id'         => 'post_video_metabox',
				'title'      => __('Post Video Box', 'virtue'),
				'pages'      => array( 'post',), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, 
				'fields' => array(
			
					array(
						'name' => __('If Video Post', 'virtue'),
						'desc' => __('Place Embed Code Here, works with youtube, vimeo...', 'virtue'),
						'id'   => $prefix . 'post_video',
						'type' => 'textarea_code',
					),
				),
	);
	$meta_boxes[] = array(
				'id'         => 'portfolio_post_metabox',
				'title'      => __('Portfolio Post Options', 'virtue'),
				'pages'      => array( 'portfolio' ), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __('Project Layout', 'virtue'),
				'desc'    => '<a href="http://docs.kadencethemes.com/virtue/#portfolio_posts" target="_new" >Whats the difference?</a>',
				'id'      => $prefix . 'ppost_layout',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => __('Beside', 'virtue'), 'value' => 'beside', ),
					array( 'name' => __('Above', 'virtue'), 'value' => 'above', ),
					array( 'name' => __('Three Rows', 'virtue'), 'value' => 'three', ), 
				),
			),
			array(
				'name'    => __('Project Options', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'ppost_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Image', 'virtue'), 'value' => 'image', ),
					array( 'name' => __('Image Slider', 'virtue'), 'value' => 'flex', ),
					array( 'name' => __('Carousel Slider', 'virtue'), 'value' => 'carousel', ),
					array( 'name' => __('Video', 'virtue'), 'value' => 'video', ),
					array( 'name' => __('None', 'virtue'), 'value' => 'none', ),
				),
			),
			array(
				'name' => __("Max Image/Slider Height", 'virtue' ),
				'desc' => __("Default is: 450 <b>(Note: just input number, example: 350)</b>", 'virtue' ),
				'id'   => $prefix . 'posthead_height',
				'type' => 'text_small',
			),
			array(
				'name' => __("Max Image/Slider Width", 'virtue' ),
				'desc' => __("Default is: 670 or 1140 on <b>above</b> or <b>three row</b> layouts (Note: just input number, example: 650)</b>", 'virtue' ),
				'id'   => $prefix . 'posthead_width',
				'type' => 'text_small',
			),
			array(
				'name' => __('Auto Play Slider?', 'virtue'),
				'desc' => '',
				'id'   => $prefix . 'portfolio_autoplay',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'virtue'), 'value' => 'Yes', ),
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
				),
			),
			array(
				'name' => __('Value 01 Title', 'virtue'),
				'desc' => __('ex. Project Type:', 'virtue'),
				'id'   => $prefix . 'project_val01_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 01 Description', 'virtue'),
				'desc' => __('ex. Character Illustration', 'virtue'),
				'id'   => $prefix . 'project_val01_description',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 02 Title', 'virtue'),
				'desc' => __('ex. Skills Needed:', 'virtue'),
				'id'   => $prefix . 'project_val02_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 02 Description', 'virtue'),
				'desc' => __('ex. Photoshop, Illustrator', 'virtue'),
				'id'   => $prefix . 'project_val02_description',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 03 Title', 'virtue'),
				'desc' => __('ex. Customer:', 'virtue'),
				'id'   => $prefix . 'project_val03_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 03 Description', 'virtue'),
				'desc' => __('ex. Example Inc', 'virtue'),
				'id'   => $prefix . 'project_val03_description',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 04 Title', 'virtue'),
				'desc' => __('ex. Project Year:', 'virtue'),
				'id'   => $prefix . 'project_val04_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 04 Description', 'virtue'),
				'desc' => __('ex. 2013', 'virtue'),
				'id'   => $prefix . 'project_val04_description',
				'type' => 'text_medium',
			),
			array(
				'name' => __('External Website', 'virtue'),
				'desc' => __('ex. Website:', 'virtue'),
				'id'   => $prefix . 'project_val05_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Website Address', 'virtue'),
				'desc' => __('ex. http://www.example.com', 'virtue'),
				'id'   => $prefix . 'project_val05_description',
				'type' => 'text_medium',
			),
			array(
						'name' => __('If Video Project', 'virtue'),
						'desc' => __('Place Embed Code Here, works with youtube, vimeo...', 'virtue'),
						'id'   => $prefix . 'post_video',
						'type' => 'textarea_code',
					),
			array(
				'name' => __('Similar Portfolio Item Carousel', 'virtue'),
				'desc' => __('Display a carousel with similar portfolio items below project?', 'virtue'),
				'id'   => $prefix . 'portfolio_carousel_recent',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
					array( 'name' => __('Yes - Display Recent Projects', 'virtue'), 'value' => 'recent', ),
				),
			),
			array(
				'name' => __('Carousel Title', 'virtue'),
				'desc' => __('ex. Similar Projects', 'virtue'),
				'id'   => $prefix . 'portfolio_carousel_title',
				'type' => 'text_medium',
			),
				
		),
	);
			$meta_boxes[] = array(
				'id'         => 'portfolio_metabox',
				'title'      => __('Portfolio Page Options', 'virtue'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-portfolio.php' )),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __('Columns', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_columns',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Four Column', 'virtue'), 'value' => '4', ),
					array( 'name' => __('Three Column', 'virtue'), 'value' => '3', ),
					array( 'name' => __('Two Column', 'virtue'), 'value' => '2', ),
				),
			),
			array(
                'name' => __('Portfolio Work Types', 'virtue'),
                'desc' => '',
                'id' => $prefix .'portfolio_type',
                'type' => 'imag_select_taxonomy',
                'taxonomy' => 'portfolio-type',
            ),
            array(
				'name'    => __('Order Items By', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_order',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Menu Order', 'virtue'), 'value' => 'menu_order', ),
					array( 'name' => __('Title', 'virtue'), 'value' => 'title', ),
					array( 'name' => __('Date', 'virtue'), 'value' => 'date', ),
					array( 'name' => __('Random', 'virtue'), 'value' => 'rand', ),
				),
			),
			array(
				'name'    => __('Items per Page', 'virtue'),
				'desc'    => __('How many portfolio items per page', 'virtue'),
				'id'      => $prefix . 'portfolio_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'virtue'), 'value' => 'all', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name' => __('Set image height', 'virtue'),
				'desc' => __('Default is 1:1 ratio <b>(Note: just input number, example: 350)</b>', 'virtue'),
				'id'   => $prefix . 'portfolio_img_crop',
				'type' => 'text_small',
			),
			array(
				'name' => __('Display Item Work Types', 'virtue'),
				'desc' => '',
				'id'   => $prefix . 'portfolio_item_types',
				'type' => 'checkbox',
				'std'  => '1'
			),
			array(
				'name' => __('Display Item Excerpt', 'virtue'),
				'desc' => '',
				'id'   => $prefix . 'portfolio_item_excerpt',
				'type' => 'checkbox',
				'std'  => '1'
			),
			array(
				'name'    => __('Add Lightbox link in the top right of each item', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_lightbox',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'virtue'), 'value' => 'yes', ),
				),
			),
				
			));

			
			$meta_boxes[] = array(
				'id'         => 'pagefeature_metabox',
				'title'      => __('Feature Page Options', 'virtue'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-feature.php', 'page-feature-sidebar.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __('Feature Options', 'virtue'),
				'desc'    => __('If image slider make sure images uploaded are at least 1140px wide.', 'virtue'),
				'id'      => $prefix . 'page_head',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Image Slider', 'virtue'), 'value' => 'flex', ),
					array( 'name' => __('Video', 'virtue'), 'value' => 'video', ),
					array( 'name' => __('Image', 'virtue'), 'value' => 'image', ),
				),
			),
			array(
				'name' => __('Max Image/Slider Height', 'virtue'),
				'desc' => __('Default is: 400 <b>(Note: just input number, example: 350)</b>', 'virtue'),
				'id'   => $prefix . 'posthead_height',
				'type' => 'text_small',
			),
			array(
				'name' => __("Max Image/Slider Width", 'virtue' ),
				'desc' => __("Default is: 1140 <b>(Note: just input number, example: 650, does not apply to Carousel slider)</b>", 'virtue' ),
				'id'   => $prefix . 'posthead_width',
				'type' => 'text_small',
			),
			array(
				'name'    => __('Use Lightbox for Feature Image', 'virtue'),
				'desc'    => __("If feature option is set to image, choose to use lightbox link with image.", 'virtue' ),
				'id'      => $prefix . 'feature_img_lightbox',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'virtue'), 'value' => 'yes', ),
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
				),
			),
			array(
				'name' => __('If Video Post', 'virtue'),
				'desc' => __('Place Embed Code Here, works with youtube, vimeo...', 'virtue'),
				'id'   => $prefix . 'post_video',
				'type' => 'textarea_code',
			),
				
			));
	$meta_boxes[] = array(
				'id'         => 'bloglist_metabox',
				'title'      => __('Blog List Options', 'virtue'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-blog.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
                'name' => __('Blog Category', 'virtue'),
                'desc' => __('Select all blog posts or a specific category to show', 'virtue'),
                'id' => $prefix .'blog_cat',
                'type' => 'imag_select_category',
                'taxonomy' => 'category',
            ),
			array(
				'name'    => __('How Many Posts Per Page', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'blog_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'virtue'), 'value' => 'all', ),
					array( 'name' => '2', 'value' => '2', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name'    => __('Display Post Content as:', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'blog_summery',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Summary', 'virtue'), 'value' => 'summery', ),
					array( 'name' => __('Full', 'virtue'), 'value' => 'full', ),
				),
			),
			array(
				'name' => __('Display Sidebar?', 'virtue'),
				'desc' => __('Choose if layout is fullwidth or sidebar', 'virtue'),
				'id'   => $prefix . 'page_sidebar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'virtue'), 'value' => 'yes', ),
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
				),
			),
			array(
				'name'    => __('Choose Sidebar', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
				),
				
			));
			$meta_boxes[] = array(
				'id'         => 'contact_metabox',
				'title'      => __('Contact Page Options', 'virtue'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-contact.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
                'name' => __('Use Contact Form', 'virtue'),
                'desc' => '',
                'id' => $prefix .'contact_form',
                'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'virtue'), 'value' => 'yes', ),
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
				),
			),
			array(
				'name' => __('Contact Form Title', 'virtue'),
				'desc' => __('ex. Send us an Email', 'virtue'),
				'id'   => $prefix . 'contact_form_title',
				'type' => 'text',
			),
			array(
                'name' => __('Use Map', 'virtue'),
                'desc' => '',
                'id' => $prefix .'contact_map',
                'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'virtue'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'virtue'), 'value' => 'yes', ),
				),
			),
			array(
				'name' => __('Address', 'virtue'),
				'desc' => __('Enter your Location', 'virtue'),
				'id'   => $prefix . 'contact_address',
				'type' => 'text',
			),
			array(
				'name'    => __('Map Type', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'contact_maptype',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('ROADMAP', 'virtue'), 'value' => 'ROADMAP', ),
					array( 'name' => __('HYBRID', 'virtue'), 'value' => 'HYBRID', ),
					array( 'name' => __('TERRAIN', 'virtue'), 'value' => 'TERRAIN', ),
					array( 'name' => __('SATELLITE', 'virtue'), 'value' => 'SATELLITE', ),
				),
			),
			array(
				'name' => __('Map Zoom Level', 'virtue'),
				'desc' => __('A good place to start is 15', 'virtue'),
				'id'   => $prefix . 'contact_zoom',
				'std'  => '15',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('1 (World View)', 'virtue'), 'value' => '1', ),
					array( 'name' => '2', 'value' => '2', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
					array( 'name' => '17', 'value' => '17', ),
					array( 'name' => '18', 'value' => '18', ),
					array( 'name' => '19', 'value' => '19', ),
					array( 'name' => '20', 'value' => '20', ),
					array( 'name' => __('21 (Street View)', 'virtue'), 'value' => '21', ),
					),
			),
			array(
				'name' => __('Map Height', 'virtue'),
				'desc' => __('Default is 300', 'virtue'),
				'id'   => $prefix . 'contact_mapheight',
				'type' => 'text_small',
			),
				
			));
			$meta_boxes[] = array(
				'id'         => 'page_sidebar',
				'title'      => __('Sidebar Options', 'virtue'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array( 'key' => 'page-template', 'value' => array('page-sidebar.php','page-feature-sidebar.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __('Choose Sidebar', 'virtue'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
				),
				
			));
	
	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'initialize_showcase_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function initialize_showcase_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'cmb/init.php';

}