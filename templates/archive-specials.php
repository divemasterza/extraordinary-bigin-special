<?php
$accent_color = get_option('hs_accent_color', '#f04e23');

get_header(); ?>

<main id="primary" class="site-main">
    <div class="specials-archive">
        <?php if (have_posts()) : ?>
            <header>
                <h1><?php post_type_archive_title(); ?></h1>
            </header>

            <div class="specials-grid">
                <?php
                // Start the Loop
                while (have_posts()) :
                    the_post();

                    $validity_date = get_post_meta(get_the_ID(), '_validity_date', true);
                    $price = get_post_meta(get_the_ID(), '_price', true);
                    $packages = get_post_meta(get_the_ID(), '_packages', true);
                ?>

                    <div class="special-card">
                        <h2><?php the_title(); ?></h2>
                        <p>Validity Date: <?php echo $validity_date; ?></p>
                        <p>Price: <?php echo $price; ?></p>
                        <p>Packages: <?php echo $packages; ?></p>
                    </div>
                    <div class="special-card">
                        ...
                        <?php if (get_post_meta(get_the_ID(), '_ending_soon', true) === 'true') : ?>
                            <div class="ending-soon-callout">Ending Soon!</div>
                        <?php endif; ?>
                    </div>

                <?php endwhile; ?>
            </div>

            <?php the_posts_navigation(); ?>

        <?php else : ?>
            <p><?php _e('No specials available.'); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
?>