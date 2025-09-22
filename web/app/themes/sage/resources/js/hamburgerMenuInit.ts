import { createMobileNavigation } from './create-mobile-navigation';

export const hamburgerMenuInit = (className = '.tham') => {
  console.log('ThamInit called with className:', className);

  const tham = document.querySelector(className);
  if (!tham) {
    console.error('ERROR: Hamburger menu element not found with selector:', className);
    return;
  }

  // Create mobile navigation component
  createMobileNavigation();

  // Track menu state
  let isMenuOpen = false;

  // Add click event listener to hamburger
  tham.addEventListener('click', (e) => {
    console.log('Hamburger menu clicked');
    e.preventDefault();
    e.stopPropagation();

    // Toggle active class on hamburger
    tham.classList.toggle('tham-active');

    // Toggle menu state
    isMenuOpen = !isMenuOpen;

    if (isMenuOpen) {
      document.body.classList.add('mobile-menu-open');
      document.body.style.overflow = 'hidden';
    } else {
      document.body.classList.remove('mobile-menu-open');
      document.body.style.overflow = '';

      // Reset mega menu state
      const mobileMegaMenuActiveItems = document.querySelectorAll('.mobile-mega-menu.active');

      for (const megaMenuItem of mobileMegaMenuActiveItems) {
        megaMenuItem.classList.remove('active');
      }

      const overlay = document.querySelector('.mobile-mega-menu-overlay');
      if (overlay) overlay.classList.remove('active');
    }

    console.log('Mobile menu toggled. Open:', isMenuOpen);
  });

  console.log('ThamInit completed - event listeners attached');
};
