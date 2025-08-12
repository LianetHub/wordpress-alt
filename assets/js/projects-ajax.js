jQuery(document).ready(function ($) {
    const $loadMoreBtn = $('#load-more-projects');
    const $projectsList = $('#projects-list');
    const $industryFilterSelects = $('.project-filter-select');

    // Глобальные переменные для хранения текущего состояния
    let currentPage; // Текущая страница, которую мы сейчас отображаем
    let postsPerPage; // Количество постов на страницу
    let maxPages; // Максимальное количество страниц для текущего запроса
    let currentIndustryFilter; // Текущий активный фильтр

    // Функция обновления состояния кнопки "Показать еще"
    function updateLoadMoreButton(isLoading = false) {
        if ($loadMoreBtn.length) {
            const originalText = 'Показать еще';
            const loadingText = $loadMoreBtn.data('loading-text') || 'Загрузка...';

            if (isLoading) {
                $loadMoreBtn.text(loadingText).prop('disabled', true).addClass('is-loading');
            } else {
                $loadMoreBtn.text(originalText).prop('disabled', false).removeClass('is-loading');
            }

            // Показываем/скрываем кнопку в зависимости от текущей страницы и общего количества страниц
            if (currentPage >= maxPages) {
                $loadMoreBtn.hide();
            } else {
                $loadMoreBtn.show();
            }
        }
    }

    // Получаем значение параметра 'type' из текущего URL
    function getIndustryFilterFromQueryParams() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('type') || '';
    }

    // Получаем значение параметра 'paged' из текущего URL
    function getPagedFromQueryParams() {
        const urlParams = new URLSearchParams(window.location.search);
        return parseInt(urlParams.get('paged')) || 1;
    }

    // Обновление URL в истории браузера
    function updateUrl(filterSlug, pageNum) {
        const baseUrl = window.location.pathname;
        let newUrl = baseUrl;
        const urlParams = new URLSearchParams(window.location.search);

        if (filterSlug) { // Если фильтр установлен, добавляем/обновляем
            urlParams.set('type', filterSlug);
        } else { // Иначе удаляем
            urlParams.delete('type');
        }

        if (pageNum > 1) { // Если страница больше 1, добавляем/обновляем
            urlParams.set('paged', pageNum);
        } else { // Иначе удаляем
            urlParams.delete('paged');
        }

        const queryString = urlParams.toString();
        if (queryString) {
            newUrl += '?' + queryString;
        }

        // Используем replaceState для изменения URL без добавления новой записи в историю,
        // если это не был явный "показать еще" или "смена фильтра"
        // или pushState, если мы действительно хотим новую запись в истории.
        // Здесь используем pushState, так как это изменение состояния.
        history.pushState({ industryFilter: filterSlug, page: pageNum }, '', newUrl);
    }

    // Основная функция AJAX-загрузки
    function performAjaxLoad(requestedPage, filterSlug, isFilterChange = false, pushHistoryState = true) {
        updateLoadMoreButton(true); // Показываем состояние загрузки

        if (isFilterChange) {
            $projectsList.empty(); // Очищаем список только при смене фильтра
            currentPage = 0; // Сбрасываем текущую страницу, чтобы следующая была 1
        }

        $.ajax({
            url: project_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_projects',
                page: requestedPage, // Передаем запрошенную страницу
                posts_per_page: postsPerPage, // Используем postsPerPage, инициализированный из data-атрибута
                industry_filter: filterSlug
            },
            success: function (response) {
                if (response.html && response.html.trim() !== '<p>По выбранным критериям проекты не найдены.</p>') {
                    $projectsList.append(response.html);
                    // Обновляем глобальные переменные состояния из ответа
                    currentPage = response.next_page; // next_page - это номер страницы, который был только что загружен
                    maxPages = response.max_pages;
                } else {
                    // Проекты не найдены
                    if (isFilterChange) { // Показываем сообщение только если это новый фильтр и нет результатов
                        $projectsList.empty().append('<p>По выбранным критериям проекты не найдены.</p>');
                    }
                    currentPage = 0; // Нет больше страниц
                    maxPages = 0;
                }

                updateLoadMoreButton(false); // Скрываем состояние загрузки

                if (pushHistoryState) {
                    updateUrl(filterSlug, currentPage); // Обновляем URL
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown, jqXHR);
                updateLoadMoreButton(false); // Скрываем состояние загрузки
                if (isFilterChange) {
                    $projectsList.empty().append('<p>Произошла ошибка при загрузке проектов.</p>');
                }
            }
        });
    }

    // --- Инициализация при готовности DOM ---
    if ($loadMoreBtn.length && $projectsList.length) {
        // Читаем начальное состояние из data-атрибутов PHP
        currentPage = parseInt($loadMoreBtn.data('current-page')) || 1;
        postsPerPage = parseInt($loadMoreBtn.data('posts-per-page')) || 4;
        maxPages = parseInt($loadMoreBtn.data('max-pages')) || 1;
        currentIndustryFilter = $loadMoreBtn.data('industry-filter') || '';

        // Убедимся, что селектор фильтра отражает начальный фильтр из URL
        $industryFilterSelects.val(currentIndustryFilter);

        // Обновляем видимость кнопки "Показать еще" на основе начального состояния
        updateLoadMoreButton(false);

        // --- Обработчики событий ---

        // Клик по кнопке "Показать еще"
        $loadMoreBtn.on('click', function (e) {
            e.preventDefault();
            // Запрашиваем следующую страницу (currentPage + 1)
            performAjaxLoad(currentPage + 1, currentIndustryFilter, false, true);
        });

        // Изменение фильтра в селекторе
        if ($industryFilterSelects.length) {
            $industryFilterSelects.on('change', function () {
                const selectedSlug = $(this).val();

                // Синхронизируем все селекторы фильтров (если их несколько, например, для мобильных/десктопов)
                $industryFilterSelects.not(this).val(selectedSlug);

                currentIndustryFilter = selectedSlug; // Обновляем глобальный фильтр
                // При смене фильтра всегда запрашиваем ПЕРВУЮ страницу (1)
                performAjaxLoad(1, currentIndustryFilter, true, true); // true = isFilterChange, true = pushHistoryState
            });
        }

        // Обработка кнопок браузера "Назад"/"Вперед" (popstate)
        window.addEventListener('popstate', function (event) {
            const state = event.state;
            let filterFromState = '';
            let pageFromState = 1;

            if (state && state.industryFilter !== undefined) { // Если есть данные в истории состояния
                filterFromState = state.industryFilter;
                pageFromState = state.page || 1;
            } else { // Если state null (например, при первом переходе или навигации по внешним ссылкам)
                // Получаем параметры из текущего URL
                filterFromState = getIndustryFilterFromQueryParams();
                pageFromState = getPagedFromQueryParams();
            }

            // Если текущее состояние JS отличается от состояния из истории/URL
            if (currentIndustryFilter !== filterFromState || currentPage !== pageFromState) {
                currentIndustryFilter = filterFromState;
                currentPage = pageFromState;

                // Синхронизируем выпадающий список
                $industryFilterSelects.val(currentIndustryFilter);

                // Загружаем контент. Важно: для popstate мы должны загрузить
                // только запрошенную страницу, а не очищать и загружать всё с 1-й.
                // Если мы хотим полностью восстановить состояние, где было 3 страницы загружено,
                // то нужно делать 3 AJAX-запроса или сохранять HTML.
                // Для простоты, при popstate мы загрузим только ту страницу, на которой пользователь был.
                // Если пользователь был на 3й странице, то покажем только 3ю.
                // Это может быть не идеальным UX. Лучше загрузить все страницы до pageFromState
                // или реализовать infinite scroll.
                // Для текущей задачи: при popstate просто перезагружаем содержимое list
                // с нужным фильтром и *первой* страницей.
                // Пользователь затем сможет долистать, нажав "Показать еще".

                performAjaxLoad(1, currentIndustryFilter, true, false); // true = isFilterChange (очищаем список), false = не добавляем в историю
            }
        });
    }
});