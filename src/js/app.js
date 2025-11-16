"use strict";

//  init Fancybox
if (typeof Fancybox !== "undefined" && Fancybox !== null) {
    Fancybox.bind("[data-fancybox]", {
        dragToClose: false,
        closeButton: false,
        on: {
            "close": () => {
                $('#manufacturer-logo-input').val('');
            }
        }
    });

    Fancybox.bind('[data-gallery="product"]', {
        type: "image",
        groupAll: true,
        dragToClose: false,
        closeButton: false
    });
}



$(function () {




    // detect user OS
    const isMobile = {
        Android: () => /Android/i.test(navigator.userAgent),
        BlackBerry: () => /BlackBerry/i.test(navigator.userAgent),
        iOS: () => /iPhone|iPad|iPod/i.test(navigator.userAgent),
        Opera: () => /Opera Mini/i.test(navigator.userAgent),
        Windows: () => /IEMobile/i.test(navigator.userAgent),
        any: function () {
            return this.Android() || this.BlackBerry() || this.iOS() || this.Opera() || this.Windows();
        },
    };

    function getNavigator() {
        if (isMobile.any() || $(window).width() < 992) {
            $('body').removeClass('_pc').addClass('_touch');
        } else {
            $('body').removeClass('_touch').addClass('_pc');
        }
    }

    getNavigator();

    $(window).on('resize', () => {
        getNavigator();
    });



    let resizeHandler = null;

    // event handlers
    $(document).on('click', (e) => {
        const $target = $(e.target);


        //  menu
        if ($target.closest('.header__menu-toggler').length) {
            $('.header').toggleClass('open-menu');
            $('body').toggleClass('lock-menu');

        }

        // faq accordion
        if ($target.closest('.faq__item').length) {
            const $faqItem = $target.closest('.faq__item');
            $faqItem.toggleClass('active');
            $faqItem.find('.faq__item-answer').slideToggle()
        }

        // Закрытие success состояния отправки формы 
        if ($target.closest('.form__success-close').length) {

            const $promoWrapper = $target.closest('.form__wrapper');
            const $promoSuccess = $promoWrapper.find('.form__success-block');

            $promoWrapper.removeClass('show-success');
            $promoSuccess.addClass('hidden');
        }

        // Читать полностью 
        if ($target.is('.seo-text-block__more')) {
            $target.toggleClass('active');
            $target.prev().toggleClass('full');

            if ($target.hasClass('active')) {
                $target.text('Свернуть');
            } else {
                $target.text('Читать полностью');
            }

        }

        if ($target.is('.products__sidebar .wp-block-heading, .products__sidebar .filter-title')) {
            $target.toggleClass('active');
            $target.next().slideToggle()
        }

        if ($target.closest('.products__filters-caption').length) {
            $target.closest('.products__filters-caption').toggleClass('active');
            $target.closest('.products__filters-caption').next().slideToggle()
        }

        if (($target.closest('.menu__arrow').length || ($target.closest('.menu__link').length && $target.closest('.menu-item-has-children').length)) && $target.closest('.menu__item.menu-parent').length) {
            e.preventDefault();
            const $menuItem = $target.closest('.menu__item');
            const $submenu = $menuItem.find('.submenu');

            const isActive = $menuItem.hasClass('active');


            $('.menu__item').removeClass('active');
            $('.submenu').removeClass('open');
            $('.menu__body').removeClass('active').css('min-height', '');


            if (window.currentResizeHandler) {
                $(window).off('resize', window.currentResizeHandler);
                window.currentResizeHandler = null;
            }

            if (!isActive) {
                $menuItem.addClass('active');
                $submenu.addClass('open');

                const submenuHeight = $submenu.outerHeight();
                const $menuBody = $('.menu__body');

                $menuBody
                    .addClass('active')
                    .css('min-height', submenuHeight);

                window.currentResizeHandler = () => {
                    const updatedHeight = $submenu.outerHeight();
                    $menuBody.css('min-height', updatedHeight);
                };
                $(window).on('resize', window.currentResizeHandler);
            }
        }

        if ($target.closest('.submenu__close').length) {
            const $menuBody = $('.menu__body');

            $('.menu__item').removeClass('active');
            $('.submenu').removeClass('open');

            $menuBody
                .removeClass('active')
                .css('min-height', '');

            if (resizeHandler) {
                $(window).off('resize', resizeHandler);
                resizeHandler = null;
            }
        }

        // Клик по десктопному табу
        if ($target.is('.product-stats__tab')) {
            const tabId = $target.data('tab');
            synchronizeTabs(tabId);
        }

        // Клик по мобильному табу
        if ($target.is('.product-stats__mobile-tab')) {
            const tabId = $target.data('tab');
            synchronizeTabs(tabId, true);
        }

        // Добавляет в модалку название лого
        if ($target.closest('[data-manufacturer-name]').length) {
            let manufacturerName = $target.closest('[data-manufacturer-name]').data('manufacturer-name');
            $('#manufacturer-logo-input').val(manufacturerName);
        }


    });

    $(document).on('close.fb', function (event, fancybox) {
        if (fancybox.$container && fancybox.$container.attr('id') === 'manufactures-order') {
            $('#manufacturer-logo-input').val('');
        }
    });

    function getActiveTabId() {
        const $activeDesktopTab = $('.product-stats__tab.active');
        if ($activeDesktopTab.length) {
            return $activeDesktopTab.data('tab');
        }
        const $activeMobileTab = $('.product-stats__mobile-tab.active');
        if ($activeMobileTab.length) {
            return $activeMobileTab.data('tab');
        }
        return null;
    }

    function synchronizeTabs(clickedTabId, isMobileClick = false) {
        $('.product-stats__tab, .product-stats__mobile-tab').removeClass('active');
        $('.product-stats__block').removeClass('active');

        const $targetDesktopTab = $(`.product-stats__tab[data-tab="${clickedTabId}"]`);
        const $targetMobileTab = $(`.product-stats__mobile-tab[data-tab="${clickedTabId}"]`);
        const $targetContentBlock = $(`.product-stats__block[data-tab-content="${clickedTabId}"]`);
        const $targetInnerContent = $targetContentBlock.find('.product-stats__block-content');

        $targetDesktopTab.addClass('active');
        $targetContentBlock.addClass('active');
        $targetMobileTab.addClass('active');

        if (window.innerWidth <= 767.98) {
            $('.product-stats__block-content').not($targetInnerContent).slideUp(400);

            if (isMobileClick && $targetInnerContent.is(':visible')) {
                $targetMobileTab.removeClass('active');
                $targetInnerContent.slideUp(400);
            } else {
                $targetInnerContent.slideDown(400);
            }

        } else {
            $('.product-stats__block-content').hide();
            $targetInnerContent.show();
        }
    }

    const initialActiveTabId = getActiveTabId();
    if (initialActiveTabId) {
        synchronizeTabs(initialActiveTabId);
    } else {
        if (window.innerWidth <= 767.98) {
            $('.product-stats__block-content').slideUp(0);
        } else {
            $('.product-stats__block-content').hide();
        }
    }

    $(window).on('resize', function () {
        const activeTabId = getActiveTabId();

        if (!activeTabId) {
            if (window.innerWidth <= 767.98) {
                $('.product-stats__block-content').slideUp(0);
            } else {
                $('.product-stats__block-content').hide();
            }
            return;
        }

        const $activeContentBlock = $(`.product-stats__block[data-tab-content="${activeTabId}"]`);
        const $activeInnerContent = $activeContentBlock.find('.product-stats__block-content');

        if (window.innerWidth <= 767.98) {
            $('.product-stats__block-content').not($activeInnerContent).slideUp(0);

            if ($(`.product-stats__mobile-tab[data-tab="${activeTabId}"]`).hasClass('active')) {
                $activeInnerContent.slideDown(0);
            } else {
                $activeInnerContent.slideUp(0);
            }

        } else {
            $('.product-stats__block-content').hide();
            if ($activeContentBlock.hasClass('active')) {
                $activeInnerContent.show();
            }
        }
    }).trigger('resize');



    const $submenuItems = $('.submenu__item');
    if ($submenuItems.length > 0) {

        const $descriptionBlocks = $('.submenu__description-block');

        $submenuItems.on('mouseenter', function () {
            const index = $(this).index();
            $(this).addClass('active').siblings().removeClass('active');
            $descriptionBlocks.removeClass('active');
            $descriptionBlocks.eq(index).addClass('active');
        });

        // $submenuItems.on('mouseleave', function () {
        //     $descriptionBlocks.removeClass('active');
        //     $(this).removeClass('active');
        // });
    }


    // filters
    function toggleCheckedFilterBlocks() {
        $('.wp-block-woocommerce-product-filter-checkbox-list').each(function () {
            const $thisFilterBlock = $(this);
            const hasCheckedInputs = $thisFilterBlock.find('.wc-block-product-filter-checkbox-list__input:checked').length > 0;

            if (hasCheckedInputs) {
                $thisFilterBlock.slideDown(0);
            }

        });
    }

    toggleCheckedFilterBlocks();




    // preview uploads in forms
    function createFilePreview($fileInput) {
        const file = $fileInput[0].files[0];
        const $parentLabel = $fileInput.closest('.form__file');

        if (file) {
            const fileName = file.name;
            $parentLabel.addClass('hidden');

            let $previewContainer = $parentLabel.next('.form__file-preview');

            if ($previewContainer.length === 0) {
                $previewContainer = $('<div class="form__file-preview"></div>');
                const $fileText = $('<span class="form__file-text"></span>');
                const $removeButton = $('<button type="button" class="form__file-remove icon-cross" title="Удалить файл"></button>');

                $previewContainer.append($fileText).append($removeButton);
                $parentLabel.after($previewContainer);
            }

            $previewContainer.find('.form__file-text').text(fileName);
            $previewContainer.removeClass('hidden');

        } else {
            $parentLabel.removeClass('hidden');
            $parentLabel.next('.form__file-preview').remove();
        }
    }

    $(document).on('change', '.form__file-input', function () {
        createFilePreview($(this));
    });

    $(document).on('click', '.form__file-remove', function () {
        const $previewContainer = $(this).closest('.form__file-preview');
        const $fileInput = $previewContainer.prev('.form__file').find('.form__file-input');

        $fileInput.val('');

        $previewContainer.prev('.form__file').removeClass('hidden');
        $previewContainer.remove();
    });

    $(document).on('wpcf7mailsent wpcf7reset', function (event) {
        $('.form__file-preview').each(function () {
            const $previewContainer = $(this);
            const $fileInput = $previewContainer.prev('.form__file').find('.form__file-input');

            $fileInput.val('');
            $previewContainer.prev('.form__file').removeClass('hidden');
            $previewContainer.remove();
        });
    });


    //  sliders
    if ($('.industries__slider').length) {
        new Swiper('.industries__slider', {
            spaceBetween: 8,
            slidesPerView: 1,
            loop: true,
            navigation: {
                prevEl: '.industries__slider-prev',
                nextEl: '.industries__slider-next',
            },
            breakpoints: {
                575.98: {
                    spaceBetween: 20,
                    slidesPerView: 2,
                },
                991.98: {
                    spaceBetween: 30,
                    slidesPerView: 3,
                }
            }
        })
    }

    if ($('.catalog__slider').length) {
        getMobileSlider('.catalog__slider', {
            spaceBetween: 30,
            slidesPerView: 1,
            navigation: {
                prevEl: '.catalog__slider-prev',
                nextEl: '.catalog__slider-next',
            },
        })
    }

    if ($('.cases__tabs-slider').length) {
        new Swiper('.cases__tabs-slider', {

            spaceBetween: 16,
            slidesPerView: "auto",
            initialSlide: $('.cases__tab-btn.active').index(),
            observeParents: true,
            watchSlidesProgress: true,
            slideToClickedSlide: true,
            navigation: {
                prevEl: '.cases__tabs-prev',
                nextEl: '.cases__tabs-next',
            },
            scrollbar: {
                el: '.cases__tabs-scrollbar',
                draggable: true,
            },
            breakpoints: {
                575.98: {
                    spaceBetween: 24,
                },
            }

        })
    }

    if ($('.cases__slider-block').length) {
        $('.cases__slider-block').each(function () {
            const $thisSlider = $(this);
            const totalSlides = $thisSlider.find('.swiper-slide').length;
            const enableLoop = totalSlides > 2;

            new Swiper($thisSlider[0], {

                slidesPerView: 'auto',
                centeredSlides: true,
                loop: enableLoop,
                speed: 300,
                navigation: {
                    nextEl: $thisSlider.closest('.cases__slider').find('.swiper-button-next')[0],
                    prevEl: $thisSlider.closest('.cases__slider').find('.swiper-button-prev')[0],
                },
                breakpoints: {
                    767.98: {
                        effect: 'coverflow',
                        coverflowEffect: {
                            rotate: 0,
                            stretch: 255,
                            depth: 120,
                            modifier: 2.75,
                            slideShadows: false,
                        },
                    },
                    1439.98: {
                        coverflowEffect: {
                            modifier: 3,
                        },
                    }
                },
            });
        });
    }

    if ($('.clients__slider').length) {
        $('.clients__slider').each(function () {
            const $thisSlider = $(this);
            const $wrapper = $(this).closest('.clients');
            const $prevBtn = $wrapper.find('.clients__slider-prev');
            const $nextBtn = $wrapper.find('.clients__slider-next');

            new Swiper($thisSlider[0], {
                spaceBetween: 8,
                slidesPerView: 2,
                navigation: {
                    prevEl: $prevBtn[0],
                    nextEl: $nextBtn[0],
                },
                grid: {
                    rows: 2,
                    fill: 'row'
                },
                breakpoints: {
                    991.98: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                        grid: {
                            rows: 2,
                            fill: 'row'
                        },
                    },
                    1199.98: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                        grid: {
                            rows: 2,
                            fill: 'row'
                        },
                    }
                }
            })
        })
    }

    if ($('.reviews__slider').length) {
        new Swiper('.reviews__slider', {
            spaceBetween: 30,
            slidesPerView: 1,
            navigation: {
                prevEl: '.reviews__slider-prev',
                nextEl: '.reviews__slider-next',
            },
            breakpoints: {
                767.98: {
                    slidesPerView: 2,
                },
                991.98: {
                    slidesPerView: 3,
                },
                1199.98: {
                    slidesPerView: 4,
                }
            }
        })
    }

    if ($('.team__slider').length) {
        new Swiper('.team__slider', {
            spaceBetween: 8,
            slidesPerView: 2,
            navigation: {
                prevEl: '.team__slider-prev',
                nextEl: '.team__slider-next',
            },
            breakpoints: {
                991.98: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1199.98: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                }
            }
        })
    }

    if ($('.blog__slider').length) {
        new Swiper('.blog__slider', {
            spaceBetween: 30,
            slidesPerView: 1,
            watchOverflow: true,
            navigation: {
                prevEl: '.blog__slider-prev',
                nextEl: '.blog__slider-next',
            },
            breakpoints: {
                767.98: {
                    slidesPerView: 2,
                },
                991.98: {
                    slidesPerView: 3,
                }
            }
        })
    }

    if ($('.home-gallery-block__slider').length) {
        new Swiper('.home-gallery-block__slider', {
            spaceBetween: 30,
            slidesPerView: 1,
            watchOverflow: true,
            navigation: {
                prevEl: '.home-gallery-block__slider-prev',
                nextEl: '.home-gallery-block__slider-next',
            },
            breakpoints: {
                767.98: {
                    slidesPerView: 2,
                },
                991.98: {
                    slidesPerView: 3,
                }
            }
        })
    }

    if ($('.сertificates__slider').length) {
        new Swiper('.сertificates__slider', {
            spaceBetween: 30,
            slidesPerView: 1,
            navigation: {
                prevEl: '.сertificates__slider-prev',
                nextEl: '.сertificates__slider-next',
            },
            breakpoints: {
                767.98: {
                    slidesPerView: 2,
                },
                991.98: {
                    slidesPerView: 3,
                },
                1199.98: {
                    slidesPerView: 4,
                }
            }
        })
    }

    if ($('.company__gallery-slider').length) {
        new Swiper('.company__gallery-slider', {
            slidesPerView: 1,
            navigation: {
                prevEl: '.company__gallery-prev',
                nextEl: '.company__gallery-next',
            },
        })
    }

    if ($('.recommendation__body').length) {
        $('.recommendation__body').each((index, element) => {

            const slider = $(element).find('.recommendation__slider')[0];
            const prevEl = $(element).find('.recommendation__prev')[0];
            const nextEl = $(element).find('.recommendation__next')[0];

            new Swiper(slider, {
                spaceBetween: 30,
                slidesPerView: 1,
                navigation: {
                    prevEl: prevEl,
                    nextEl: nextEl,
                },
                breakpoints: {
                    767.98: {
                        slidesPerView: 2,
                    },
                    991.98: {
                        slidesPerView: 3,
                    },
                    1199.98: {
                        slidesPerView: 4,
                    }
                }
            })
        })
    }

    if ($('.product-card__images').length) {
        const mainSliderEl = $('.product-card__slider')[0];
        const thumbsSliderEl = $('.product-card__thumbs')[0];

        const thumbsSlider = new Swiper(thumbsSliderEl, {
            spaceBetween: 15,
            slidesPerView: 3,
            watchSlidesProgress: true,
            breakpoints: {
                1199.98: {
                    slidesPerView: 4,
                }
            }

        });

        const mainSlider = new Swiper(mainSliderEl, {
            navigation: {
                nextEl: '.product-card__next',
                prevEl: '.product-card__prev'
            },
            thumbs: {
                swiper: thumbsSlider
            },

        });
    }

    function getMobileSlider(sliderName, options) {

        let init = false;
        let swiper = null;

        function getSwiper() {
            if (window.innerWidth <= 767.98) {
                if (!init) {
                    init = true;
                    swiper = new Swiper(sliderName, options);
                }
            } else if (init) {
                swiper.destroy();
                swiper = null;
                init = false;
            }
        }
        getSwiper();
        window.addEventListener("resize", getSwiper);
    }


    // observer header scroll
    let lastScrollTop = 0;

    function checkScroll() {
        const headerTopHeight = $('.header__top').outerHeight() || 0;
        const headerBodyHeight = $('.header__body').outerHeight() || 0;
        const scrollThreshold = headerTopHeight + headerBodyHeight;

        const currentScroll = $(window).scrollTop();

        if (currentScroll > lastScrollTop) {

            if (currentScroll > scrollThreshold) {
                $('.header').addClass('scroll');
            }
        } else {
            if (currentScroll < scrollThreshold) {
                $('.header').removeClass('scroll');
            }

        }

        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    }


    checkScroll();

    $(window).on('scroll', checkScroll);
    $(window).on('resize', checkScroll);




    // search focus animation
    if ($('.header__search .proinput .orig').length) {
        const $searchForm = $('.header__search');
        const $searchInput = $('.header__search .proinput .orig');

        $searchInput.on('focus', () => {
            console.log($searchInput, 'focus');

            $searchForm.addClass('focus');
        });

        $searchInput.on('blur', () => {
            $searchForm.removeClass('focus');
        });
    }


    // tabs
    class Tabs {
        constructor(wrapper) {
            this.$wrapper = $(wrapper);
            this.$tabButtons = this.$wrapper.find('.tabs__item');
            this.$tabContents = this.$wrapper.find('.tab-content');
            this.init();
        }

        init() {
            this.$tabButtons.each((index, button) => {
                $(button).on('click', () => this.activateTab(index));
            });
        }

        activateTab(index) {
            this.$tabButtons.removeClass('active');
            this.$tabContents.removeClass('active');

            this.$tabButtons.eq(index).addClass('active');
            this.$tabContents.eq(index).addClass('active');
        }
    }

    $('.tabs-wrapper').each((_, wrapper) => new Tabs(wrapper));



    // Custom Select

    class CustomSelect {
        static openDropdown = null;

        constructor(selectElement) {
            this.$select = $(selectElement);
            this.defaultText = this.$select.find('option:selected').text();
            this.selectName = this.$select.attr('name');
            this.$options = this.$select.find('option');
            this.placeholder = this.$select.data('placeholder') || this.defaultText; // Использование data-placeholder
            this.$dropdown = null;
            this.initialState = {};
            this.init();
        }

        init() {
            if (!this.$select.length) return;
            this.saveInitialState();
            this.$select.addClass('hidden');
            this.renderDropdown();
            this.setupEvents();
        }

        saveInitialState() {
            const $selectedOption = this.$select.find('option:selected');
            this.initialState = {
                selectedText: $selectedOption.text(),
                selectedValue: $selectedOption.val(),
            };
        }

        renderDropdown() {
            const isDisabled = this.$select.is(':disabled');

            const buttonText = this.$select.find('option:selected').val() === "" ? this.placeholder : this.defaultText;

            const buttonTemplate = `
            <button type="button" class="dropdown__button icon-chevron-down"
                aria-expanded="false"
                aria-haspopup="true"
                ${isDisabled ? 'disabled' : ''}>
                <span class="dropdown__button-text">${buttonText}</span>
            </button>
        `;

            this.$dropdown = $(`
            <div class="dropdown">
                ${buttonTemplate}
                <div class="dropdown__body" aria-hidden="true">
                    <ul class="dropdown__list" role="listbox"></ul>
                </div>
            </div>
        `);

            const $list = this.$dropdown.find('.dropdown__list');
            this.$options.each((index, option) => {
                const $option = $(option);
                const value = $option.attr('value');
                const text = $option.text();
                const isSelected = $option.is(':selected');
                const isDisabled = $option.is(':disabled');

                $list.append(`
                <li role="option"
                    data-value="${value}"
                    aria-checked="${isSelected}"
                    class="dropdown__list-item${isSelected ? ' selected' : ''}${isDisabled ? ' disabled' : ''}"
                    ${isDisabled ? 'aria-disabled="true"' : ''}>
                    ${text}
                </li>
            `);
            });

            this.$select.after(this.$dropdown);
        }

        setupEvents() {
            this.$dropdown.find('.dropdown__button').on('click', (event) => {
                event.stopPropagation();
                const isOpen = this.$dropdown.hasClass('visible');
                this.toggleDropdown(!isOpen);
            });

            this.$dropdown.find('.dropdown__list-item').on('click', (event) => {
                event.stopPropagation();
                const $item = $(event.currentTarget);

                if (!$item.hasClass('disabled')) {
                    this.selectOption($item);
                }
            });

            $(document).on('click', (event) => {
                if (!this.$dropdown[0].contains(event.target)) {
                    this.closeDropdown();
                }
            });
            $(document).on('keydown', (event) => {
                if (event.key === 'Escape') this.closeDropdown();
            });

            this.$select.closest('form').on('reset', () => this.restoreInitialState());

            const observerDisabled = new MutationObserver(() => {
                const isSelectDisabled = this.$select.is(':disabled');
                const $button = this.$dropdown.find('.dropdown__button');

                $button.prop('disabled', isSelectDisabled);
            });

            observerDisabled.observe(this.$select[0], {
                attributes: true,
                attributeFilter: ['disabled']
            });

            const observerOptions = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {

                    if (mutation.type === 'attributes' && mutation.attributeName === 'disabled') {
                        const $option = $(mutation.target);
                        const value = $option.attr('value');
                        const isDisabled = $option.is(':disabled');
                        const $item = this.$dropdown.find(`.dropdown__list-item[data-value="${value}"]`);

                        $item.toggleClass('disabled', isDisabled);
                        if (isDisabled) {
                            $item.attr('aria-disabled', 'true');
                        } else {
                            $item.removeAttr('aria-disabled');
                        }
                    }
                    if ((mutation.type === 'attributes' && mutation.attributeName === 'selected') || mutation.type === 'childList') {
                        this.syncSelectedOption();
                    }
                });
            });

            observerOptions.observe(this.$select[0], {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['selected', 'disabled']
            });
        }

        toggleDropdown(isOpen) {
            if (isOpen && CustomSelect.openDropdown && CustomSelect.openDropdown !== this) {
                CustomSelect.openDropdown.closeDropdown();
            }

            const $body = this.$dropdown.find('.dropdown__body');
            const $list = this.$dropdown.find('.dropdown__list');

            const hasScroll = $list[0].scrollHeight > $list[0].clientHeight;

            this.$dropdown.toggleClass('visible', isOpen);
            this.$dropdown.find('.dropdown__button').attr('aria-expanded', isOpen);
            $body.attr('aria-hidden', !isOpen);

            if (isOpen) {
                CustomSelect.openDropdown = this;
                this.$dropdown.removeClass('dropdown-top');
                const dropdownRect = $body[0].getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                if (dropdownRect.bottom > viewportHeight) {
                    this.$dropdown.addClass('dropdown-top');
                }
                $list.toggleClass('has-scroll', hasScroll);
            } else {
                if (CustomSelect.openDropdown === this) {
                    CustomSelect.openDropdown = null;
                }
            }
        }

        closeDropdown() {
            this.toggleDropdown(false);
        }

        selectOption($item) {
            const value = $item.data('value');
            const text = $item.text();


            this.$select.val(value);

            this.$dropdown.find('.dropdown__list-item').removeClass('selected').attr('aria-checked', 'false');
            $item.addClass('selected').attr('aria-checked', 'true');

            this.$dropdown.find('.dropdown__button-text').text(text);
            this.$dropdown.find('.dropdown__button').addClass('selected');

            this.$select.trigger('change');
            this.closeDropdown();
        }

        restoreInitialState() {
            const state = this.initialState;
            this.$select.val(state.selectedValue).trigger('change');

        }

        syncSelectedOption() {
            const $selectedOption = this.$select.find('option:selected');
            const selectedValue = $selectedOption.val();
            const selectedText = $selectedOption.text();


            const $buttonTextElement = this.$dropdown.find('.dropdown__button-text');
            if (selectedValue === "") {
                $buttonTextElement.text(this.placeholder);
                this.$dropdown.find('.dropdown__button').removeClass('selected');
            } else {
                $buttonTextElement.text(selectedText);
                this.$dropdown.find('.dropdown__button').addClass('selected');
            }


            this.$dropdown.find('.dropdown__list-item').removeClass('selected').attr('aria-checked', 'false');
            const $selectedListItem = this.$dropdown.find(`.dropdown__list-item[data-value="${selectedValue}"]`);
            if ($selectedListItem.length) {
                $selectedListItem.addClass('selected').attr('aria-checked', 'true');
            }
        }
    }

    $('.select').each((index, element) => {
        new CustomSelect(element);
    });


    // input tel mask
    var $phoneInputs = $('input[type="tel"]');

    function getInputNumbersValue(input) {
        return input.val().replace(/\D/g, '');
    }

    function onPhonePaste(e) {
        var $input = $(e.target),
            inputNumbersValue = getInputNumbersValue($input),
            pasted = e.originalEvent.clipboardData || window.clipboardData;

        if (pasted) {
            var pastedText = pasted.getData('Text');
            if (/\D/g.test(pastedText)) {
                $input.val(inputNumbersValue);
                e.preventDefault();
            }
        }
    }

    function onPhoneInput(e) {
        var $input = $(e.target),
            inputNumbersValue = getInputNumbersValue($input),
            selectionStart = e.target.selectionStart,
            formattedInputValue = '';

        if (!inputNumbersValue) {
            $input.val('');
            return;
        }

        if ($input.val().length !== selectionStart) {
            if (e.originalEvent && e.originalEvent.data && /\D/g.test(e.originalEvent.data)) {
                $input.val(inputNumbersValue);
            }
            return;
        }

        if (['7', '8', '9'].includes(inputNumbersValue[0])) {
            if (inputNumbersValue[0] === '9') inputNumbersValue = '7' + inputNumbersValue;
            var firstSymbols = (inputNumbersValue[0] === '8') ? '8' : '+7';
            formattedInputValue = firstSymbols + ' ';

            if (inputNumbersValue.length > 1) {
                formattedInputValue += '(' + inputNumbersValue.substring(1, 4);
            }
            if (inputNumbersValue.length >= 5) {
                formattedInputValue += ') ' + inputNumbersValue.substring(4, 7);
            }
            if (inputNumbersValue.length >= 8) {
                formattedInputValue += '-' + inputNumbersValue.substring(7, 9);
            }
            if (inputNumbersValue.length >= 10) {
                formattedInputValue += '-' + inputNumbersValue.substring(9, 11);
            }
        } else {
            formattedInputValue = '+' + inputNumbersValue.substring(0, 12);
        }

        $input.val(formattedInputValue);
    }

    function onPhoneKeyDown(e) {
        var $input = $(e.target),
            inputValue = $input.val().replace(/\D/g, '');

        if (e.keyCode === 8 && inputValue.length === 1) {
            $input.val('');
        }
    }

    $phoneInputs.on('keydown', onPhoneKeyDown);
    $phoneInputs.on('input', onPhoneInput);
    $phoneInputs.on('paste', onPhonePaste);


    // cookies

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    function setCookie(name, value, options) {
        options = options || {};
        var expires = options.expires;

        if (typeof expires == "number" && expires) {
            var d = new Date();
            d.setTime(d.getTime() + expires * 1000);
            options.expires = d;
        }
        if (expires && expires.toUTCString) {
            options.expires = expires.toUTCString();
        }
        value = encodeURIComponent(value);
        var updatedCookie = name + "=" + value;

        for (var propName in options) {
            updatedCookie += "; " + propName;
            var propValue = options[propName];
            if (propValue !== true) {
                updatedCookie += "=" + propValue;
            }
        }
        document.cookie = updatedCookie;
    }

    const cookieConsentName = 'user_has_consented_cookies';

    const $cookieBlock = $('#cookie-block');
    const $acceptButton = $cookieBlock.find('.cookie__btn');

    if ($cookieBlock.length && (typeof getCookie(cookieConsentName) === 'undefined' || getCookie(cookieConsentName) != 'true')) {
        $cookieBlock.fadeIn('slow');

        $acceptButton.on('click', function () {
            setCookie(cookieConsentName, 'true', { expires: 365 * 24 * 60 * 60, path: '/' });
            $cookieBlock.fadeOut('slow', function () {
                $(this).remove();
            });
        });
    } else if ($cookieBlock.length && getCookie(cookieConsentName) === 'true') {
        $cookieBlock.fadeOut(0, function () {
            $(this).remove();
        });
    }


    // article observer progress


    const $articles = $('.article__seo-block');


    $articles.each(function () {
        const $article = $(this);

        const $sidebar = $article.closest('.article__content').find('.article__sidebar');
        const $navbar = $sidebar.find('.article__navbar-list');



        if ($sidebar.length === 0) {
            return true;
        }

        const $navbarLinks = $sidebar.find('.article__navbar-item a');
        const headings = [];


        $navbarLinks.each(function () {
            const targetId = $(this).attr('href');
            const $heading = $article.find(targetId);
            if ($heading.length) {
                headings.push({
                    id: targetId.substring(1),
                    $element: $heading,
                    $navLink: $(this)
                });
            }
        });


        if (headings.length <= 1) {
            return true;
        }

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -70% 0px',
            threshold: 0
        };

        const headingObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                const targetId = entry.target.id;
                const $currentNavLink = $navbarLinks.filter(`[href="#${targetId}"]`);

                if (entry.isIntersecting) {
                    $navbarLinks.removeClass('active');
                    $currentNavLink.addClass('active');
                } else {
                    if (entry.boundingClientRect.top < 0) {
                        const currentIndex = headings.findIndex(h => h.id === targetId);
                        if (currentIndex + 1 < headings.length) {
                            const $nextHeading = headings[currentIndex + 1].$element;
                            const nextHeadingRect = $nextHeading[0].getBoundingClientRect();
                            if (nextHeadingRect.top < $(window).height() * 0.3) {
                                $currentNavLink.removeClass('active');
                            }
                        }
                    }
                }
            });
        }, observerOptions);


        headings.forEach(heading => {
            headingObserver.observe(heading.$element[0]);
        });


        $(window).on('scroll', function () {

            const articleTop = $article.offset().top;
            const articleHeight = $article.outerHeight();
            const windowScrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();

            const scrollStart = articleTop - windowHeight;
            const scrollEnd = articleTop + articleHeight - (windowHeight * 0.3);

            let percentage = 0;
            if (windowScrollTop > scrollStart) {
                percentage = ((windowScrollTop - scrollStart) / (scrollEnd - scrollStart)) * 100;
                percentage = Math.min(100, Math.max(0, percentage));
            }

            $navbar.css('--progress-percent', percentage.toFixed(2) + '%');
        }).trigger('scroll');
    });

})




