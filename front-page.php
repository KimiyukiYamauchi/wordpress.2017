<?php get_header(); ?>
    <div class="contentsWrap">
        <div class="mainContents">

            <div class="aboutBlock block">
                <div class="banners">
                    <ul>
                        <li><a href="<?php echo get_permalink(53); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/home/bnr_about.png" height="97" width="320" alt="ホテル紹介"></a></li>
                        <li><a href="<?php echo get_permalink(64); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/home/bnr_access.png" height="97" width="320" alt="アクセス"></a></li>
                    </ul>
                </div>
            </div><!-- /.aboutBlock -->

            <div>
            <?php
            switch_to_blog(get_id_from_blogname('annex'));  // ブログIDを指定してスイッチ
            bloginfo('name');   // ブログID 2 のサイト名である「ホテル別館」が表示
            $args = array(
                'posts_per_page' => 5 // 表示件数を指定
            );
            $the_query = new WP_Query($args);
            if($the_query->have_posts()) :
                while($the_query->have_posts()) :
                    $the_query->the_post();
            ?>
            <div><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
            <?php
                endwhile;
            endif;
            restore_current_blog(); // 元のブログに戻す
            ?>

            </div>

            <section class="newsBlock block">
                <h1 class="type-B"><span>新着情報</span></h1>
                <?php get_template_part('loop', 'main'); ?>
            </section><!-- /.newsBlock -->

        </div><!-- /.mainContents -->

        <aside class="subContents">
        <?php get_sidebar(); ?>
        </aside><!-- /.subContents -->
    </div><!-- /.contentsWrap -->

<?php get_footer(); ?>