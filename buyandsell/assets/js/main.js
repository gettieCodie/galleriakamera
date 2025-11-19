document.addEventListener('DOMContentLoaded', function() {

    // HERO / TESTIMONIAL SWIPER (mySwiper)
    const heroSwiper = new Swiper('.mySwiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        centeredSlides: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            }
        }
    });

    // SHOW MORE / SHOW LESS BUTTON
    const btn = document.getElementById("toggleMoreBtn");
    const moreItems = document.querySelectorAll(".more-item");
    const ctaBox = document.getElementById("ctaBox");

    let expanded = false;

    btn.addEventListener("click", () => {
        expanded = !expanded;

        moreItems.forEach(item => {
            if (expanded) {
                item.classList.add("show");
            } else {
                item.classList.remove("show");
            }
        });

        // Toggle CTA
        if (expanded) {
            ctaBox.classList.add("show");
        } else {
            ctaBox.classList.remove("show");
        }

        btn.textContent = expanded ? "Show Less ▲" : "Show More ▼";
    });


    // BOOTSTRAP FORM VALIDATION
    // ------------------------------------------
    // Bootstrap validation
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {

            // Check form validity + recaptcha
            if (!form.checkValidity() || grecaptcha.getResponse() === "") {
                event.preventDefault();
                event.stopPropagation();

                if (grecaptcha.getResponse() === "") {
                    alert("Please complete the reCAPTCHA");
                }
            }

            form.classList.add('was-validated');
        }, false);
    });



    
});
