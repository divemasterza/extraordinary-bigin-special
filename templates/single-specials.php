<?php
$accent_color = get_option('hs_accent_color', '#f04e23');
$validity_date = get_post_meta(get_the_ID(), '_validity_date', true);
$price = get_post_meta(get_the_ID(), '_price', true);
$packages = get_post_meta(get_the_ID(), '_packages', true);
$ending_soon = get_post_meta(get_the_ID(), '_ending_soon', true) === 'true';

get_header(); ?>

<main id="primary" class="site-main">
    <div class="specials-single">
        <?php while (have_posts()) : the_post(); ?>
            <!-- Hero Section Start -->
            <div class="hero-section">
                <?php the_post_thumbnail('full'); ?>
                <div class="hero-content">
                    <h1><?php the_title(); ?></h1>
                    <p class="price-line">From: R<?php echo $price; ?> <?php echo ucwords(strtolower($packages)) ?></p>
                    <a href="#enquiry-form" class="cta-btn">Enquire Now</a>
                </div>
            </div>
            <!-- Hero Section End -->

            <!-- Gallery start -->
            <?php
            $image_ids = get_post_meta(get_the_ID(), '_image_ids', true);
            $image_ids = explode(',', $image_ids);

            if (!empty($image_ids) && is_array($image_ids)) : ?>
                <div class="slick-slider">
                    <?php foreach ($image_ids as $image_id) :
                        if (empty($image_id)) continue;

                        $image_full = wp_get_attachment_image_src($image_id, 'full');
                        $image_medium = wp_get_attachment_image_src($image_id, 'medium');

                        if ($image_full && $image_medium) : ?>
                            <div>
                                <a href="<?php echo esc_url($image_full[0]); ?>" data-lightbox="specials-gallery">
                                    <img src="<?php echo esc_url($image_medium[0]); ?>">
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <!-- Gallery end -->

            <?php if ($ending_soon) : ?>
                <div class="ending-soon-callout">Ending Soon!</div>
            <?php endif; ?>

            <div class="content-section">
                <div class="content-two-thirds">
                    <?php the_content(); ?>
                </div>

                <div class="content-one-third">
                    <div class="enquiry-form" id="enquiry-form">
                        <?php echo get_option('hs_form_code', ''); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>