const viewportRoot = document.documentElement;
const desktopWidth = 1580;

function fitDesktopLayout() {
    viewportRoot.style.setProperty('--desktop-scale', Math.min(1, viewportRoot.clientWidth / desktopWidth));
}

fitDesktopLayout();
if (typeof ResizeObserver === 'function') {
    new ResizeObserver(fitDesktopLayout).observe(viewportRoot);
} else {
    window.addEventListener('resize', fitDesktopLayout);
}
