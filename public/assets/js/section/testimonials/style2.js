(function () {
    const instances = document.querySelectorAll('[data-testimonials-style2]');
    if (!instances.length) return;

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        });
    }, { threshold: 0.12 });

    instances.forEach((root) => {
        const track = root.querySelector('.ts2-track');
        const wrap = root.querySelector('.ts2-wrap');
        const prev = root.querySelector('.ts2-prev');
        const next = root.querySelector('.ts2-next');
        const dotsWrap = root.querySelector('.ts2-dots');
        const cards = Array.from(root.querySelectorAll('.ts2-card'));
        const revealEl = root.querySelector('.ts2-reveal');

        if (revealEl) revealObserver.observe(revealEl);
        if (!track || !wrap || !prev || !next || !dotsWrap || !cards.length) return;

        let current = 0;
        let startX = 0;
        let dragging = false;
        let timer;

        const getVisible = () => {
            const width = window.innerWidth;
            if (width <= 640) return 1;
            if (width <= 1024) return 2;
            return 3;
        };

        const getMax = () => Math.max(0, cards.length - getVisible());

        const getCardWidth = () => {
            const gap = parseFloat(getComputedStyle(track).gap || '24');
            return cards[0].getBoundingClientRect().width + gap;
        };

        const renderDots = () => {
            const totalDots = getMax() + 1;
            dotsWrap.innerHTML = '';
            for (let index = 0; index < totalDots; index += 1) {
                const dot = document.createElement('button');
                dot.className = `ts2-dot ${index === current ? 'active' : ''}`;
                dot.addEventListener('click', () => goto(index));
                dotsWrap.appendChild(dot);
            }
        };

        const goto = (index) => {
            current = Math.max(0, Math.min(index, getMax()));
            track.style.transform = `translateX(${-current * getCardWidth()}px)`;

            dotsWrap.querySelectorAll('.ts2-dot').forEach((dot, dotIndex) => {
                dot.classList.toggle('active', dotIndex === current);
            });
        };

        const autoplay = () => {
            clearInterval(timer);
            timer = setInterval(() => {
                goto(current < getMax() ? current + 1 : 0);
            }, 6000);
        };

        prev.addEventListener('click', () => {
            goto(current - 1);
            autoplay();
        });

        next.addEventListener('click', () => {
            goto(current + 1);
            autoplay();
        });

        wrap.addEventListener('touchstart', (event) => {
            startX = event.touches[0].clientX;
            dragging = true;
        }, { passive: true });

        wrap.addEventListener('touchend', (event) => {
            if (!dragging) return;
            dragging = false;
            const distance = event.changedTouches[0].clientX - startX;
            if (Math.abs(distance) > 50) goto(distance < 0 ? current + 1 : current - 1);
            autoplay();
        });

        wrap.addEventListener('mousedown', (event) => {
            startX = event.clientX;
            dragging = true;
        });

        wrap.addEventListener('mouseup', (event) => {
            if (!dragging) return;
            dragging = false;
            const distance = event.clientX - startX;
            if (Math.abs(distance) > 50) goto(distance < 0 ? current + 1 : current - 1);
            autoplay();
        });

        wrap.addEventListener('mouseleave', () => {
            dragging = false;
        });

        window.addEventListener('resize', () => {
            current = Math.min(current, getMax());
            renderDots();
            goto(current);
        });

        renderDots();
        goto(0);
        autoplay();
    });
})();
