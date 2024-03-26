<?php
/*
Template Name: Single Book Template
*/
?>

<?php get_header(); ?>

<main id="site-content" role="main">

    <?php
    // Query book posts
    $book_query = new WP_Query(array(
        'post_type' => 'book', // Specify the custom post type for books
        'posts_per_page' => -1, // Display all book posts
    ));

    // Check if there are any book posts
    if ($book_query->have_posts()) :
        // Start the loop
        while ($book_query->have_posts()) :
            $book_query->the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                    <div class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></div>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php
                    // Include the Book Details Block
                    include 'book-details-block.php'; // Include the block element file
                    book_details_block_render(); // Call the render function
                    ?>
                </div><!-- .entry-content -->

            </article><!-- #post-## -->

            <?php
        endwhile;

        // Reset post data
        wp_reset_postdata();
    else :
        // If no book posts are found
        echo 'No books found.';
    endif;
    ?>

</main><!-- #site-content -->

<?php get_footer(); ?>
