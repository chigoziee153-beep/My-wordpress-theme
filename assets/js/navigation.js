/* NYDLA v4: WordPress native menu hierarchy, progressive-accessible mega menus. */
(function () {
  'use strict';
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.getElementById('primary-navigation');
  if (!toggle || !nav) return;

  const parents = Array.from(nav.querySelectorAll('.menu-item-has-children'));
  const mobile = window.matchMedia('(max-width: 1120px)');

  function directButton(item) {
    return item.querySelector(':scope > .nydla-submenu-toggle');
  }
  function directLink(item) {
    return item.querySelector(':scope > a');
  }
  function setExpanded(item, open) {
    item.classList.toggle('submenu-open', open);
    const btn = directButton(item);
    if (btn) btn.setAttribute('aria-expanded', String(open));
  }
  function closeSubmenus(except, includeAncestors) {
    parents.forEach(function (item) {
      if (except && (item === except || (!includeAncestors && item.contains(except)))) return;
      setExpanded(item, false);
    });
  }
  function closeMenu() {
    toggle.setAttribute('aria-expanded', 'false');
    nav.classList.remove('is-open');
    document.body.classList.remove('menu-open');
    closeSubmenus();
  }
  parents.forEach(function (item) {
    const button = directButton(item);
    const link = directLink(item);
    if (link) link.setAttribute('aria-haspopup', 'true');
    if (button) {
      button.addEventListener('click', function (event) {
        event.preventDefault();
        const opening = !item.classList.contains('submenu-open');
        closeSubmenus(item, false);
        setExpanded(item, opening);
      });
    }
    if (link && link.getAttribute('href') === '#') {
      // WordPress custom-link placeholders should control their submenu, not jump to page top.
      link.addEventListener('click', function (event) {
        event.preventDefault();
        if (button) button.click();
      });
    }
    // Desktop hover remains usable without requiring a click; actual page links still navigate.
    item.addEventListener('mouseenter', function () {
      if (mobile.matches) return;
      closeSubmenus(item, false);
      setExpanded(item, true);
    });
    item.addEventListener('mouseleave', function () {
      if (!mobile.matches) setExpanded(item, false);
    });
  });

  toggle.addEventListener('click', function () {
    const opening = toggle.getAttribute('aria-expanded') !== 'true';
    toggle.setAttribute('aria-expanded', String(opening));
    nav.classList.toggle('is-open', opening);
    document.body.classList.toggle('menu-open', opening);
    if (!opening) closeSubmenus();
  });

  nav.addEventListener('click', function (event) {
    const link = event.target.closest('a');
    if (!link) return;
    // A non-placeholder link is navigation, never an accordion toggle.
    if (link.closest('.primary-menu') && link.getAttribute('href') !== '#') closeMenu();
  });
  document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;
    const isMobileMenuOpen = toggle.getAttribute('aria-expanded') === 'true';
    const anySubmenuOpen = parents.some(function (item) { return item.classList.contains('submenu-open'); });
    if (isMobileMenuOpen) { closeMenu(); toggle.focus(); }
    else if (anySubmenuOpen) {
      const active = parents.find(function (item) { return item.classList.contains('submenu-open'); });
      closeSubmenus();
      const btn = active && directButton(active);
      if (btn) btn.focus();
    }
  });
  document.addEventListener('click', function (event) {
    if (!nav.contains(event.target) && event.target !== toggle && !toggle.contains(event.target)) {
      if (mobile.matches) closeMenu(); else closeSubmenus();
    }
  });
  document.addEventListener('focusin', function (event) {
    if (!nav.contains(event.target) && !toggle.contains(event.target)) closeSubmenus();
  });
  mobile.addEventListener('change', closeMenu);
})();
