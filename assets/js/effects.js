/* NYDLA v4: user-configurable, reduced-motion friendly enhancements. */
(function () {
  'use strict';
  const settings = window.NYDLAMotionSettings || {};
  const root = document.documentElement;
  const motionPreference = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const reduceMotion = motionPreference || settings.intensity === 'off';
  const loader = document.getElementById('nydla-page-loader');

  function hideLoader() {
    if (!loader) return;
    loader.classList.add('is-leaving');
    window.setTimeout(function () {
      root.classList.remove('nydla-loading-enabled');
      loader.classList.remove('is-leaving');
    }, 390);
  }
  function showLoader() {
    if (!loader || reduceMotion || settings.loader === false) return;
    loader.classList.remove('is-leaving');
    root.classList.add('nydla-loading-enabled');
  }
  if (document.readyState === 'complete') hideLoader();
  else window.addEventListener('load', hideLoader, { once: true });
  window.addEventListener('pageshow', function (event) { if (event.persisted) hideLoader(); });
  window.setTimeout(hideLoader, 6000);

  document.addEventListener('click', function (event) {
    if (reduceMotion || settings.loader === false || event.defaultPrevented || event.button !== 0 || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
    const anchor = event.target.closest('a[href]');
    if (!anchor || anchor.hasAttribute('download') || (anchor.target && anchor.target !== '_self')) return;
    const href = anchor.getAttribute('href');
    if (!href || href === '#' || href.charAt(0) === '#') return;
    let url;
    try { url = new URL(anchor.href, window.location.href); } catch (_) { return; }
    if (url.origin !== window.location.origin || !/^https?:$/.test(url.protocol)) return;
    if (/\/(wp-admin|wp-login\.php)(\/|\?|$)/.test(url.pathname)) return;
    if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) return;
    if (url.href === window.location.href) return;
    event.preventDefault();
    showLoader();
    window.setTimeout(function () { window.location.assign(url.href); }, 110);
  });

  // Fade-in effects are initialized only when JavaScript can reveal the elements.
  if (!reduceMotion && settings.reveals !== false && 'IntersectionObserver' in window) {
    const selectors = [
      '.hero-copy > *', '.intro-grid > *', '.section-heading > *', '.bento-card',
      '.membership-content > *', '.post-card', '.empty-insights', '.page-heading',
      '.page-article .prose > *', '.single-article .prose > *', '.footer-grid > *',
      '.home-prose > *', '.nydla-journey-heading > *', '.nydla-journey-step'
    ];
    const observer = new IntersectionObserver(function (entries, instance) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        instance.unobserve(entry.target);
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -18px 0px' });
    Array.from(document.querySelectorAll(selectors.join(', '))).forEach(function (element, index) {
      element.classList.add('nydla-reveal');
      element.style.setProperty('--reveal-delay', (index % 4) * 55 + 'ms');
      observer.observe(element);
    });
    root.classList.add('nydla-motion-ready');
  }

  // Preserve existing purple artwork motion; the new spotlight is homepage-only.
  const hero = document.querySelector('.hero-section');
  const art = hero && hero.querySelector('.hero-art');
  if (!reduceMotion && hero && art && (settings.hero !== false || settings.spotlight !== false)) {
    if (settings.hero !== false) hero.classList.add('nydla-hero-motion');
    if (settings.spotlight !== false) hero.classList.add('nydla-hero-spotlight');
    let frame = 0;
    hero.addEventListener('pointermove', function (event) {
      if (event.pointerType !== 'mouse' || frame) return;
      const rect = hero.getBoundingClientRect();
      const xp = Math.min(100, Math.max(0, ((event.clientX - rect.left) / rect.width) * 100));
      const yp = Math.min(100, Math.max(0, ((event.clientY - rect.top) / rect.height) * 100));
      frame = window.requestAnimationFrame(function () {
        if (settings.hero !== false) {
          art.style.setProperty('--art-x', ((xp / 100 - .5) * 15).toFixed(1) + 'px');
          art.style.setProperty('--art-y', ((yp / 100 - .5) * 12).toFixed(1) + 'px');
        }
        if (settings.spotlight !== false) {
          hero.style.setProperty('--spot-x', xp.toFixed(1) + '%');
          hero.style.setProperty('--spot-y', yp.toFixed(1) + '%');
        }
        frame = 0;
      });
    }, { passive: true });
    hero.addEventListener('pointerleave', function () {
      art.style.setProperty('--art-x', '0px'); art.style.setProperty('--art-y', '0px');
      hero.style.setProperty('--spot-x', '75%'); hero.style.setProperty('--spot-y', '35%');
    });
  }

  // A single throttled scroll callback drives sticky header, journey and reading progress.
  const header = document.getElementById('site-header');
  const journey = document.querySelector('.nydla-journey-section');
  const steps = journey ? Array.from(journey.querySelectorAll('.nydla-journey-step')) : [];
  let progressBar = null;
  if (document.body.classList.contains('single-post')) {
    progressBar = document.createElement('div');
    progressBar.className = 'nydla-reading-progress'; progressBar.setAttribute('aria-hidden', 'true');
    document.body.appendChild(progressBar);
  }
  function updateScroll() {
    if (header && settings.sticky !== false) header.classList.toggle('is-scrolled', window.scrollY > 32);
    if (journey && !reduceMotion) {
      const rect = journey.getBoundingClientRect();
      const distance = rect.height + window.innerHeight * .1;
      const progress = Math.max(0, Math.min(1, (window.innerHeight * .79 - rect.top) / distance));
      journey.style.setProperty('--journey-progress', (progress * 100).toFixed(1) + '%');
      steps.forEach(function (step, index) { step.classList.toggle('is-active', progress > index / 3 + .07); });
    }
    if (progressBar) {
      const doc = document.documentElement;
      const max = Math.max(1, doc.scrollHeight - window.innerHeight);
      progressBar.style.transform = 'scaleX(' + (Math.max(0, Math.min(1, window.scrollY / max))).toFixed(4) + ')';
    }
    scrollFrame = 0;
  }
  let scrollFrame = 0;
  window.addEventListener('scroll', function () {
    if (!scrollFrame) scrollFrame = window.requestAnimationFrame(updateScroll);
  }, { passive: true });
  window.addEventListener('resize', function () {
    if (!scrollFrame) scrollFrame = window.requestAnimationFrame(updateScroll);
  });
  updateScroll();

  // Soft pointer highlights on existing feature and post cards, no extra plugins.
  if (!reduceMotion && settings.cards !== false) {
    document.querySelectorAll('.bento-card, .post-card, .nydla-journey-step').forEach(function (card) {
      card.addEventListener('pointermove', function (event) {
        if (event.pointerType !== 'mouse') return;
        const rect = card.getBoundingClientRect();
        card.style.setProperty('--card-x', (event.clientX - rect.left).toFixed(0) + 'px');
        card.style.setProperty('--card-y', (event.clientY - rect.top).toFixed(0) + 'px');
      }, { passive: true });
    });
  }
})();
