<?php

/**
 * 
 * @link https://github.com/bradvin/social-share-urls
 * 
 * @param [type] $social_media [description]
 * 
 */

if( ! function_exists( 'weddingcity_share_post' ) ){

	/**
	 * [weddingcity_share_post description]
	 * @param [type] $social_media [description]
	 */
	
    function weddingcity_share_post( $social_media ){

        global $post, $wp_query;

        if( $social_media != '' ){

            $output = '';

            foreach( $social_media as $value => $key ){

                if( $key == 'Digg' ){

                    $output .= 

                    sprintf('<a class="icon-square-outline facebook-outline" href="%1$s" target="_blank"><i class="fab fa-digg" aria-hidden="true"></i></a>',
                        
                          // 1
                          esc_url( "http://www.digg.com/submit?url=" . get_the_permalink() )
                    );                  

                }elseif( $key == 'Facebook' ){

                    $output .= 

                    sprintf('<a class="icon-square-outline facebook-outline" href="%1$s" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>',

                        // 1
                        esc_url( "http://www.facebook.com/sharer.php?u=" . get_the_permalink() )
                    );

                }elseif( $key == 'Google' ){

                    $output .= 

                    sprintf('<a class="icon-square-outline googleplus-outline" href="%1$s" target="_blank"><i class="fab fa-google-plus-g" aria-hidden="true"></i></a>',
                        
                        // 1
                        esc_url("https://plus.google.com/share?url=" . get_the_permalink() )
                    );

                }elseif( $key == 'LinkedIn' ){

                    $output .= 

                    sprintf('<a class="icon-square-outline linkedin-outline" href="%1$s" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>',
                        
                        // 1
                        esc_url("http://www.linkedin.com/shareArticle?mini=true&amp;url=" . get_the_permalink() )
                    );

                }elseif( $key == 'Pinterest' ){

                    $output .= 

                    sprintf('<a class="icon-square-outline pinterest-outline" href="%1$s" target="_blank"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>',
                        
                        // 1
                        esc_url( 'http://pinterest.com/pin/create/button/?url='.get_the_permalink().'&description='.get_the_title() )
                    );


                }elseif( $key == 'Reddit' ){

                    $output .= 

                    sprintf('<a class="icon-square-outline facebook-outline" href="%1$s" target="_blank"><i class="fab fa-reddit" aria-hidden="true"></i></a>',  
                        
                        // 1
                        esc_url("http://reddit.com/submit?url=" .  get_the_permalink() . "&amp;title=" . get_the_title() )
                    );

                }elseif( $key == 'StumbleUpon' ){

                    $output .= 

                    sprintf('<a class="icon-square-outline facebook-outline" href="%1$s" target="_blank"><i class="fab fa-stumbleupon-circle" aria-hidden="true"></i></a>',
                        
                        // 1
                        esc_url("http://www.stumbleupon.com/submit?url=" . get_the_permalink() . "&amp;title=" . get_the_title() )
                    );

                }elseif( $key == 'Tumblr' ){

                    $output .= sprintf('<a class="icon-square-outline facebook-outline" href="%1$s" target="_blank"><i class="fab fa-tumblr" aria-hidden="true"></i></a>',
                        
                        // 1
                        esc_url("http://www.tumblr.com/share/link?url=" . get_the_permalink() . "&amp;title=" . get_the_title() )
                    );

                }elseif( $key == 'Twitter' ){

                    $output .= sprintf('<a class="icon-square-outline twitter-outline" href="%1$s" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a>',
                        
                        // 1
                        esc_url("https://twitter.com/share?url=" . get_the_permalink() . "&amp;text=" . get_the_title() . "&amp;hashtags=" . get_bloginfo('name') )
                    );

                }elseif( $key == 'VK' ){

                    $output .= sprintf('<a class="icon-square-outline facebook-outline" href="%1$s" target="_blank"><i class="fab fa-vk" aria-hidden="true"></i></a>', 
                            
                        // 1
                        esc_url("http://vkontakte.ru/share.php?url=" . get_the_permalink() )
                    );                  
                }

            }
        }

        if( empty( $output ) ) return;  

        return  $output;
    }
}