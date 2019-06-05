<?php
class Theme_Helper {

	/**
	 * Default theme options
	 * @var array
	 */
    protected static $defaults = array();

    /**
	 * @var Habakiri_Customizer_Framework
	 */
	
    protected $Customizer_Framework;

    protected static $home_blocks = null;

    function __construct(){

        // $this->wp_customize = $wp_customize;
        $this->Customizer_Framework = new Habakiri_Customizer_Framework();
        // add_action('customize_register', array( $this, 'set_customize_register') );
    }

	/**
	 * Return default value
	 *
	 * @param string $key
	 * @return null|string 
	 */
    public static function get_default( $key ){

        $defaults_Ary = array(
            'options_phone'               =>  ' Call us: 1234 5678 90 ',
            'options_phone_number'        =>  ' 1234 5678 90 ',
            'options_email'               =>  ' Contact us: your@email.com ',
            'options_receiver_email'      =>  ' your@email.com ',
            'options_address'             =>  ' 21,Yangon ',
            'options_map'                 =>  ' <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.377239357319!2d96.13038866404035!3d16.807631414343525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1eb380d04ccff%3A0x9a4f4f9119daa179!2zMTbCsDQ4JzI4LjUiTiA5NsKwMDcnNTEuNSJF!5e0!3m2!1sja!2sjp!4v1541737607907" 
                                                width="400" height="300" frameborder="0" style="border:0" allowfullscreen=""></iframe> ',
        
            );
        
        for( $i = 1; $i <= self::$home_blocks; $i++ ) {

            $home_block_id = "home_block_$i";
            $defaults_Ary[$home_block_id] = false;
        }

        self::$defaults = apply_filters(
                'child_theme_mod_defaults',
                $defaults_Ary,
            );

        if( isset( self::$defaults[$key] ) ) {

            return self::$defaults[$key];
        }

    }


    /**
	 * Set the original item on the theme customizer
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */


