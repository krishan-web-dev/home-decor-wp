<?php get_header(); ?>

<main class="container mx-auto p-6">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="prose lg:prose-xl">
            <h1 class="text-4xl font-bold"><?php the_title(); ?></h1>
            <p class="text-gray-500 text-sm">Published on <?php echo get_the_date(); ?> by <?php the_author(); ?></p>
            <div class="mt-4">
                <?php the_content(); ?>
            </div>
        </article>
        
        <!-- Post Navigation -->
        <div class="mt-8 flex justify-between">
            <div><?php previous_post_link('%link', '← Previous Post'); ?></div>
            <div><?php next_post_link('%link', 'Next Post →'); ?></div>
        </div>
    <?php endwhile; else: ?>
        <p class="text-gray-600">Sorry, no posts found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
