"use strict";



//  init Fancybox
if (typeof Fancybox !== "undefined" && Fancybox !== null) {
    Fancybox.bind("[data-fancybox]", {
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




    // event handlers
    $(document).on('click', (e) => {
        const $target = $(e.target);

        //  menu
        if ($target.closest('.header__menu-btn').length) {
            $('.header').toggleClass('open-menu');
            $('.header__location-btn').removeClass('active');
            $('.header__location-list').removeClass('active');
        }

        if ($target.is('.wrapper') && $('.header').hasClass('open-menu')) {
            $('.header').removeClass('open-menu');
        }

        // faq accordion
        if ($target.closest('.faq__item').length) {
            const $faqItem = $target.closest('.faq__item');
            $faqItem.toggleClass('active');
            $faqItem.find('.faq__item-answer').slideToggle()
        }

        // Открытие/закрытие списка локаций
        if ($target.closest('.sign-lesson__location-selected').length) {
            const $selectedBtn = $target.closest('.sign-lesson__location-selected');
            const $locationList = $selectedBtn.siblings('.sign-lesson__location-list');

            $selectedBtn.toggleClass('active');
            $locationList.toggleClass('open');
        }

        // Закрытие списка при клике вне блока
        if (!$target.closest('.sign-lesson__location').length) {
            $('.sign-lesson__location-selected').removeClass('active');
            $('.sign-lesson__location-list').removeClass('open');
        }

        // Выбор элемента из списка локаций
        if ($target.closest('.sign-lesson__location-item').length) {
            const $locationItem = $target.closest('.sign-lesson__location-item');
            const $locationWrapper = $locationItem.closest('.sign-lesson__location');
            const $locationSelected = $locationWrapper.find('.sign-lesson__location-selected');
            const $locationList = $locationWrapper.find('.sign-lesson__location-list');
            const $contentBlocks = $('.sign-lesson__content');

            // Обновление активного элемента списка
            $locationList.find('.sign-lesson__location-item').removeClass('active');
            $locationItem.addClass('active');

            // Обновление кнопки
            $locationSelected.text($locationItem.text());
            $locationSelected.removeClass('active');
            $locationList.removeClass('open');

            // Обновление контента
            $contentBlocks.removeClass('active').eq($locationItem.index()).addClass('active');
        }

        // Открытие promo__info при клике на form__tooltip
        if ($target.closest('.form__tooltip').length) {
            const $promoWrapper = $target.closest('.promo__side');
            const $promoInfo = $promoWrapper.find('.promo__info');

            $promoWrapper.addClass('show-info');
            $promoInfo.removeClass('hidden');
        }

        // Закрытие promo__info при клике на promo__info-close
        if ($target.closest('.promo__info-close').length) {
            const $promoWrapper = $target.closest('.promo__side');
            const $promoInfo = $promoWrapper.find('.promo__info');

            $promoWrapper.removeClass('show-info');
            $promoInfo.addClass('hidden');
        }

        // Закрытие success состояния отправки формы 
        if ($target.closest('.form__success-close').length) {

            const $promoWrapper = $target.closest('.form__wrapper');
            const $promoSuccess = $promoWrapper.find('.form__success-block');

            $promoWrapper.removeClass('show-success');
            $promoSuccess.addClass('hidden');
        }

        // header location
        if ($target.is('.header__location-btn')) {
            $target.toggleClass('active');
            $('.header__location-list').toggleClass('active');
        }
        if (!$target.closest('.header__location').length) {
            $('.header__location-btn').removeClass('active');
            $('.header__location-list').removeClass('active');
        }

        // whatsapp выпадающий список в header
        if ($target.is('.header__whatsapp-btn')) {
            $target.toggleClass('active');
            $('.header__whatsapp-items').toggleClass('active');
        }
        if (!$target.closest('.header__whatsapp').length) {
            $('.header__whatsapp-btn').removeClass('active');
            $('.header__whatsapp-items').removeClass('active');
        }


        if ($('body').hasClass('_touch')) {
            if ($target.closest('.menu__link').length && $target.closest('.menu__item.has-children').length) {
                e.preventDefault();
                const $menuLink = $target.closest('.menu__link');
                const $submenu = $menuLink.next('.submenu');

                const isActive = $menuLink.hasClass('active');

                $('.menu__link').removeClass('active');
                $('.submenu').removeClass('open');

                if (!isActive) {
                    $menuLink.addClass('active');
                    $submenu.addClass('open');

                    if ($(window).width() < 576) {
                        const $menuContainer = $('.menu');
                        const menuTop = $menuContainer.offset().top;
                        const menuScrollTop = $menuContainer.scrollTop();
                        const itemTop = $menuLink.offset().top;
                        const itemHeight = $menuLink.outerHeight();
                        const containerHeight = $menuContainer.height();

                        if (itemTop + itemHeight > menuTop + containerHeight || itemTop < menuTop) {
                            const scrollOffset = itemTop - menuTop + menuScrollTop;
                            $menuContainer.animate({
                                scrollTop: scrollOffset
                            }, 300);
                        }
                    }
                }
            }
        }

        if ($(window).width() < 576 && $target.is('.footer__caption')) {
            e.preventDefault();
            $target.toggleClass('active');
            $target.next().slideToggle()

        }

        if ($target.closest('.submenu__close').length) {
            $('.menu__link').removeClass('active');
            $('.submenu').removeClass('open');
        }


    });

    $(document).on('mouseenter', '.form__tooltip', function () {
        const $promoWrapper = $(this).closest('.promo__side');
        const $promoInfo = $promoWrapper.find('.promo__info');

        $promoWrapper.addClass('show-info');
        $promoInfo.removeClass('hidden');
    });

    $(document).on('mouseleave', '.promo__side', function () {
        const $promoWrapper = $(this);
        const $promoInfo = $promoWrapper.find('.promo__info');

        $promoWrapper.removeClass('show-info');
        $promoInfo.addClass('hidden');
    });

    // form submit handlers
    $(document).on('wpcf7submit', function (e) {
        var $form = $(e.target);
        var $container = $form.closest('.form__wrapper');
        var $succesBlock = $container.find('.form__success-block');
        $form.find('.wpcf7-response-output').hide();

        $succesBlock.removeClass('hidden');
        $container.addClass("show-success");
        setTimeout(function () {
            $container.removeClass("show-success");
            $succesBlock.addClass('hidden');
        }, 10000);
    });



    //  sliders
    if ($('.industries__slider').length) {
        new Swiper('.industries__slider', {
            spaceBetween: 30,
            slidesPerView: 3,
            navigation: {
                prevEl: '.industries__slider-prev',
                nextEl: '.industries__slider-next',
            },

            breakpoints: {
                // 797.98: {
                //     slidesPerView: 1,
                //     spaceBetween: 0
                // }
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
            breakpoints: {
                575.98: {
                    slidesPerView: 2,
                },
                797.98: {
                    slidesPerView: 3,

                }
            }
        })
    }

    if ($('.cases__tabs-slider').length) {
        new Swiper('.cases__tabs-slider', {
            spaceBetween: 24,
            slidesPerView: "auto",
            initialSlide: $('.cases__tab-btn.active').index(),
            observeParents: true,
            watchSlidesProgress: true,
            navigation: {
                prevEl: '.cases__tabs-prev',
                nextEl: '.cases__tabs-next',
            },
            scrollbar: {
                el: '.cases__tabs-scrollbar',
                draggable: true,
            },

        })
    }

    if ($('.cases__slider-block').length) {
        $('.cases__slider-block').each(function () {
            new Swiper($(this)[0], {
                effect: 'coverflow',
                centeredSlides: true,
                slidesPerView: 'auto',
                loop: true,
                speed: 300,
                coverflowEffect: {
                    rotate: 0,
                    stretch: 255,
                    depth: 120,
                    modifier: 3,
                    slideShadows: false,
                },
                navigation: {
                    nextEl: $(this).closest('.cases__slider').find('.swiper-button-next')[0],
                    prevEl: $(this).closest('.cases__slider').find('.swiper-button-prev')[0],
                },
            });
        });
    }

    if ($('.clients__slider').length) {
        new Swiper('.clients__slider', {
            spaceBetween: 30,
            slidesPerView: 2,
            navigation: {
                prevEl: '.clients__slider-prev',
                nextEl: '.clients__slider-next',
            },
            grid: {
                rows: 2,
                fill: 'row'
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
            spaceBetween: 30,
            slidesPerView: 1,
            navigation: {
                prevEl: '.team__slider-prev',
                nextEl: '.team__slider-next',
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
    const callback = (entries) => {
        if (entries[0].isIntersecting) {
            $('.header').removeClass('scroll');
        } else {
            $('.header').addClass('scroll');
        }
    };

    const headerObserver = new IntersectionObserver(callback);
    headerObserver.observe($('.header')[0]);


    // observer header height
    function updateHeaderHeight() {
        var headerHeight = $('.header__body').outerHeight();

        $('body').css('--header-height', headerHeight + 'px');
    }

    updateHeaderHeight();

    $(window).on('resize', function () {
        updateHeaderHeight();
    });




    // tabs
    // class Tabs {
    //     constructor(wrapper) {
    //         this.$wrapper = $(wrapper);
    //         this.$tabButtons = this.$wrapper.find('.tabs__item');
    //         this.$tabContents = this.$wrapper.find('.tab-content');
    //         this.init();
    //     }

    //     init() {
    //         this.$tabButtons.each((index, button) => {
    //             $(button).on('click', () => this.activateTab(index));
    //         });
    //     }

    //     activateTab(index) {
    //         this.$tabButtons.removeClass('active');
    //         this.$tabContents.removeClass('active');

    //         this.$tabButtons.eq(index).addClass('active');
    //         this.$tabContents.eq(index).addClass('active');
    //     }
    // }

    // $('.tabs-wrapper').each((_, wrapper) => new Tabs(wrapper));



    // Custom Select

    class CustomSelect {

        static openDropdown = null

        constructor(selectElement) {
            this.$select = $(selectElement);
            this.defaultText = this.$select.find('option:selected').text();
            this.selectName = this.$select.attr('name');
            this.$options = this.$select.find('option');
            this.icon = this.$select.data('icon');
            this.title = this.$select.data('title');
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
            const isDisabled = this.$select.is(':disabled')

            let buttonTemplate = '';

            if (this.icon) {
                buttonTemplate = `
                    <button type="button" class="dropdown__button icon-chevron" 
                        aria-expanded="false" 
                        aria-haspopup="true" 
                        ${isDisabled ? 'disabled' : ''}>
                        <span class="dropdown__button-icon ${this.icon}"></span>
                        <span class="dropdown__button-text">${this.defaultText}</span>
                    </button>
                `;
            } else if (this.title) {

                buttonTemplate = `
                    <button type="button" class="dropdown__button icon-chevron" 
                        aria-expanded="false" 
                        aria-haspopup="true" 
                        ${isDisabled ? 'disabled' : ''}>
                        <span class="dropdown__button-column">
                            <span class="dropdown__button-caption">${this.title}</span>
                            <span class="dropdown__button-text">${this.defaultText}</span>
                        </span>
                    </button>
                `;
            } else {
                buttonTemplate = `
                    <button type="button" class="dropdown__button icon-chevron" 
                        aria-expanded="false" 
                        aria-haspopup="true" 
                        ${isDisabled ? 'disabled' : ''}>
                        <span class="dropdown__button-text">${this.defaultText}</span>
                    </button>
                `;
            }

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

            $(document).on('click', () => this.closeDropdown());
            $(document).on('keydown', (event) => {
                if (event.key === 'Escape') this.closeDropdown();
            });

            this.$select.closest('form').on('reset', () => this.restoreInitialState());

            const observerDisabled = new MutationObserver(() => {
                const isSelectDisabled = this.$select.is(':disabled');
                const $button = this.$dropdown.find('.dropdown__button');

                if (isSelectDisabled) {
                    $button.prop('disabled', true);
                } else {
                    $button.prop('disabled', false);
                }
            });

            observerDisabled.observe(this.$select[0], {
                attributes: true,
                attributeFilter: ['disabled']
            });

            const observerSelected = new MutationObserver((mutations) => {
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

                    if (mutation.type === 'attributes' && mutation.attributeName === 'selected') {
                        this.syncSelectedOption();
                    }
                });
            });

            observerSelected.observe(this.$select[0], {
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

            this.$dropdown.find('.dropdown__list-item').removeClass('selected').attr('aria-checked', 'false');
            $item.addClass('selected').attr('aria-checked', 'true');

            this.$dropdown.find('.dropdown__button').addClass('selected');
            this.$dropdown.find('.dropdown__button-text').text(text);
            this.$select.val(value).trigger('change');
            this.closeDropdown();
        }

        restoreInitialState() {
            const state = this.initialState;
            this.$select.val(state.selectedValue).trigger('change');
            this.$dropdown.find('.dropdown__list-item').removeClass('selected').attr('aria-checked', 'false');
            this.$dropdown
                .find(`.dropdown__list-item[data-value="${state.selectedValue}"]`)
                .addClass('selected')
                .attr('aria-checked', 'true');
            this.$dropdown.find('.dropdown__button-text').text(state.selectedText);
            this.$dropdown.find('.dropdown__button').removeClass('selected');
        }

        syncSelectedOption() {
            const $selectedOption = this.$select.find('option:selected');
            const selectedValue = $selectedOption.val();
            const selectedText = $selectedOption.text();


            this.$dropdown.find('.dropdown__list-item').removeClass('selected').attr('aria-checked', 'false');
            this.$dropdown
                .find(`.dropdown__list-item[data-value="${selectedValue}"]`)
                .addClass('selected')
                .attr('aria-checked', 'true');
            this.$dropdown.find('.dropdown__button-text').text(selectedText);
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
            formattedInputValue = '+' + inputNumbersValue.substring(0, 16);
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


})




