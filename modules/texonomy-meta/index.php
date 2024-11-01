<?php

/**
 * @ref : https://stackoverflow.com/questions/35864803/conflict-in-taxonomy-image-fields#question-header
 */

if ( ! class_exists( 'WeddingCity_Vendor_Category_Images_Meta' ) ) {

	class WeddingCity_Vendor_Category_Images_Meta {

	    /**
	     * Member Variable
	     *
	     * @var instance
	     */
	    private static $instance;

	    /**
	     *  Initiator
	     */
	    public static function get_instance() {
	    	
	      if ( ! isset( self::$instance ) ) {
	        self::$instance = new self;
	      }
	      return self::$instance;
	    }

	    public static function taxonomy_fields(){

			return 	array(

				sanitize_title( WeddingCity_Texonomy:: listing_location_taxonomy() ),

				sanitize_title( WeddingCity_Texonomy:: listing_category_taxonomy() ),
			);
	    }

		public function __construct() {

			if( WeddingCity_Loader:: array_condition( self:: taxonomy_fields() ) ){

				foreach( self:: taxonomy_fields() as $key => $value ){

					add_action( $value.'_add_form_fields', array ( $this, 'weddingcity_add_terms_field' ), 10, 2 );
					add_action( 'created_'.$value, array ( $this, 'weddingcity_create_terms_meta' ), 10, 2 );
					add_action( $value.'_edit_form_fields', array ( $this, 'weddingcity_preview_terms_meta' ), 10, 2 );
					add_action( 'edited_'.$value, array ( $this, 'weddingcity_save_terms_meta' ), 10, 2 );
				}
			}

			add_action( 'admin_enqueue_scripts', array( $this, 'weddingcity_vendor_texonomy_admin_script' ) );
		}

		public static function weddingcity_vendor_texonomy_admin_script(){

			global $my_admin_page;

			$current_screen = get_current_screen();

			if( WeddingCity_Loader:: array_condition( self:: taxonomy_fields() ) ){

				foreach ( self:: taxonomy_fields() as $key => $value) {
					
					if( $current_screen->id == esc_html( 'edit-'.$value ) ){

						/**
						 *  @media script : upload image through WP function.
						 */
						if( function_exists( 'wp_enqueue_media' ) ){

						    wp_enqueue_media();

						}else{
							
						    wp_enqueue_style('thickbox');
						    wp_enqueue_script('media-upload');
						    wp_enqueue_script('thickbox');
						}

					    wp_enqueue_script( 'weddingcity-texonomy-media', plugin_dir_url( __FILE__ ).'script.js', array(), WEDDINGCITY_PLUGIN_VERSION );

						wp_register_style( 'weddingcity-texonomy-media', plugin_dir_url( __FILE__ ).'style.css', false, WEDDINGCITY_PLUGIN_VERSION );

						wp_enqueue_style( 'weddingcity-texonomy-media' );
					}
				}
			}
		}

		public static function texonomy_media( $_label, $_id, $_img, $img_input, $_remove, $_desc, $_image_wrapper ){
		?>
			<div class="form-field term-group" id="<?php echo 'section_'.$_id; ?>">

				<label for="<?php echo $_id; ?>"><?php echo $_label; ?></label>

				<input type="hidden" id="<?php echo $_id; ?>" name="<?php echo $_id; ?>" class="custom_media_url" value="" />
				<div id="<?php echo $_image_wrapper; ?>" style="display: none;"><img src="" id="<?php echo $_img; ?>"></div>
				<p>
					<input type="button" class="button button-secondary <?php echo $img_input; ?>" id="<?php echo $img_input; ?>" name="<?php echo $img_input; ?>" value="<?php esc_html_e( 'Upload Image', 'weddingcity' ); ?>" />
					<input type="button" class="button button-secondary <?php echo $_remove; ?>" id="<?php echo $_remove; ?>" name="<?php echo $_remove; ?>" value="<?php esc_html_e( 'Remove Image', 'weddingcity' ); ?>" />
				</p>
				<p><?php echo $_desc; ?></p>

			</div>
		<?php
		}

		public static function texonomy_media_exists( $term_id, $_label, $_id, $_img, $img_input, $_remove, $_desc, $_upload_image_lable, $_remove_image_lable, $_image_wrapper ){

			$_image_file 	=	'';

			$image_id 		= 	get_term_meta ( $term_id, $_id, true );

			if ( $image_id ) {

				$_image_file =

				wp_get_attachment_image ( $image_id, 'medium', false, array(
						'id' => $_img
				) ); 

			}else{

				$_image_file = '<img id="'. $_img .'" src="" />';
			}
		?>

			<tr class="form-field term-group-wrap" id="<?php echo 'section_'.$_id; ?>">

		 		<th scope="row"><label for="<?php echo $_id; ?>"><?php echo $_label; ?></label></th>

			 	<td>
			   		<input type="hidden" id="<?php echo $_id; ?>" name="<?php echo $_id; ?>" value="<?php echo $image_id; ?>">
			   		<div id="<?php echo $_image_wrapper; ?>"><?php echo $_image_file; ?></div>

				   	<p>
				   		<input type="button" class="button button-secondary <?php echo $img_input; ?>" id="<?php echo $img_input; ?>" name="<?php echo $img_input; ?>" value="<?php echo $_upload_image_lable; ?>" />
				    	<input type="button" class="button button-secondary <?php echo $_remove; ?>" id="<?php echo $_remove; ?>" name="<?php echo $_remove; ?>" value="<?php echo $_remove_image_lable; ?>" />
				   	</p>

				   	<p><?php echo $_desc; ?></p>

			 	</td>

			</tr><?php
		}

		public static function texonomy_input( $_lable, $_id, $_desc ){
			?>

			<div class="form-field term-group" id="<?php echo 'section_'.$_id; ?>">

				<label for="<?php echo $_id; ?>"><?php echo $_lable; ?></label>
				<input type="text" id="<?php echo $_id; ?>" name="<?php echo $_id; ?>" class="<?php echo $_id; ?>" value="">
				<p><?php echo $_desc; ?></p>

			</div>

			<?php
		}

		public static function texonomy_input_exists( $_term_id, $_label, $_id ){

			?>
				<tr class="form-field term-group-wrap" id="<?php echo 'section_'.$_id; ?>">
					<th scope="row">
						<label for="term_icon"><?php echo $_label; ?></label>
					</th>
					<td>
						<?php $term_icon = get_term_meta ( $_term_id, $_id, true ); ?>
						<input type="text" id="<?php echo $_id; ?>" name="<?php echo $_id; ?>" value="<?php echo $term_icon; ?>">
					</td>
				</tr>
			<?php	
		}

		public static function texonomy_select_option( $_id, $_lable, $_options, $_desc ){

			?>
				<div class="form-field term-group" id="<?php echo 'section_'.$_id; ?>">
					<label for="<?php echo $_id; ?>"><?php echo $_lable; ?></label>
					<select id="<?php echo $_id; ?>" name="<?php echo $_id; ?>">
						<?php echo WeddingCity_Texonomy:: create_select_option( $_options, '', '0' ); ?>
					</select>
					<p><?php echo $_desc; ?></p>
				</div>
			<?php
		}

		public static function texonomy_select_opton_exists( $_term_id, $_id, $_lable, $_options, $_desc ){

			$_select = get_term_meta ( $_term_id, $_id, true );

			?>
				<tr class="form-field term-group-wrap" id="<?php echo 'section_'.$_id; ?>">
					<th scope="row">
						<label for="<?php echo $_id; ?>"><?php echo $_lable; ?></label>
					</th>
					<td>

						<select id="<?php echo $_id; ?>" name="<?php echo $_id; ?>">
							<?php echo WeddingCity_Texonomy:: create_select_option( $_options, '', $_select ); ?>
						</select>

					</td>
					<p><?php echo $_desc; ?>
				</tr>
			<?php
		}


		public static function weddingcity_add_terms_field ( $taxonomy ) {

				/**
				 *  1. Page Header Banner Image
				 */

				self:: texonomy_media(

					// 1 - label
					esc_html__('Page Header Banner Image', 'weddingcity'),

					// 2 - id
					esc_attr( 'header_banner_image_id' ),

					// 3 - image id
					esc_attr( 'header_banner_image_link' ),

					// 4 - image text input
					esc_html( 'header_banner_image_media' ),

					// 5 - remove label
					esc_attr( 'header_banner_image_remove' ),

					// 6 - description
					esc_html__( 'Best image size suit to your category page header ( 1900 x 290 ).', 'weddingcity' ),

					// 7 - image wrapper
					esc_attr( 'header_banner_image_section' )
				);


				/**
				 *  2. Category Image
				 */

				self:: texonomy_media(

					// 1 - label
					esc_html__('Category Image', 'weddingcity'),

					// 2 - id
					esc_attr( 'term_image_id' ),

					// 3 - image id
					esc_attr( 'term_image_link' ),

					// 4 - image text input
					esc_html( 'term_image_media' ),

					// 5 - remove label
					esc_attr( 'term_image_remove' ),

					// 6 - description
					esc_html__( 'Best image size suit to your category image ( 352 x 200 ).', 'weddingcity' ),

					// 7 - image wrapper
					esc_attr( 'term_image_wrapper' )
				);

				/**
				 *  5. Select Option
				 */
				self:: texonomy_select_option(

					// 1 - select option id
					esc_attr( 'weddingcity_texonomy_icon' ),

					// 2
					esc_html__( 'Select Icon Category', 'weddingcity' ),

					// 3
					array_merge(  array( '0' => 'Custom Icon ?' ), weddingcity_icons_set() ) ,

					// 4
					esc_html__( 'Select Your Category Icon', 'weddingcity' )
				);

				/**
				 *  4. Category Icon Input Type
				 */
				self:: texonomy_input( 

					// 1 - lable
					esc_html__( 'Category Icon', 'weddingcity' ),

					// 2 - id
					esc_attr( 'term_icon' ),

					// 3 - description
					esc_html__( 'Select category icon.', 'weddingcity' )
				);

				/**
				 *  5. Select Option
				 */
				self:: texonomy_select_option(

					// 1 - select option id
					esc_attr( 'marker_option' ),

					// 2
					esc_html__( 'Select Category Marker', 'weddingcity' ),

					// 3
					self:: drop_down_option(), 

					// 4
					esc_html__( 'Select Your Marker Choose to Display on Front Side', 'weddingcity' )
				);

				/**
				 *  3. Marker Image
				 */

				self:: texonomy_media(

					// 1 - label
					esc_html__('Upload Marker Image', 'weddingcity'),

					// 2 - id
					esc_attr( 'marker_image_id' ),

					// 3 - image id
					esc_attr( 'marker_image_link' ),

					// 4 - image text input
					esc_html( 'marker_image_media' ),

					// 5 - remove label
					esc_attr( 'marker_image_remove' ),

					// 6 - description
					esc_html__( 'Upload Category Marker Image ( 30 x 30 ).', 'weddingcity' ),

					// 7 - image wrapper
					esc_attr( 'marker_image_wrapper' )
				);
		}

		public static function drop_down_option(){

			return  array_merge(

				array( '0' => 'Custom Upload Marker ?' ),

				self:: _get_category_svg()
			);
		}

		public static function _get_category_svg(){

			$_get_category_svg = array();

		   	foreach ( glob( WEDDINGCITY_PLUGIN_DIR . '/assets/images/vendor-category/*.svg' ) as $file ) {

			    $_get_category_svg[ esc_html( sanitize_title( basename( $file, '.svg' ) . PHP_EOL ) ) ] =  esc_html( sanitize_title( basename( $file, '.svg' ) . PHP_EOL ) );
		   	}

		   return $_get_category_svg;
		}

		public static function weddingcity_preview_terms_meta ( $term, $taxonomy ) {

			/**
			 *  1. Page Header Banner Image
			 */
			self::  texonomy_media_exists(

				// 1 - Get Terms Id
				$term->term_id,

				// 2 - lable
				esc_html__( 'Page Header Banner Image', 'weddingcity' ),

				// 3 - $_id 
				esc_attr( 'header_banner_image_id' ),
				
				// 4 - $_img
				esc_attr( 'header_banner_image_link' ),

				// 5 - $img_input
				esc_attr( 'header_banner_image_media' ),

				// 6 - $_remove
				esc_attr( 'header_banner_image_remove' ),
				
				// 7 - $_desc 
				esc_html__( 'Best image size suit to your category page header ( 1900 x 290 ).', 'weddingcity' ),

				// 8 - Upload Image - Lable
				esc_html__( 'Upload Header Banner Image', 'weddingcity' ),

				// 9 - Removed Image Lable
				esc_html__( 'Remove Header Banner Image', 'weddingcity' ),

				// 10 - image wrapper
				esc_attr( 'header_banner_image_section' )
			);

			/**
			 *  2. Category Image
			 */
			self::  texonomy_media_exists(

				// 1 - Get Terms Id
				$term->term_id,

				// 2 - lable
				esc_html__( 'Category Image', 'weddingcity' ),

				// 3 - $_id 
				esc_attr( 'term_image_id' ),
				
				// 4 - $_img
				esc_attr( 'term_image_link' ),

				// 5 - $img_input
				esc_attr( 'term_image_media' ),

				// 6 - $_remove
				esc_attr( 'term_image_remove' ),
				
				// 7 - $_desc 
				esc_html__( 'Best image size suit to your category image ( 352 x 200 ).', 'weddingcity' ),

				// 8 - Upload Image - Lable
				esc_html__( 'Add Category Image', 'weddingcity' ),

				// 9 - Removed Image Lable
				esc_html__( 'Remove Category Image', 'weddingcity' ),

				// 10 - image wrapper
				esc_attr( 'term_image_wrapper' )
			);

			/**
			 *   Category Icons ( Select Option )
			 */
			self:: texonomy_select_opton_exists(

				$term->term_id,

				// 1 - select option id
				esc_attr( 'weddingcity_texonomy_icon' ),

				// 2
				esc_html__( 'Select Icon Category', 'weddingcity' ),

				// 3
				array_merge(  array( '0' => 'Custom Icon ?' ), weddingcity_icons_set() ) ,

				// 4
				esc_html__( 'Select Your Category Icon', 'weddingcity' )
			);

			/**
			 *  Category Icon ( Text Fields )
			 */
			self:: texonomy_input_exists(

				// 1 - Terms id
				$term->term_id,

				// 2 - lable
				esc_html__( 'Category Icon', 'weddingcity' ),

				// 3 -
				esc_attr( 'term_icon' )
			);

			/**
			 *  4. Select Marker
			 */
			self:: texonomy_select_opton_exists(

				// 1 - Terms id
				$term->term_id,
				
				// 2 - select option id
				esc_attr( 'marker_option' ),

				// 3
				esc_html__( 'Select Category Marker', 'weddingcity' ),

				// 4
				self:: drop_down_option(),

				// 5
				esc_html__( 'Select Your Marker Choose to Display on Front Side', 'weddingcity' )
			);

			/**
			 *  5. Marker Image
			 */
			self::  texonomy_media_exists(

				// 1 - Get Terms Id
				$term->term_id,

				// 2 - lable
				esc_html__( 'Category Marker Image', 'weddingcity' ),

				// 3 - $_id 
				esc_attr( 'marker_image_id' ),
				
				// 4 - $_img
				esc_attr( 'marker_image_link' ),

				// 5 - $img_input
				esc_attr( 'marker_image_media' ),

				// 6 - $_remove
				esc_attr( 'marker_image_remove' ),
				
				// 7 - $_desc 
				esc_html__( 'Category marker image ( 30 x 30 ).', 'weddingcity' ),

				// 8 - Upload Image - Lable
				esc_html__( 'Add Category Marker Image', 'weddingcity' ),

				// 9 - Removed Image Lable
				esc_html__( 'Remove Category Marker Image', 'weddingcity' ),

				// 10 - image wrapper
				esc_attr( 'marker_image_wrapper' )
			);
		}

		public static function weddingcity_texonomy_ids(){

			return 	array(

					'header_banner_image_id',
					'term_image_id',
					'marker_image_id',
					'term_icon',
					'marker_option',
					'weddingcity_texonomy_icon'
			);
		}

		public static function weddingcity_create_terms_meta ( $term_id, $tt_id ) {

			foreach( self:: weddingcity_texonomy_ids() as $key => $value ){

				if( isset( $_POST[ $value ] ) && '' !== $_POST[ $value ] ){
					 $image = $_POST[ $value ];
					 add_term_meta( $term_id,  $value, $image, true );
				}
			}
		}

		public static function weddingcity_save_terms_meta ( $term_id, $tt_id ) {

			foreach( self:: weddingcity_texonomy_ids() as $key => $value ){

				if( isset( $_POST[ $value ] ) && '' !== $_POST[ $value ] ){

					 $image = $_POST[ $value ];

					 update_term_meta ( $term_id,  $value , $image );

				} else {

				 	update_term_meta ( $term_id,  $value , '' );
				}
			}
		}
		
	} // class end

	/**
	*  Kicking this off by calling 'get_instance()' method
	*/
	WeddingCity_Vendor_Category_Images_Meta::get_instance();
}