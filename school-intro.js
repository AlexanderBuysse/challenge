(() => {
    const intro = document.querySelector('.school-intro');
    if (window.self !== window.top || typeof intro.showModal !== 'function') return;

    const key = 'school-intro:' + intro.dataset.project;
    try {
        if (sessionStorage.getItem(key)) return;
    } catch {
        // The dialog can still be dismissed when browser storage is unavailable.
    }

    intro.addEventListener('close', () => {
        try {
            sessionStorage.setItem(key, 'seen');
        } catch {
            // Visiting another page may show the dialog again.
        }
    }, { once: true });
    intro.showModal();
})();

(() => {
    const intro = document.querySelector('[data-project="challenge"]');
    const notice = document.querySelector('#demo-action');
    if (typeof notice.showModal !== 'function') return;

    document.querySelectorAll('[data-demo-action]').forEach(button => {
        button.addEventListener('click', () => notice.showModal());
    });
    if (notice.hasAttribute('data-show-on-entry')) {
        if (intro.open) {
            intro.addEventListener('close', () => notice.showModal(), { once: true });
        } else {
            notice.showModal();
        }
    }
})();
