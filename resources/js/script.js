window.addEventListener("DOMContentLoaded", (event) => {
    "use strict";
    new Glide('.glide_staff',{
        type: 'carousel',
        startAt: 0,
        perView: 3,
        breakpoints:{
            800: {
                perView: 2
            }
        }
    }).mount()
});
