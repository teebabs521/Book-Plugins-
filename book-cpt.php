<?php
/*
Plugin Name: Custom Book Post Type
Description: Plugin to create a custom post type for books with custom fields.
Version: 1.0
Author: Your Name
*/

// Register Custom Post Type
function custom_book_post_type() {

	$labels = array(
		'name'                  => _x( 'Books', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Book', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Books', 'text_domain' ),
		'name_admin_bar'        => __( 'Book', 'text_domain' ),
		'archives'              => __( 'Book Archives', 'text_domain' ),
		'attributes'            => __( 'Book Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Book:', 'text_domain' ),
		'all_items'             => __( 'All Books', 'text_domain' ),
		'add_new_item'          => __( 'Add New Book', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Book', 'text_domain' ),
		'edit_item'             => __( 'Edit Book', 'text_domain' ),
		'update_item'           => __( 'Update Book', 'text_domain' ),
		'view_item'             => __( 'View Book', 'text_domain' ),
		'view_items'            => __( 'View Books', 'text_domain' ),
		'search_items'          => __( 'Search Book', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Book', 'text_domain' ),
		'description'           => __( 'Books', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_icon'              => 'dashicons-book',
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'				=> 'books',
	);
	register_post_type( 'book', $args );

}
add_action( 'init', 'custom_book_post_type', 0 );

register_post_meta('book','book_author',array(
	'show_in_rest' 	=> true,
	'single'		=> true,
	'type'			=> 'string',
));
register_post_meta('book','book_isbn',array(
	'show_in_rest' 	=> true,
	'single'		=> true,
	'type'			=> 'string',
));

// Add custom fields for Book post type
function custom_book_custom_fields() {
    add_meta_box(
        'custom-book-fields',
        __( 'Book Details', 'text_domain' ),
        'custom_book_fields_callback',
        'book'
    );
}
add_action( 'add_meta_boxes', 'custom_book_custom_fields' );

// Custom fields callback function
function custom_book_fields_callback( $post ) {
    // Retrieve existing values
    $author = get_post_meta( $post->ID, 'book_author', true );
    $description = get_post_meta( $post->ID, 'book_description', true );
    $isbn = get_post_meta( $post->ID, 'book_isbn', true );
    $genre = get_post_meta( $post->ID, 'book_genre', true );
    ?>
    <p>
        <label for="book_author"><?php _e( 'Author:', 'text_domain' ); ?></label>
        <input type="text" name="book_author" id="book_author" value="<?php echo esc_attr( $author ); ?>">
    </p>
    <p>
        <label for="book_description"><?php _e( 'Description:', 'text_domain' ); ?></label>
        <textarea name="book_description" id="book_description"><?php echo esc_textarea( $description ); ?></textarea>
    </p>
    <p>
        <label for="book_isbn"><?php _e( 'ISBN:', 'text_domain' ); ?></label>
        <input type="text" name="book_isbn" id="book_isbn" value="<?php echo esc_attr( $isbn ); ?>">
    </p>
    <p>
        <label for="book_genre"><?php _e( 'Genre:', 'text_domain' ); ?></label>
        <input type="text" name="book_genre" id="book_genre" value="<?php echo esc_attr( $genre ); ?>">
    </p>
    <?php
}

// Save custom fields data
function save_custom_book_fields_data( $post_id ) {
    if ( isset( $_POST['book_author'] ) ) {
        update_post_meta( $post_id, 'book_author', sanitize_text_field( $_POST['book_author'] ) );
    }
    if ( isset( $_POST['book_description'] ) ) {
        update_post_meta( $post_id, 'book_description', sanitize_textarea_field( $_POST['book_description'] ) );
    }
    if ( isset( $_POST['book_isbn'] ) ) {
        update_post_meta( $post_id, 'book_isbn', sanitize_text_field( $_POST['book_isbn'] ) );
    }
    if ( isset( $_POST['book_genre'] ) ) {
        update_post_meta( $post_id, 'book_genre', sanitize_text_field( $_POST['book_genre'] ) );
    }
}
add_action( 'save_post', 'save_custom_book_fields_data' );
