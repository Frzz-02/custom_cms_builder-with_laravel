(function () {
    const instances = document.querySelectorAll('[data-navmenu-style3]');
    if (!instances.length) return;

    let openedCount = 0;
    const setBodyLock = (isOpen) => {
        openedCount += isOpen ? 1 : -1;
        if (openedCount < 0) openedCount = 0;
        document.body.style.overflow = openedCount > 0 ? 'hidden' : '';
    };

    instances.forEach((root) => {
        const navbar = root.querySelector('.nm3-navbar');
        const hamburger = root.querySelector('.nm3-hamburger');
        const mobileMenu = root.querySelector('.nm3-mobile-menu');
        const cityItems = root.querySelectorAll('.city-item');
        const cityToggles = root.querySelectorAll('.nm3-city-toggle');
        const cityCloseButtons = root.querySelectorAll('.nm3-city-close');
        const links = root.querySelectorAll('.navbar-left-links a, .navbar-right-links a');

        if (!navbar || !hamburger || !mobileMenu) return;

        let mobileOpen = false;

        const closeMobileMenu = () => {
            if (!mobileOpen) return;
            mobileOpen = false;
            hamburger.classList.remove('open');
            mobileMenu.classList.remove('open');
            setBodyLock(false);
        };

        const openMobileMenu = () => {
            if (mobileOpen) return;
            mobileOpen = true;
            hamburger.classList.add('open');
            mobileMenu.classList.add('open');
            setBodyLock(true);
        };

        hamburger.addEventListener('click', () => {
            if (mobileOpen) {
                closeMobileMenu();
                return;
            }

            openMobileMenu();
        });

        mobileMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                closeMobileMenu();
            });
        });

        cityToggles.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.stopPropagation();
                const currentItem = button.closest('.city-item');
                const shouldOpen = !currentItem.classList.contains('open');

                cityItems.forEach((item) => item.classList.remove('open'));
                if (shouldOpen) currentItem.classList.add('open');
            });
        });

        cityCloseButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.stopPropagation();
                const parent = button.closest('.city-item');
                if (parent) parent.classList.remove('open');
            });
        });

        document.addEventListener('click', (event) => {
            if (!root.contains(event.target)) {
                cityItems.forEach((item) => item.classList.remove('open'));
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMobileMenu();
                cityItems.forEach((item) => item.classList.remove('open'));
            }
        });

        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 10);
        }, { passive: true });

        if (links.length) {
            const sections = document.querySelectorAll('section[id], div[id]');
            const io = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const id = entry.target.id;
                        links.forEach((anchor) => {
                            anchor.classList.toggle('active', anchor.getAttribute('href') === `#${id}`);
                        });
                    }
                });
            }, { threshold: 0.4 });

            sections.forEach((section) => io.observe(section));
        }
    });
})();