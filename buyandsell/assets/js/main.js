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

    // ===== Redirect all buttons to signup.php temporarily, except the Show More button =====
    const allButtons = document.querySelectorAll('button');
    allButtons.forEach(button => {
        // Skip the button if it has id="toggleMoreBtn"
        if (button.id !== 'toggleMoreBtn') {
            button.addEventListener('click', () => {
                window.location.href = 'signup.php';
            });
        }
    });

    // Optional: also redirect CTA links if needed
    const ctaLinks = document.querySelectorAll('a.cta-btn');
    ctaLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault(); // prevent default link behavior
            window.location.href = 'signup.php';
        });
    });

});
