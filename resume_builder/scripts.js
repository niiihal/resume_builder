/*for slider*/

document.addEventListener("DOMContentLoaded", function () {
    const sliderWrapper = document.querySelector(".slider-wrapper");
    const slides = document.querySelectorAll(".slide");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");

    let index = 0;
    const totalSlides = slides.length;

    function updateSlider() {
        sliderWrapper.style.transform = `translateX(-${index * 100}%)`;
    }

    nextBtn.addEventListener("click", function () {
        index = (index + 1) % totalSlides;
        updateSlider();
    });

    prevBtn.addEventListener("click", function () {
        index = (index - 1 + totalSlides) % totalSlides;
        updateSlider();
    });

    // Auto-slide every 3 seconds
    setInterval(() => {
        index = (index + 1) % totalSlides;
        updateSlider();
    }, 3000);
});


/*for sticky button*/

document.addEventListener("DOMContentLoaded", function () {
    const stickyButton = document.querySelector(".sticky-button");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 200) {
            stickyButton.style.opacity = "1";
            stickyButton.style.transform = "translateY(0)";
        } else {
            stickyButton.style.opacity = "0";
            stickyButton.style.transform = "translateY(50px)";
        }
    });
});

/* check if the user is logged in before*/

document.addEventListener("DOMContentLoaded", function () {
    const useTemplateButtons = document.querySelectorAll(".use-template-btn");

    useTemplateButtons.forEach(button => {
        button.addEventListener("click", function () {
            fetch("session_check.php")
                .then(response => response.json())
                .then(data => {
                    if (data.logged_in) {
                        window.location.href = "cv-builder.html"; // Redirect to CV builder
                    } else {
                        window.location.href = "login.html"; // Redirect to login
                    }
                });
        });
    });
});
