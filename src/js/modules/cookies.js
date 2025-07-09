
export const cookies = () => {

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
};

