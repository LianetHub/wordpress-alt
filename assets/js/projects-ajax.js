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


    function getIndustryFilterFromQueryParams() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('type') || '';
    }


    function updateUrl(filterSlug) {
        const baseUrl = window.location.pathname;
        let newUrl = baseUrl;
        const urlParams = new URLSearchParams(window.location.search);

        if (filterSlug && filterSlug !== '') {
            urlParams.set('type', filterSlug);
        } else {
            urlParams.delete('type');
        }

        const queryString = urlParams.toString();
        if (queryString) {
            newUrl += '?' + queryString;
        }

        history.pushState({ industryFilter: filterSlug }, '', newUrl);
    }


    function performAjaxLoad(page, postsPerPage, industryFilter, isFilterChange = false, pushState = true) {
        let pageToSend = isFilterChange ? 0 : page;

        updateLoadMoreButton(page, 9999, true);

        if (isFilterChange) {
            $projectsList.empty();
        }

        $.ajax({
            url: project_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_projects',
                page: pageToSend,
                posts_per_page: postsPerPage,
                industry_filter: industryFilter
            },
            success: function (response) {
                if (response.html && response.html.trim() !== '<p>По выбранным критериям проекты не найдены.</p>') {
                    $projectsList.append(response.html);
                    currentPage = response.next_page;
                    maxPages = response.max_pages;
                } else {
                    $projectsList.empty().append('<p>По выбранным критериям проекты не найдены.</p>');
                    currentPage = 0;
                    maxPages = 0;
                }

                updateLoadMoreButton(currentPage, maxPages, false);

                if (pushState) {
                    updateUrl(industryFilter);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown, jqXHR);
                updateLoadMoreButton(currentPage, 0, false);
                if (isFilterChange) {
                    $projectsList.empty().append('<p>Произошла ошибка при загрузке проектов.</p>');
                }
            }
        });
    }


    if ($loadMoreBtn.length && $projectsList.length) {
        let currentPage = parseInt($loadMoreBtn.data('current-page'));
        const postsPerPage = parseInt($loadMoreBtn.data('posts-per-page'));
        let maxPages = parseInt($loadMoreBtn.data('max-pages'));


        updateLoadMoreButton(currentPage, maxPages, false);


        const initialFilterSlug = getIndustryFilterFromQueryParams();
        const $industryFilterSelects = $('.project-filter-select');


        $industryFilterSelects.val(initialFilterSlug);
        $loadMoreBtn.data('industry-filter', initialFilterSlug);


        $loadMoreBtn.on('click', function (e) {
            e.preventDefault();
            const industryFilter = $loadMoreBtn.data('industry-filter');
            performAjaxLoad(currentPage, postsPerPage, industryFilter, false, false);
        });


        if ($industryFilterSelects.length) {
            $industryFilterSelects.on('change', function () {
                const selectedSlug = $(this).val();
                $industryFilterSelects.not(this).val(selectedSlug);

                $loadMoreBtn.data('industry-filter', selectedSlug);
                $loadMoreBtn.data('current-page', 0);
                currentPage = 0;


                performAjaxLoad(0, postsPerPage, selectedSlug, true, true);
            });
        }


        window.addEventListener('popstate', function (event) {
            const stateFilter = event.state ? event.state.industryFilter : getIndustryFilterFromQueryParams();

            $industryFilterSelects.val(stateFilter);


            $loadMoreBtn.data('industry-filter', stateFilter);
            $loadMoreBtn.data('current-page', 0);
            currentPage = 0;

            performAjaxLoad(0, postsPerPage, stateFilter, true, false);
        });
    }
});