<?php
$accent_color = get_option('es_accent_color');
$validity_date = get_post_meta(get_the_ID(), '_validity_date', true);
$price = get_post_meta(get_the_ID(), '_price', true);
$packages = get_post_meta(get_the_ID(), '_packages', true);
$ending_soon = get_post_meta(get_the_ID(), '_ending_soon', true) === 'true';

get_header(); ?>

<!-- Plugin Color Setting -->

<style>
    .esp-ribbon {
    background: <?echo $accent_color;?>;
    box-shadow: 0 0 0 999px <?echo $accent_color;?>;
}

.esp-cta-btn{
    background:<?echo $accent_color;?>;
}

.esp-cta-btn:hover{
   background:<?echo $accent_color;?>;
   filter: brightness(90%);
}

.esp-myswiper .swiper-pagination-bullet-active {
    background: <?echo $accent_color;?> !important;
}

.esp-myswiper [class^="swiper-button-"]::after{
    font-size: 22px;
    color:<?echo $accent_color;?>;
}

.wf-btn{
     background: <?echo $accent_color;?> !important;
}

.wf-btn:hover{
   background:<?echo $accent_color;?>;
   filter: brightness(90%);
}

.wf-field-mandatory .wf-field-inner::before {
    background-color:<?echo $accent_color;?> !important;
}

.wf-field-input:focus {
    border-color: <?echo $accent_color;?> !important;
}


</style>

<!-- Plugin Color Setting End -->

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css'>

