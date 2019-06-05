<?php 

class PostRate{

    function __construct(){
        add_action( 'comment_form_top', array($this,'add_field_to_form'));
        add_action( 'wp_enqueue_scripts', array($this,'add_css_and_js'));
        add_action( 'comment_post', array( $this,'save_comment_meta_data' ) );
        add_filter('comment_text',  array( $this, 'add_title_to_text'),99,2);
        add_shortcode( 'wppr_avg_rating', array( $this, 'show_post_rate' ));

    }


    public function add_field_to_form(){
        $st_label    = __('How Useful for this post  ','wp-post-rate');
        $star1_title = __('Very bad', 'wp-post-rate');
        $star2_title = __('Bad', 'wp-post-rate');
        $star3_title = __('Meh', 'wp-post-rate');
        $star4_title = __('Pretty good', 'wp-post-rate');
        $star5_title = __('Rocks!', 'wp-post-rate');
        
             if(!isset($_GET['replytocom'])){	
        echo '<fieldset class="rating">
        <legend>'.$st_label.'<span class="required"> * </span></legend>
        <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="'.$star5_title.'">5 stars</label>
        <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="'.$star4_title.'">4 stars</label>
        <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="'.$star3_title.'">3 stars</label>
        <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="'.$star2_title.'">2 stars</label>
        <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="'.$star1_title.'">1 star</label>
        </fieldset>';
            }
        
    }

    //////// save comment meta data ////////


    function save_comment_meta_data( $comment_id ) {
        $rating =  (empty($_POST['rating'])) ? FALSE : $_POST['rating'];
        add_comment_meta( $comment_id, 'rating', $rating );
    }

    public function add_css_and_js(){
        wp_enqueue_script('Post_rate_js',get_stylesheet_directory_uri().'/post-rating/js/custom.js',array('jquery'),null,true);
        wp_enqueue_style('Post_rate_css',get_stylesheet_directory_uri().'/post-rating/css/style.css',array(),null,null);
    }

    ///// show rating stars with visitors comment /////

    public function add_title_to_text($text,$comment){    
    

            if($title=get_comment_meta($comment->comment_ID,'rating',true))
            {            
                    $title='<span class="wpcr_author_stars" data-rating="'.$title.'" ></span>';
                    $text=$title.$text;      
                
            }
            return $text;
    }

    public function show_post_rate(){
        global $post;

        $args = array('post_id' => $post->ID);
	
        $comments = get_comments($args);
        //var_dump($comments);
        
        $sum = 0;
        $count=0;
        
        foreach($comments as $comment) :
        
            $approvedComment = $comment->comment_approved; 
            
            if($approvedComment > 0){  
            $rates = get_comment_meta( $comment->comment_ID, 'rating', true );
            }
            if($rates){
                $sum = $sum + (int)$rates;
                $count++;
            }
        
        endforeach;
		if($count != 0){ 
			$result=   $sum/$count;
		}else {
			$result= 0;
		}
        $avgText = __('average', 'wp-post-rate');
        $outOf   = __('out of 5. Total', 'wp-post-rate');

        if($count > 0){ 
            $output = '<div class="wpcr_aggregate"><a class="wpcr_tooltip" title="'.$avgText.': '.round($result,2).' '.$outOf.': '.$count.'"><span class="wpcr_stars" title="">'.$avg_text.':</span>';
            $output .= '<span class="wpcr_averageStars" id="'.$result.'"></span></a></div>';
        
            return $output;
        }else{
            return '';
        }
    }

}

new PostRate;