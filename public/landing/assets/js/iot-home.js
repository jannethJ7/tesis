(() => {
    'use strict';

    document.documentElement.classList.replace('no-js', 'js');
    const menuButton = document.querySelector('.menu-toggle');
    const navigation = document.getElementById('navegacion');

    if (menuButton && navigation) {
        const closeMenu = (restoreFocus = false) => {
            navigation.classList.remove('is-open');
            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.setAttribute('aria-label', 'Abrir menú');
            if (restoreFocus) menuButton.focus();
        };

        menuButton.addEventListener('click', () => {
            const opened = navigation.classList.toggle('is-open');
            menuButton.setAttribute('aria-expanded', String(opened));
            menuButton.setAttribute('aria-label', opened ? 'Cerrar menú' : 'Abrir menú');
        });
        navigation.addEventListener('click', (event) => {
            if (event.target.closest('a')) closeMenu();
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && navigation.classList.contains('is-open')) closeMenu(true);
        });
        document.addEventListener('click', (event) => {
            if (!event.target.closest('.site-header')) closeMenu();
        });
        window.matchMedia('(min-width: 981px)').addEventListener('change', () => closeMenu());
    }

    const tabs = Array.from(document.querySelectorAll('.flow-tabs [role="tab"]'));
    const activateTab = (selectedTab, focus = false) => {
        tabs.forEach((tab) => {
            const selected = tab === selectedTab;
            tab.setAttribute('aria-selected', String(selected));
            tab.tabIndex = selected ? 0 : -1;
            const panel = document.getElementById(tab.getAttribute('aria-controls'));
            if (panel) panel.hidden = !selected;
        });
        if (focus) selectedTab.focus();
    };
    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => activateTab(tab));
        tab.addEventListener('keydown', (event) => {
            let targetIndex;
            if (event.key === 'ArrowRight') targetIndex = (index + 1) % tabs.length;
            if (event.key === 'ArrowLeft') targetIndex = (index + tabs.length - 1) % tabs.length;
            if (event.key === 'Home') targetIndex = 0;
            if (event.key === 'End') targetIndex = tabs.length - 1;
            if (targetIndex === undefined) return;
            event.preventDefault();
            activateTab(tabs[targetIndex], true);
        });
    });

    const sectionLinks = Array.from(document.querySelectorAll('.main-nav > a[href^="#"]'));
    const sections = sectionLinks.map((link) => document.getElementById(link.hash.slice(1))).filter(Boolean);
    if ('IntersectionObserver' in window && sections.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                sectionLinks.forEach((link) => {
                    if (link.hash === '#' + entry.target.id) link.setAttribute('aria-current', 'location');
                    else link.removeAttribute('aria-current');
                });
            });
        }, { rootMargin: '-90px 0px -60% 0px', threshold: 0 });
        sections.forEach((section) => observer.observe(section));
    }
})();
