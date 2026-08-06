window.addEventListener("DOMContentLoaded", (event) => {
    "use strict";
    if (document.getElementsByClassName('glide_staff')) {
        document.querySelectorAll('.glide_staff').forEach(function (event) {
            new Glide(event, {
                type: 'carousel',
                startAt: 0,
                perView: 3,
                breakpoints: {
                    992: {
                        perView: 2
                    },
                    768: {
                        perView: 1
                    }
                }
            }).mount()
        })
    }
});
