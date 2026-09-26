// Decorative section images should not compete with the homepage hero.
(function () {
    var sections = document.querySelectorAll('[data-home-background]');
    function load(section) {
        section.style.backgroundImage = 'url(' + JSON.stringify(section.dataset.homeBackground) + ')';
    }
    if (!('IntersectionObserver' in window)) {
        sections.forEach(load);
        return;
    }
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                load(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { rootMargin: '300px' });
    sections.forEach(function (section) { observer.observe(section); });
}());
