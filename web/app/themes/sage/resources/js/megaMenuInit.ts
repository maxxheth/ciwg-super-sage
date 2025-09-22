export const megaMenuInit = () => {
  // Elements
  const header = document.querySelector('[data-header]');
  const menuItems = document.querySelectorAll('[data-menu]');
  const megaMenus = document.querySelectorAll('[data-mega-menu]');
  const megaMenuContainer = document.querySelector('[data-mega-menu-container]');
  const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');

  // Mobile elements
  const mobileMegaMenus = document.querySelectorAll('.mobile-mega-menu');
  const mobileMegaMenuOverlay = document.querySelector('.mobile-mega-menu-overlay');
  const mobileMegaMenuCloseButtons = document.querySelectorAll('.mobile-mega-menu-close');

  // State
  let activeMenu: string | null = null;
  let isMenuOpen = false;
  let isMobile = window.innerWidth < 1024;

  // Check if device is mobile
  const checkMobile = () => {
    isMobile = window.innerWidth < 1024;
  };

  // Show mega menu
  function showMegaMenu(menuName: string | null) {
    if (activeMenu === menuName) return;

    // Hide all mega menus first
    hideMegaMenu();

    activeMenu = menuName;

    if (isMobile) {
      // Show mobile mega menu
      const targetMobileMenu = document.querySelector(
        `.mobile-mega-menu[data-mobile-mega-menu="${menuName}"]`,
      );
      if (targetMobileMenu) {
        targetMobileMenu.classList.add('active');
        document.body.style.overflow = 'hidden';
        mobileMegaMenuOverlay?.classList.add('active');
      }
    } else {
      // Show desktop mega menu
      megaMenuContainer?.classList.remove('hidden');
      megaMenuContainer?.classList.add('block');

      // Add active class to menu item
      for (const item of menuItems) {
        const itemName = item.getAttribute('data-menu');
        const link = item.querySelector('.menu-link');

        if (itemName === menuName) {
          link?.classList.add('text-green-700');
        } else {
          link?.classList.remove('text-green-700');
        }
      }

      // Show the selected mega menu
      const targetMenu = document.querySelector(`[data-mega-menu="${menuName}"]`);
      if (targetMenu) {
        targetMenu.classList.add('active');
        targetMenu.classList.add('animate-fade-in-down');
      }
    }
  }

  // Hide mega menu
  function hideMegaMenu() {
    if (!activeMenu) return;

    if (isMobile) {
      // Hide mobile mega menu with animation
      const activeMenus = document.querySelectorAll('.mobile-mega-menu.active');

      for (const menu of activeMenus) {
        // First add a class to trigger the animation
        menu.classList.add('closing');

        // Then wait for the animation to finish before removing the active class
        setTimeout(() => {
          menu.classList.remove('active');
          menu.classList.remove('closing');
        }, 300); // Duration should match your animation timing
      }

      mobileMegaMenuOverlay?.classList.remove('active');
      document.body.style.overflow = '';
    } else {
      // Hide desktop mega menu
      // Remove active class from all menu items
      for (const item of menuItems) {
        const link = item.querySelector('.menu-link');
        link?.classList.remove('text-green-700');
      }

      // Hide all mega menus
      for (const menu of megaMenus) {
        menu.classList.remove('active');
        menu.classList.remove('animate-fade-in-down');
      }

      // Hide container after a slight delay
      setTimeout(() => {
        if (!activeMenu) {
          megaMenuContainer?.classList.add('hidden');
          megaMenuContainer?.classList.remove('block');
        }
      }, 200);
    }

    activeMenu = null;
  }

  // Event Listeners
  for (const item of menuItems) {
    const menuName = item.getAttribute('data-menu');

    // Desktop: Mouse enter
    item.addEventListener('mouseenter', (e) => {
      if (!isMobile) {
        e.stopPropagation();
        showMegaMenu(menuName);
      }
    });

    // Click
    item.addEventListener('click', (e) => {
      if (!isMobile) return;
      e.preventDefault();
      e.stopPropagation();

      if (activeMenu === menuName) {
        hideMegaMenu();
      } else {
        showMegaMenu(menuName);
      }
    });
  }

  // Hide mega menu when clicking outside
  document.addEventListener('click', () => {
    hideMegaMenu();
  });

  // Prevent clicks inside mega menu from closing it
  for (const menu of megaMenus) {
    menu.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }

  // Prevent clicks on mobile mega menu from closing it
  for (const menu of mobileMegaMenus) {
    menu.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }

  // Mobile mega menu close button
  for (const button of mobileMegaMenuCloseButtons) {
    button.addEventListener('click', () => {
      hideMegaMenu();
    });
  }

  // Close mobile mega menu when clicking on overlay
  mobileMegaMenuOverlay?.addEventListener('click', () => {
    hideMegaMenu();
  });

  // Prevent clicks on mega menu container from closing it
  megaMenuContainer?.addEventListener('click', (e) => {
    e.stopPropagation();
  });

  // Hide mega menu when mouse leaves header
  header?.addEventListener('mouseleave', () => {
    if (!isMobile) {
      hideMegaMenu();
    }
  });

  // Mobile menu toggle
  if (mobileMenuToggle) {
    mobileMenuToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      isMenuOpen = !isMenuOpen;

      if (isMenuOpen) {
        // Show mobile menu
        document.body.classList.add('mobile-menu-open');
      } else {
        // Hide mobile menu
        document.body.classList.remove('mobile-menu-open');
        hideMegaMenu();
      }
    });
  }

  // Handle window resize
  window.addEventListener('resize', () => {
    const wasMobile = isMobile;
    checkMobile();

    // If switching between mobile and desktop, hide any open menus
    if (wasMobile !== isMobile && activeMenu) {
      hideMegaMenu();
    }
  });

  // Initial mobile check
  checkMobile();
};
