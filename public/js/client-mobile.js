document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-mobile-menu]').forEach((button) => {
        button.addEventListener('click', () => {
            document.body.classList.toggle('mobile-menu-open');
        });
    });

    document.addEventListener('click', (event) => {
        if (!document.body.classList.contains('mobile-menu-open')) {
            return;
        }

        const aside = document.querySelector('aside.bg-slate-950');
        const trigger = event.target.closest('[data-mobile-menu]');

        if (trigger || aside?.contains(event.target)) {
            return;
        }

        document.body.classList.remove('mobile-menu-open');
    });

    document.querySelectorAll('aside.bg-slate-950 a').forEach((link) => {
        link.addEventListener('click', () => {
            document.body.classList.remove('mobile-menu-open');
        });
    });
});
