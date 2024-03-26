<?php
// book-details-block.php

function book_details_block_render() {
    // Get the post ID
    $post_id = get_the_ID();

    // Retrieve custom fields
    $author = get_post_meta($post_id, 'book_author', true);
    $isbn = get_post_meta($post_id, 'book_isbn', true);
    $genre = get_post_meta($post_id, 'book_genre', true);

    // Output the fields
    echo '<div class="book-details">';
    echo '<p><strong>Author:</strong> ' . $author . '</p>';
    echo '<p><strong>ISBN:</strong> ' . $isbn . '</p>';
    echo '<p><strong>Genre:</strong> ' . $genre . '</p>';
    echo '</div>';
}
