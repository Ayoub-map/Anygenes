<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <p><img src="<?php the_post_thumbnail_url() ?>" alt="image" style="width:25%; height:auto;"></p>
            <h1><?php the_title() ?></h1>
            <h6><?php the_content() ?></h6>
        <?php endwhile; ?>
    </div>
<?php else : ?>
    <h1> Pas d'articles </h1>
<?php endif; ?>

<?php get_footer(); ?>