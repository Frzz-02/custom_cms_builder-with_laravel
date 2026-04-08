// slider gambar hero style 3 (scoped per instance)
(function() {
    const blocks = document.querySelectorAll('[data-hero-style3]');
    if (!blocks.length) return;

    blocks.forEach((block) => {
        const slides = block.querySelectorAll('.hb3-slide');
        if (!slides.length) return;

        let currentIndex = 0;

        const goTo = (index) => {
            slides[currentIndex].classList.remove('active');
            currentIndex = (index + slides.length) % slides.length;
            slides[currentIndex].classList.add('active');
        };

        setInterval(() => goTo(currentIndex + 1), 3500);
    });
})();