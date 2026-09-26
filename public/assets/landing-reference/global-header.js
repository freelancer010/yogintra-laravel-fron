document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.landing-menu-toggle');
  const menu = document.querySelector('#landing-global-menu');

  if (!toggle || !menu) return;

  toggle.addEventListener('click', () => {
    const isOpen = menu.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', String(isOpen));
  });

  menu.querySelectorAll(':scope > li').forEach((item) => {
    const submenu = item.querySelector(':scope > .dropdown');
    const link = item.querySelector(':scope > a');

    if (!submenu || !link) return;

    link.addEventListener('click', (event) => {
      if (window.matchMedia('(max-width: 780px)').matches) {
        event.preventDefault();
        item.classList.toggle('is-expanded');
      }
    });
  });
});
