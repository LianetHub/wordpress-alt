jQuery(document).ready(function ($) {
    const galleryContainer = $('.gallery');
    const loadMoreButton = $('.gallery__more');
    const galleryItemsContainer = $('.gallery__items');

    if (loadMoreButton.length) {
        loadMoreButton.on('click', function (e) {
            e.preventDefault();

            const button = $(this);
            const container = button.closest('.gallery');

            let currentPage = parseInt(container.attr('data-page'));
            const totalPages = parseInt(container.attr('data-total-pages'));

            const postId = container.attr('data-post-id');

            if (button.hasClass('_loading')) {
                return;
            }

            currentPage++;
            button.addClass('_loading');

            $.ajax({
                url: galleryAjax.ajaxurl,
                type: 'post',
                data: {
                    action: 'load_more_gallery',
                    page: currentPage,
                    post_id: postId
                },
                success: function (response) {
                    if (response.success) {

                        galleryItemsContainer.append(response.data.html);

                        container.attr('data-page', currentPage);

                        if (currentPage >= totalPages) {
                            button.remove();
                        }

                        if (typeof Fancybox !== 'undefined') {
                            Fancybox.bind("[data-fancybox='product-gallery-group']");
                        } else if (typeof $().fancybox === 'function') {
                            $("[data-fancybox='product-gallery-group']").fancybox({});
                        }
                    } else {

                        button.remove();
                    }
                },
                complete: function () {
                    button.removeClass('_loading');
                }
            });
        });
    }
});