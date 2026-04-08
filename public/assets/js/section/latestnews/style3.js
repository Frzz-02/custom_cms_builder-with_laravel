(function () {
    const instances = document.querySelectorAll('[data-latestnews-style3]');
    if (!instances.length) return;

    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            io.unobserve(entry.target);
        });
    }, { threshold: 0.12 });

    instances.forEach((root) => {
        root.querySelectorAll('.ln3-reveal').forEach((element) => {
            io.observe(element);
        });
    });
})();