    public function customize_register( $wp_customize ){

        $this->Customizer_Framework->register_customizer( $wp_customize );

        //Start Parent Theme Slider Modify 
            for ( $i = 1; $i <= 5; $i ++ ) {
                $section_id = 'habakiri_slider_image_' . $i;

                $this->Customizer_Framework->text( 'slider_title' . $i, array(
                    'label'         => __( " Heading ", 'habakiri' ),
                    'default'       => __( "Welcome To </b> Japan </b>",'habakiri' ),
                    'section'       => $section_id
                ) );

                for ( $b = 1; $b <= 2; $b++){
                    $default = $b == 1 ? "Book Now" : " Take a Tour ";
                    $this->Customizer_Framework->text( "slider_btn_text_${b}_" . $i, array(
                        'label'         => __( " Button Text $b", 'habakiri' ),
                        'default'       => __( " $default ", 'habakiri'  ),
                        'section'       => $section_id,
                        'priority'      =>11,
                    ) );
                }

                $this->Customizer_Framework->url( 'slider_url_two' . $i, array( 
                    'label'         => __( " URL  ", 'habakiri' ),
                    'default'       => __( " # ", 'habakiri' ),
                    'section'       => $section_id,
                    'priority'      => 12,
                ) );
                
            
            }
        //End Parent Theme Slider Modify

        //Start Theme Options
            $panel_id = "child_theme_options"; 
            $this->Customizer_Framework->add_panel( $panel_id, array(
                'title'         => __( " Theme Options ", ' habakiri ' ),
                'priority'      =>110,
            ) );
            
            // Contact & Social in Theme Options 
            $info_social_section_id = "options_info_social";
            $this->Customizer_Framework->add_section( $info_social_section_id, array(
                'title'         => __( " Contact & Social ", 'habakiri' ),
                'panel'         => $panel_id,
            ) );

            // options_phone
            // options_phone_number
            // options_email
            // options_receiver_email
            // options_address
            // options_facebook
            // options_instagram
            // options_twitter
            // options_google_plus
            // options_youtube
            // options_pinterest
            // options_tripadvisor
            
            
            $this->Customizer_Framework->text( 'options_phone', array(
                'label'         => __( " Phone ",'habakiri' ),
                'default'        => self::get_default('options_phone'),
                'section'       => $info_social_section_id,
                // 'settings'      =>'options_phone',
            ) );

            $this->Customizer_Framework->text( 'options_phone_number', array(
                'label'         => __( " Phone Number ",'habakiri' ),
                'default'        => self::get_default('options_phone_number'),
                'section'       => $info_social_section_id,
            ) );

            
            $this->Customizer_Framework->text( 'options_email', array(
                'label'         => __( " Email ",'habakiri' ),
                'default'        => self::get_default('options_email'),
                'section'       => $info_social_section_id,
                ) );
                
            $this->Customizer_Framework->text( 'options_receiver_email', array(
                'label'         => __( " Receiver Email ",'habakiri' ),
                'default'        => self::get_default('options_receiver_email'),
                'section'       => $info_social_section_id,
            ) );
                
            $this->Customizer_Framework->textarea( 'options_address', array(
                'label'         => __( " Address ",'habakiri' ),
                'default'        => self::get_default('options_address'),
                'section'       => $info_social_section_id,
            ) );
                
            $this->Customizer_Framework->textarea( 'options_map', array(
                'label'         => __( " Google Map ",'habakiri' ),
                'default'        => self::get_default('options_map'),
                'section'       => $info_social_section_id,
            ) );

            $social = array(
                'options_facebook',
                'options_twitter',
                'options_linkedin',
                'options_google_plus',
                'options_instagram',
                'options_youtube',
                'options_pinterest',
                'options_tripadvisor',
            );

            foreach ( $social as $key=>$control_id ){

                $label = ucfirst( str_replace( "options_", "",$control_id ) );

                $this->Customizer_Framework->text( $control_id, array(
                    'label'     => __( $label, ' habakiri ' ),
                    'default'   => "#",
                    'section'   => $info_social_section_id
                ) );
            }
        //End Theme Options

        //Start Home Block Control in Theme Options
            $blockForm = array( 
                array(),
                array('main_title'=>'text','main_description'=>'textarea','item_title'=>'text','item_description'=>'textarea','item_loop'=>3,'loop_items'=>array('item_title,item_description') ),
                array('main_title'=>'text','post_type'=>'select','post_categories'=>'select','post_order'=>'select','post_orderby'=>'select','post_limit'=> 'number'),
                array('main_title'=>'text','post_type'=>'select','post_categories'=>'select','post_order'=>'select','post_orderby'=>'select','post_limit'=> 'number'),
                array('main_title'=>'text','post_type'=>'select','post_categories'=>'select','post_order'=>'select','post_orderby'=>'select','post_limit'=> 'number'),
                array('main_title'=>'text','main_description'=>'textarea','post_type'=>'select','post_categories'=>'select','post_order'=>'select','post_orderby'=>'select','post_limit'=> 'number'),
                array('main_title'=>'text','main_description'=>'textarea','comment_limit'=>'number','comment_img'=>'image',
                    'post_type'=>'select','post_categories'=>'select','post_order'=>'select','post_orderby'=>'select','post_limit'=> 'number'),
                array('main_title'=>'text','main_description'=>'textarea','item_title'=>'text','item_description'=>'textarea','item_loop'=>6, 'loop_items'=>  array('item_title,item_description') ) ,
                array('main_title'=>'text','main_description'=>'textarea','partner'=>'image','item_loop'=>6,'loop_items'=>array('partner')),
                // array('main_title'=>'text','main_description'=>'textarea','partner'=>'image'),
                // array('main_title'=>'text','main_description'=>'textarea','partner'=>'image'),
            );

            $blocks = self::get_home_blocks();

            for ( $i = 1; $i <= $blocks; $i++ ) {

                $section_id = "home_block_control_$i";
                $home_block_id = "home_block_$i";

                $main_title = get_theme_mod ( $home_block_id."_main_title" );
                $section_label = $main_title ? $main_title : " Manage Home Block $i ";

                $this->Customizer_Framework->add_section( $section_id, array(
                    'title'         => __( $section_label, 'habakiri' ),
                    'panel'         => $panel_id
                ) );

                
                $this->Customizer_Framework->checkbox( $home_block_id, array(
                    'label'     => __( " Hide  Home Block $i ", 'habakiri' ),
                    'section'   => $section_id
                ) );

                
                    // foreach ( $blockForm[$i] as $block_id=>$type ){

                    //     $field_id = $home_block_id."_".$block_id;
                    //     $label = ucfirst( str_replace( "_", " ", $block_id ) );
                    //     $field_Ary = array( 
                    //         'label'=> __( $label, "habakiri" ), 
                    //         // 'default'=>count($blockForm[$i]),
                    //         "section" =>$section_id,
                    //     ); 

                    //     if( $block_id === 'item_loop' ){

                    //         for ( $b = 1; $b <= $type; $b++ ){

                    //             $loop_items = $blockForm[$i]['loop_items'];

                    //             for ( $l = 0; $l < count( $loop_items ); $l++ ){

                    //                 $type2 = $blockForm[$i].$loop_items[$l];

                    //                 $field_id = $home_block_id.$loop_items[$l]."_${l}";
                    //                 $this->check_type( $type2, $field_id, $field_Ary );
                    //             }
                    //         }

                    //     } else {
                            $this->check_type( $type, $field_id, $field_Ary );
                    //     }



                        
                    // }
                
            }
        //End Home Block Control Options


    }

