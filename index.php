<?php
// Fallback — WordPress requiert ce fichier.
// Les vraies pages utilisent les templates dans /templates/ et /template-parts/
get_header();
?>
<main id="main" class="site-main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php
get_footer();