<main id="primary" class="site-main">
    <div class="specials-single">
        <?php while (have_posts()) : the_post(); ?>
            <!-- Hero Section Start -->
            <div class="esp-hero-section">
                            <?php if ($ending_soon) : ?>
                <div class="esp-ending-soon-callout esp-ribbon esp-ribbon-right">Ending Soon!</div>
            <?php endif; ?>
                <?php the_post_thumbnail('full'); ?>
                <div class="esp-hero-content">
                    <h1><?php the_title(); ?></h1>
                </div>
                 <!-- Information Block Start -->
                 
                <div class="esp-special-information-block">
              <div class="esp-item-wrapper">
                <div class="esp-item">
                  <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;width: 50px;height: 50px;" xml:space="preserve" class="">
                    <g>
                      <path d="M496 344h-8v-64a32.042 32.042 0 0 0-32-32V112a32.042 32.042 0 0 0-32-32H88a32.042 32.042 0 0 0-32 32v136a32.042 32.042 0 0 0-32 32v64h-8a8 8 0 0 0-8 8v32a8 8 0 0 0 8 8h8v32a8 8 0 0 0 8 8h24a7.99 7.99 0 0 0 7.84-6.43L70.56 392h370.88l6.72 33.57A7.99 7.99 0 0 0 456 432h24a8 8 0 0 0 8-8v-32h8a8 8 0 0 0 8-8v-32a8 8 0 0 0-8-8ZM72 112a16.021 16.021 0 0 1 16-16h336a16.021 16.021 0 0 1 16 16v136h-16v-32a32.042 32.042 0 0 0-32-32h-96a32.042 32.042 0 0 0-32 32v32h-16v-32a32.042 32.042 0 0 0-32-32h-96a32.042 32.042 0 0 0-32 32v32H72Zm336 104v32H280v-32a16.021 16.021 0 0 1 16-16h96a16.021 16.021 0 0 1 16 16Zm-176 0v32H104v-32a16.021 16.021 0 0 1 16-16h96a16.021 16.021 0 0 1 16 16ZM40 280a16.021 16.021 0 0 1 16-16h400a16.021 16.021 0 0 1 16 16v64H40Zm9.44 136H40v-24h14.24ZM472 416h-9.44l-4.8-24H472Zm16-40H24v-16h464Z" fill="<?echo $accent_color;?>" opacity="1" data-original="#000000" class=""></path>
                    </g>
                  </svg>
                </div>
                <div class="esp-item">
                  <p>From: R<?php echo $price; ?></p>
                  <small><?php echo ucwords(strtolower($packages)) ?></small>
                </div>
              </div>
              <div class="esp-item-wrapper">
                <div class="esp-item">
                  <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 100 100" style="enable-background:new 0 0 512 512;width: 50;height: 50;" xml:space="preserve" class="">
                    <g>
                      <path d="M45.55 62.14A8.12 8.12 0 0 0 37.74 70a7.28 7.28 0 0 0 7.34 7.55h.21a8.12 8.12 0 0 0 7.81-7.82 7.29 7.29 0 0 0-7.55-7.55zM45.22 75a4.74 4.74 0 0 1-4.93-5 5.54 5.54 0 0 1 5.33-5.33 4.74 4.74 0 0 1 4.93 4.93 5.54 5.54 0 0 1-5.33 5.4zM45.68 46.42h.21a8.12 8.12 0 0 0 7.81-7.82 7.26 7.26 0 0 0-2.13-5.41 7.36 7.36 0 0 0-5.42-2.14 8.12 8.12 0 0 0-7.81 7.82 7.28 7.28 0 0 0 7.34 7.55zm.54-12.81a4.73 4.73 0 0 1 4.93 4.93 5.55 5.55 0 0 1-5.33 5.33 4.85 4.85 0 0 1-3.55-1.39 4.79 4.79 0 0 1-1.38-3.54 5.53 5.53 0 0 1 5.33-5.33zM27.758 53.478l35.89-.933.066 2.55-35.89.933zM74.49 14.33a5.67 5.67 0 0 0-8 0l-2.81 2.81a5.67 5.67 0 0 0 0 8l11.18 11.18a5.67 5.67 0 0 0 8 0l2.81-2.81a5.67 5.67 0 0 0 0-8zm9.37 17.37-2.81 2.81a3.1 3.1 0 0 1-4.38 0L65.49 23.33a3.1 3.1 0 0 1 0-4.38l2.81-2.81a3.09 3.09 0 0 1 4.38 0l11.18 11.18a3.1 3.1 0 0 1 0 4.38z" fill="<?echo $accent_color;?>" opacity="1" data-original="#000000" class=""></path>
                      <path d="M97 39.64 94.88 8.8a3.89 3.89 0 0 0-3.59-3.6L60.36 3a9.69 9.69 0 0 0-7.53 2.82l-47 47a9.7 9.7 0 0 0 0 13.69l27.64 27.66a9.71 9.71 0 0 0 13.7 0l47-47A9.69 9.69 0 0 0 97 39.64zm-4.62 5.73-47 47a7.15 7.15 0 0 1-10.09 0L7.64 64.73a7.15 7.15 0 0 1 0-10.09l47-47a7.16 7.16 0 0 1 5-2.09h.5l30.97 2.2A1.31 1.31 0 0 1 92.33 9l2.1 30.85a7.18 7.18 0 0 1-2.07 5.52z" fill="<?echo $accent_color;?>" opacity="1" data-original="#000000" class=""></path>
                    </g>
                  </svg>
                </div>
                <div class="esp-item">
                  <p>Expires on: <?php 
                  
                  $getdate = DateTime::createFromFormat('Y-m-d', $validity_date);
                  $formatdate = $getdate->format('j F Y');
                  
                  echo $formatdate;
                  
                  ?></p>
                  <small>Terms &amp; Conditions Apply</small>
                </div>
              </div>
              <div class="esp-item-wrapper">
                       <a href="#enquiry-form" class="esp-cta-btn">Enquire Now <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;width: 20px;height: 20px;" xml:space="preserve" class="">
                      <g>
                        <path d="M256 0C114.837 0 0 114.837 0 256s114.837 256 256 256 256-114.837 256-256S397.163 0 256 0zm79.083 271.083L228.416 377.749A21.275 21.275 0 0 1 213.333 384a21.277 21.277 0 0 1-15.083-6.251c-8.341-8.341-8.341-21.824 0-30.165L289.835 256l-91.584-91.584c-8.341-8.341-8.341-21.824 0-30.165s21.824-8.341 30.165 0l106.667 106.667c8.341 8.341 8.341 21.823 0 30.165z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path>
                      </g>
                    </svg>
                  </a>
              </div>
            </div>
           <!-- Information Block End -->

            </div>
            <!-- Hero Section End -->

            <!-- Swiper -->
            <div class="swiper esp-myswiper">
                <div class="swiper-wrapper">
                    <?php
                    $image_ids = get_post_meta(get_the_ID(), '_image_ids', true);
                    $image_ids = explode(',', $image_ids);

                    if (!empty($image_ids) && is_array($image_ids)) :
                        foreach ($image_ids as $image_id) :
                            if (empty($image_id)) continue;

                            $image_url = wp_get_attachment_image_src($image_id, 'full');

                            if ($image_url) : ?>
                                <div class="swiper-slide">
                                    <a data-lightbox="gallerygroup" href="<?php echo esc_url($image_url[0]); ?>">
                                    <img class="swiper-img" src="<?php echo esc_url($image_url[0]); ?>" alt="" loading="lazy" />
                                    </a>
                                    <div class="swiper-lazy-preloader"></div>
                                </div>
                    <?php endif;
                        endforeach;
                    endif;
                    ?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>

                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <!-- Gallery end -->

            <div class="esp-content-section">
                <div class="esp-content-two-thirds">
                    <?php the_content(); ?>
                </div>

                <div class="esp-content-one-third">
                    <div class="esp-enquiry-form" id="enquiry-form">
                        <?php echo get_option('es_form_code', ''); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>