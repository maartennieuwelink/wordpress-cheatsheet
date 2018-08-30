<?php

//======================================================================
// SINGLE POST W/ HIGHLIGHTED IMAGE
//======================================================================

$post_id = 1;
$post_data = get_post($post_id);
$url = wp_get_attachment_url(get_post_thumbnail_id($post_id));
$src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'thumbnail_size');
$featured = get_the_post_thumbnail_url($post->ID, 'thumbnail', true);
$url = $src[0];

//======================================================================
// END OF POST
//======================================================================

?>

<?php

//======================================================================
// GET POSTS FROM CATEGORIE
//======================================================================

global $post;

$args = array(
    'posts_per_page' => 10,
    'offset' => 0,
    'cat' => 1, 
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
);
?>
<?php $myposts = get_posts( $args ); ?>
<?php foreach( $myposts as $post ) : setup_postdata($post); ?>

<?php $featured = get_the_post_thumbnail_url($post->ID, 'full', true); ?>

    <!-- Content goes here -->

<?php endforeach;

//======================================================================
// END OF LOOP
//======================================================================

?>

<?php

//======================================================================
// GET POSTS FROM CATEGORIE WITH PAGINATION
//======================================================================

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}

$custom_query_args = array(
    'post_type' => 'post',
    'posts_per_page' => 4,
    'paged' => $paged,
    'post_status' => 'publish',
    'ignore_sticky_posts' => true,
    'cat' => 6,
    'order' => 'DESC',
    'orderby' => 'date'
);
$custom_query = new WP_Query( $custom_query_args );

if ( $custom_query->have_posts() ) :
    while( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

        <?php $featured = get_the_post_thumbnail_url($post->ID, 'full', true); ?>

        <!-- Content goes here -->

        <?php
    endwhile;
    ?>

    <?php if ($custom_query->max_num_pages > 1) : ?>
    <?php
    $orig_query = $wp_query;
    $wp_query = $custom_query;
    ?>

        <nav class="prev-next-posts">
            <div class="prev-posts-link">
                <?php echo get_next_posts_link( '<i class="uk-icon uk-icon-arrow-left"></i> Oudere berichten', $custom_query->max_num_pages ); ?>
            </div>
            <div class="next-posts-link">
                <?php echo get_previous_posts_link( 'Nieuwere berichten <i class="uk-icon uk-icon-arrow-right"></i>' ); ?>
            </div>
        </nav>

    <?php
    $wp_query = $orig_query;
    ?>
<?php endif; ?>

    <?php
    wp_reset_postdata();
else:
    echo '<p>'.__('Sorry, no posts matched your criteria.').'</p>';
endif;

//======================================================================
// END OF LOOP
//======================================================================

?>

<?php

//======================================================================
// GET POSTS FROM CATEGORIE WITH MIXED CONTENT
//======================================================================

global $post;

$args = array(
    'posts_per_page' => 10,
    'offset' => 0,
    'cat' => 1,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
);
?>
<?php $myposts = get_posts( $args ); ?>
<?php foreach( $myposts as $post ) : setup_postdata($post); ?>

<?php $featured = get_the_post_thumbnail_url($post->ID, 'full', true); ?>

<?php if ($query->current_post % 2 == 0): ?>

    <!-- Content 1 goes here -->

<?php else: ?>

    <!-- Content 2 goes here -->

<?php endif; ?>

<?php endforeach;

//======================================================================
// END OF LOOP
//======================================================================

?>