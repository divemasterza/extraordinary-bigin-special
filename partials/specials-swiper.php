<?php
$image_ids = get_post_meta(get_the_ID(), '_image_ids', true);
$image_ids = explode(',', $image_ids);

if (!empty($image_ids) && is_array($image_ids)) : ?>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($image_ids as $image_id) :
                if (empty($image_id)) continue;

                $image_full = wp_get_attachment_image_src($image_id, 'full');
                $image_medium = wp_get_attachment_image_src($image_id, 'medium');

                if ($image_full && $image_medium) : ?>
                    <div class="swiper-slide">
                        <a href="<?php echo esc_url($image_full[0]); ?>" data-lightbox="specials-gallery">
                            <img src="<?php echo esc_url($image_medium[0]); ?>">
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
<?php endif; ?>