jQuery(document).ready(function ($) {
    const $loadMoreBtn = $('#load-more-projects');
    const $projectsList = $('#projects-list');

    function updateLoadMoreButton(currentPage, maxPages, isLoading = false) {
        if ($loadMoreBtn.length) {
            const originalText = 'Показать еще';
            const loadingText = $loadMoreBtn.data('loading-text') || 'Загрузка...';

            if (isLoading) {
                $loadMoreBtn.text(loadingText).prop('disabled', true);
            } else {
                $loadMoreBtn.text(originalText).prop('disabled', false);
            }

            if (currentPage >= maxPages) {
                $loadMoreBtn.hide();
            } else {
                $loadMoreBtn.show();
            }
        }
    }

    if ($loadMoreBtn.length && $projectsList.length) {
        let currentPage = parseInt($loadMoreBtn.data('current-page'));
        const postsPerPage = parseInt($loadMoreBtn.data('posts-per-page'));
        let maxPages = parseInt($loadMoreBtn.data('max-pages'));


        updateLoadMoreButton(currentPage, maxPages, false);


        $loadMoreBtn.on('click', function (e) {
            e.preventDefault();

            updateLoadMoreButton(currentPage, maxPages, true);

            const industryFilter = $loadMoreBtn.data('industry-filter');

            $.ajax({
                url: project_ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_more_projects',
                    page: currentPage,
                    posts_per_page: postsPerPage,
                    industry_filter: industryFilter
                },
                success: function (response) {
                    if (response.html) {
                        $projectsList.append(response.html);
                        currentPage = response.next_page;
                    }


                    updateLoadMoreButton(currentPage, maxPages, false);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown, jqXHR);
                    updateLoadMoreButton(currentPage, maxPages, false);
                }
            });
        });


        const $industryFilterSelect = $('#industry-filter');
        if ($industryFilterSelect.length) {
            $industryFilterSelect.on('change', function () {
                const selectedValue = $(this).val();
                let selectedSlug = '';

                try {
                    const url = new URL(selectedValue);
                    const pathSegments = url.pathname.split('/').filter(Boolean);
                    selectedSlug = pathSegments.length > 0 ? pathSegments[pathSegments.length - 1] : '';
                } catch (e) {
                    selectedSlug = selectedValue;
                }

                $loadMoreBtn.data('industry-filter', selectedSlug);
                $loadMoreBtn.data('current-page', 0);
                currentPage = 0;

                $projectsList.empty();
                updateLoadMoreButton(0, maxPages, false);

                setTimeout(function () {
                    $loadMoreBtn.trigger('click');
                }, 10);
            });
        }
    }
});