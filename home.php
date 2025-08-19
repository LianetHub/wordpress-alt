<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>

<div class="blog blog--white">
    <div class="container">
        <div class="blog__content">
            <div class="blog__body">
                <ul class="blog__list" id="blog-posts-container">
                    <?php
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type'           => 'post',
                        'posts_per_page'      => 9,
                        'post_status'         => 'publish',
                        'orderby'             => 'date',
                        'order'               => 'DESC',
                        'paged'               => $paged,
                        'ignore_sticky_posts' => true
                    );

                    $home_posts_query = new WP_Query($args);

                    if ($home_posts_query->have_posts()) :
                        while ($home_posts_query->have_posts()) : $home_posts_query->the_post();
                    ?>
                            <li class="blog__item">
                                <a href="<?php the_permalink(); ?>" class="blog__item-poster">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('full', array('class' => 'cover-image'));
                                    } else {
                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/default-article-placeholder.png') . '" class="cover-image" alt="Изображение по умолчанию">';
                                    }
                                    ?>
                                </a>
                                <div class="blog__item-body">
                                    <time datetime="<?= get_russian_post_date(get_the_ID(), 'datetime'); ?>" class="blog__item-time"><?= esc_html(get_russian_post_date(get_the_ID())); ?></time>
                                    <a href="<?php the_permalink(); ?>" class="blog__item-title title-sm"><?php the_title(); ?></a>
                                </div>
                            </li>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p>Пока нет доступных статей.</p>';
                    endif;
                    ?>
                </ul>
                <?php
                $total_posts = wp_count_posts('post')->publish;
                $paged_initial_posts = $home_posts_query->post_count;
                if ($total_posts > $paged_initial_posts) :
                ?>
                    <button class="blog__more btn btn-primary btn-lg" id="load-more-btn" data-page="1" data-max-pages="<?= $home_posts_query->max_num_pages; ?>">Показать еще</button>
                <?php endif; ?>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const loadMoreBtn = document.getElementById('load-more-btn');
                const postsContainer = document.getElementById('blog-posts-container');

                if (loadMoreBtn && postsContainer) {
                    let currentPage = parseInt(loadMoreBtn.dataset.page);
                    const maxPages = parseInt(loadMoreBtn.dataset.maxPages);
                    const ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

                    loadMoreBtn.addEventListener('click', function(e) {
                        e.preventDefault();

                        loadMoreBtn.textContent = 'Загрузка...';
                        loadMoreBtn.disabled = true;

                        const data = new FormData();
                        data.append('action', 'load_more_posts');
                        data.append('paged', currentPage);
                        data.append('nonce', '<?php echo wp_create_nonce('load_more_posts_nonce'); ?>');

                        fetch(ajaxurl, {
                                method: 'POST',
                                body: data
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.success && result.data.html) {

                                    postsContainer.insertAdjacentHTML('beforeend', result.data.html);


                                    currentPage = result.data.paged;
                                    loadMoreBtn.dataset.page = currentPage;

                                    loadMoreBtn.textContent = 'Показать еще';
                                    loadMoreBtn.disabled = false;

                                    if (currentPage >= maxPages) {
                                        loadMoreBtn.style.display = 'none';
                                    }
                                } else {
                                    loadMoreBtn.style.display = 'none';
                                    console.log('No more posts to load.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                loadMoreBtn.textContent = 'Ошибка загрузки';
                                loadMoreBtn.disabled = false;
                            });
                    });
                }
            });
        </script>
    </div>
</div>

<?php require_once(TEMPLATE_PATH . '_callback.php'); ?>

<?php get_footer(); ?>