    public function check_type( $type, $field_id, $field_Ary){
        if( $type === 'text' ){
            $this->Customizer_Framework->text( $field_id, $field_Ary );
        }

        if ( $type === 'textarea' ){
            $this->Customizer_Framework->textarea($field_id, $field_Ary);
        }

        if ( $type === 'number' ){
            $field_Ary['default'] = -1;
            self::$defaults[$field_id] = -1;
            $this->Customizer_Framework->number( $field_id, $field_Ary );
        }

        if ( $type === 'select' ){
            
            $post_types = self::get_post_types() ;
            $post_categories = self::get_post_categories() ;
            $post_order = self::get_post_order() ;
            $post_orderBy = self::get_post_orderBy() ;

            $field_Ary['choices'] = array(
                'dd' => __("Hello","habakiri"),
                'tt' => __("TT","habakiri"),
                'aa' => __("AA","habakiri"),
            );

            if( $block_id === 'post_type' ){
                $field_Ary['choices'] = $post_types;
            }
            if( $block_id === 'post_categories' ){
                $field_Ary['choices'] = $post_categories;
            }
            if( $block_id === 'post_order' ){
                $field_Ary['choices'] = $post_order;
            }
            if( $block_id === 'post_orderby' ){
                $field_Ary['choices'] = $post_orderBy;
            }


            $first_key = array_key_first( $field_Ary['choices'] );
            $field_Ary['default']= $field_Ary['choices'][$first_key];




            $this->Customizer_Framework->select( $field_id, $field_Ary );
        }

        if( $type == "image" ){
            $this->Customizer_Framework->image( $field_id, $field_Ary );
        }
    }
    public function button( $control_id, $args ){

        $args = $this->Customizer_Framework->init_field_args( $control_id, $args );
		$args = $this->Customizer_Framework->set_default_sanitize_callback( $args, 'sanitize_text_field' );
        $this->Customizer_Framework->add_setting( $control_id, $args );
        $this->Customizer_Framework->add_control(
			new WP_Customize_Control(
				$this->Customizer_Framework,
				$control_id,
				array_merge( $args, array(
					'settings' => $control_id,
					'type'     => 'button',
				) )
			)
		);
    }
    public function custom_post_type(){
        /** 
        * Get custom post name , slug ,tax 
        * @param Tour_name $name
        * @return array count 3
        */
        $post_name = self::get_custom_post_with_tax( 'Tours' );

         // Set UI labels for Custom Post Type
         $name  = $post_name['post_name'];
         $slug  = $post_name['post_slug'];
         $tax   = $post_name['tax_name'];

         $labels = array(
            'name'                => _x( $name, 'Post Type General Name', 'habakiri' ),
            'singular_name'       => _x( $slug, 'Post Type Singular Name', 'habakiri' ),
            'menu_name'           => __( $name, 'habakiri' ),
            'parent_item_colon'   => __( "Parent $name ", 'habakiri' ),
            'all_items'           => __( "All $name", 'habakiri' ),
            'view_item'           => __( "View $name", 'habakiri' ),
            'add_new_item'        => __( "Add New $name", 'habakiri' ),
            'add_new'             => __( 'Add New', 'habakiri' ),
            'edit_item'           => __( "Edit $name", 'habakiri' ),
            'update_item'         => __( "Update $name", 'habakiri' ),
            'search_items'        => __( "Search $name", 'habakiri' ),
            'not_found'           => __( 'Not Found', 'habakiri' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'habakiri' ),
        );
 
        // Set other options for Custom Post Type
         
        $args = array(
            'label'               => __( $name, 'habakiri' ),
            'description'         => __( " $name news and reviews", 'habakiri' ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            // You can associate this CPT with a taxonomy or custom taxonomy. 
            'taxonomies'          => array( $slug ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */ 
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );

        // Registering your Custom Post Type
        register_post_type( $name, $args );

        $tax_labels = array(
            'name' => _x( $name." Categories ", 'taxonomy general name' ),
            'singular_name' => _x( $tax, 'taxonomy singular name' ),
            'search_items' =>  __( 'Search '.$name.' Categories' ),
            'all_items' => __( 'All '.$name.' Categories' ),
            'parent_item' => __( 'Parent '.$name.' Categories' ),
            'parent_item_colon' => __( 'Parent '.$name.' Categories:' ),
            'edit_item' => __( 'Edit '.$name.' Categories' ), 
            'update_item' => __( 'Update '.$name.' Categories' ),
            'add_new_item' => __( 'Add New '.$name.' Categories' ),
            'new_item_name' => __( 'New '.$name.' Categories Name' ),
            'menu_name' => __( $name.' Categories' ),
          );    
         
        // Now register the taxonomy
         
          register_taxonomy($tax,array( $slug ), array(
            'hierarchical' => true,
            'labels' => $tax_labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => $tax ),
          ));
    }

    public static function get_home_blocks(){

        self::$home_blocks = apply_filters('home_blocks', 8 );

        if ( self::$home_blocks > 0 ){

            return self::$home_blocks;
        }
    }

    public static function get_post_types(){

        $args = array(
            'hierarchical'=>false,
            'menu_position'=>true
        );
        
        $post_types = get_post_types( $args, 'names' );

        return $post_types;
    }

    public static function get_post_order() {
        $post_order = array(
            'DESC'      => "DESC",
            'ASC'      => "ASC",
        );

        return $post_order;
    }

    public static function get_post_orderBy(){
        $post_orderBy = array( 
            'ID'        =>'ID',
            'author'    =>'author',
            'title'     =>'title',
            'name'      =>'name',
            'type'      =>'type',
            'date'      =>'date',
            'modified'      =>'modified',
            'comment_count'      =>'comment_count',
         );

         return $post_orderBy;
    }

    public static function get_post_categories() {

  
        $taxonomies = get_taxonomies(array('public'   => true,'hierarchical'=>true));
   
        $categories_list = array();
            foreach( $taxonomies as $tax ){
                    $terms = get_terms(array( 'taxonomy'=> $tax, 'hide_empty' => 0, ));
                    
                    
                    foreach ( $terms as $term ){
                        $categories_list[$term->slug] = $term->name;
                    }
            }
        return $categories_list;
    }

    public static function get_custom_post_with_tax ( $name ) {
        if ( !$name )
            return false;

        $with_tax = apply_filters('custom_post_tax', 
        array(
            'post_name'     => ucfirst( $name ),
            'post_slug'     => strtolower( str_replace( ' ', '-', $name ) ),
            'tax_name'      =>strtolower( str_replace( ' ', '_', $name ) ).'_cat',
        ) );

        return $with_tax;
    }

    public static function get_tax_query( $post_type, $cat ){
        if( !$post_type && !$cat )
            return null;

        $taxonomies         = get_taxonomies( array('public'   => true,'hierarchical'=>true) );

        $taxonomy_objects   = get_object_taxonomies( $post_type, 'names' );
        $tax_field          = is_numeric($cat) ? "ID": "slug";
        $tax_query;
        foreach( $taxonomies as $tax ){
            if( in_array( $tax, $taxonomy_objects ) ){
                
               $tax_query   = array(
                        'taxonomy'  => $tax,
                        'field'     => $tax_field,
                        'terms'     => $cat
                       //  'operator'=>'IN'
               );
                
            }
        }

        return $tax_query;
    }
    
    public function get_post_array( $block_id ){
        $block_id   = $block_id;

        if( !$block_id )
            return false;

        $post_type          = Habakiri::get( "${block_id}_post_type" );
        $posts_per_page     = Habakiri::get( "${block_id}_post_limit" );
        $post_categories    = Habakiri::get( "${block_id}_post_categories" );
        $post_order         = Habakiri::get( "${block_id}_post_order" );
        $post_orderby       = Habakiri::get( "${block_id}_post_orderby" );

        $args   = array(
            'post_type'     => $post_type,
            'posts_per_page'=> $posts_per_page,
            'order'         => $post_order,
            'orderby'       => $post_orderby,
            // 'tax_query'     => array(),
        );
        $tax_query          =  self::get_tax_query( $post_type, $post_categories );
        if( $tax_query )
            $args['tax_query'][] = $tax_query;
        print_r( $args );
        
        return $args;
    }

    public function customizer_js(){
        wp_enqueue_script('child_customizer_js',get_stylesheet_directory_uri().'/child-helper/js/customizer.js');
    }
}

// function Child_Customizer_Class(){	

//     if ( class_exists( "Habakiri_Customizer_Framework" ) ){

//         $child_customizer = new Theme_Helper;
    
//         add_action( 'customize_register', array( $child_customizer, 'customize_register') );
//         add_action( 'init', array( $child_customizer, 'custom_post_type') );
//         add_action( 'customize_controls_print_footer_scripts', array( $child_customizer, 'customizer_js') );
//     }

// }
// add_action("after_setup_theme","Child_Customizer_Class");

 