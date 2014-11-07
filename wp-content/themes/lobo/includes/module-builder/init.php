<?php

// Adding actions

add_action( 'load-post.php', 'kmb_meta_setup' );

function kmb_meta_setup() {
	add_action( 'add_meta_boxes', 'kmb_meta_add' );
	add_action( 'save_post', 'kmb_meta_save', 10, 2 );
}

// Function which adds the builder meta box on proper pages

function kmb_meta_add() {

	$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 'no');
	$template_file = $post_id != 'no' ? get_post_meta($post_id,'_wp_page_template',TRUE) : 'no';

	if ( $template_file == 'template-modular.php' ) {

		add_meta_box(
			'kmb',
			esc_html__( 'Module Builder', 'lobo' ),
			'kmb_meta_box_html',
			'page',
			'normal',
			'high'
		);

	} else {

		add_meta_box(
			'kmb',
			esc_html__( 'Module Builder', 'lobo' ),
			'kmb_meta_box_html',
			'portfolio',
			'normal',
			'high'
		);

	}

}

// Function that loads all required scripts & styles for the admin

function kmb_admin_assets() {

	global $post;

	$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 'no');
	$template_file = $post_id != 'no' ? get_post_meta($post_id,'_wp_page_template',TRUE) : 'no';

	if ( $template_file == 'template-modular.php' || ( isset( $post ) && $post->post_type == 'portfolio' ) ) {

		wp_enqueue_media();

		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/includes/module-builder/js/bootstrap.min.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-draggable' ) );
		wp_enqueue_script( 'bootstrap-colorpicker', get_template_directory_uri() . '/includes/module-builder/js/bootstrap-colorpicker.min.js', array( 'bootstrap') );
		wp_enqueue_script( 'image-uploader', get_template_directory_uri() . '/includes/module-builder/js/image-uploader.js', array( 'bootstrap') );
		wp_enqueue_script( 'gallery-creator', get_template_directory_uri() . '/includes/module-builder/js/gallery.js', array( 'bootstrap') );
		wp_enqueue_script( 'packery', get_template_directory_uri() . '/includes/module-builder/js/packery.pkgd.min.js', array( 'bootstrap' ) );
		wp_enqueue_script( 'json2', get_template_directory_uri() . '/includes/module-builder/js/json2.js', array( 'bootstrap' ) );
		wp_enqueue_script( 'kmb-config', get_template_directory_uri() . '/includes/module-builder/js/config.js', array( 'bootstrap' ) );
		wp_enqueue_script( 'kmb', get_template_directory_uri() . '/includes/module-builder/js/builder.js', array( 'kmb-config' ) );

		wp_localize_script( 'kmb', 'bkdOptions', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/includes/module-builder/css/bootstrap.min.css' );
		wp_enqueue_style( 'bootstrap-colorpicker', get_template_directory_uri() . '/includes/module-builder/css/bootstrap-colorpicker.min.css' );
		wp_enqueue_style( 'kmb', get_template_directory_uri() . '/includes/module-builder/css/builder.css' );

	}

}

add_action( 'admin_enqueue_scripts', 'kmb_admin_assets', 99 );

// Function that handles the saving of the data

function kmb_meta_save( $post_id, $post ) {

	if ( ! isset( $_POST['kmb_nonce'] ) || ! wp_verify_nonce( $_POST['kmb_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}

	$post_type = get_post_type_object( $post->post_type );

	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	$new_meta_value = ( isset( $_POST['kmb'] ) ? $_POST['kmb'] : '' );

	$meta_key = 'kmb';

	$meta_value = get_post_meta( $post_id, $meta_key, true );

	if ( $new_meta_value && '' == $meta_value ) {
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	} else if ( $new_meta_value && $new_meta_value != $meta_value ) {
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	} else if ( '' == $new_meta_value && $meta_value ) {
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}

}

// Module builder HTML

function kmb_meta_box_html( $object, $box ) {

	wp_nonce_field( basename( __FILE__ ), 'kmb_nonce' ); 

      global $post;

	?> 

	<div id="insert-module" class="dropdown">
		<a data-toggle="dropdown" class="btn btn-primary" href="#">Insert Module &nbsp;<span class="caret"></span></a>
		<ul class="dropdown-menu type-<?php echo $post->post_type; ?>" role="menu"></ul>
	</div>

	<div id="insert-template" class="dropdown">
		<a data-toggle="dropdown" class="btn btn-primary" href="#">Templates &nbsp;<span class="caret"></span></a>
		<ul class="dropdown-menu type-<?php echo $post->post_type; ?>" role="menu">

			<li><a href="#" class="btn btn-warning btn-sm" id="save-template">Save current page as template</a></li>

			<?php 

			global $wpdb;
			$table_name = $wpdb->prefix . "kmbtemplates"; 
			$templates = $wpdb->get_results( "SELECT `id`, `title` FROM $table_name" );

			foreach ( $templates as $template ) {
				echo '<li><a class="add" href="#" data-id="' . $template->id . '">' . $template->title . '</a><a href="#" class="delete" data-id="' . $template->id . '">DELETE</a></li>';
			}

			?>

		</ul>
	</div>

	<div id="kmb-container" class="loading"></div>
	<div id="kmb-container-clone"></div>

	<textarea name="kmb" id="kmb" style="width:400px;height:300px"><?php echo esc_attr( get_post_meta( $object->ID, 'kmb', true ) ); ?></textarea>

<?php

}

// Function that outputs the modular box at the end of the body

function kmb_modular_box() { 

	global $post;

	$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 'no');
	$template_file = $post_id != 'no' ? get_post_meta($post_id,'_wp_page_template',TRUE) : 'no';

	if ( $template_file == 'template-modular.php' || ( isset( $post ) && $post->post_type == 'portfolio' ) ) : ?>

		<div class="kmb-modal modal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        	<h4 class="modal-title" id="myModalLabel">Insert Module</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="append-here"></div>
							<div class="form-group kmb-custom-tinymce">
								<label for="kmbcontent">Content</label>
								<?php wp_editor( '', 'kmbcontent', array( 'editor_class' => 'form-control textarea_html' )  ); ?>
								<p class="help-block fkmbcontent"></p>
							</div>
						</form>	
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary save" data-dismiss="modal">Save changes</button>
					</div>
				</div>
			</div>
		</div>

	<?php endif;
}

add_action( 'admin_footer', 'kmb_modular_box', 99 );

// Create templates table

function kmb_templates() {

	global $wpdb;
	$table_name = $wpdb->prefix . "kmbtemplates"; 

	if ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'" ) != $table_name ) {

		$charset_collate = '';

		if ( ! empty( $wpdb->charset ) ) {
		  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
		}

		if ( ! empty( $wpdb->collate ) ) {
		  $charset_collate .= " COLLATE {$wpdb->collate}";
		}

		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  title text NOT NULL,
		  text text NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	}

}

add_action( 'init', 'kmb_templates' );

// Function that saves the template

function kmb_save_template(){

	$title = $_POST['title'];
	$meta = stripslashes( $_POST['meta'] );

	global $wpdb;
	$table_name = $wpdb->prefix . "kmbtemplates"; 

	$wpdb->insert( 
		$table_name, 
		array( 
			'title' => $title,
			'text' => $meta
		) 
	);

	exit;

}

add_action( 'wp_ajax_kmb-save-template', 'kmb_save_template' );

// Function that inserts the template

function kmb_insert_template(){

	$id = $_POST['id'];

	global $wpdb;
	$table_name = $wpdb->prefix . "kmbtemplates"; 

	$column = $wpdb->get_col( "SELECT `text` FROM $table_name WHERE `id`=$id" );
	echo $column[0];

	exit;

}

add_action( 'wp_ajax_kmb-insert-template', 'kmb_insert_template' );

// Function that removes the template

function kmb_remove_template(){

	$id = $_POST['id'];

	global $wpdb;
	$table_name = $wpdb->prefix . "kmbtemplates"; 

	$wpdb->delete( $table_name, array( 'ID' => $id ) );

	exit;

}

add_action( 'wp_ajax_kmb-remove-template', 'kmb_remove_template' );

?>