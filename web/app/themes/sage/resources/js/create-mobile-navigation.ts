export const createMobileNavigation = () => {
  // Check if it already exists
  if (document.querySelector('.mobile-nav-container')) {
    return;
  }

  // Create overlay for better UX
  const overlayHTML = `<div class="mobile-mega-menu-overlay"></div>`;
  document.body.insertAdjacentHTML('beforeend', overlayHTML);

  // Using template literal for cleaner HTML structure
  const mobileNavHTML = `
     <div class="mobile-nav-container lg:hidden">
       <div class="container mx-auto px-4 py-6">
         <div class="flex justify-between items-center mb-8">
           <a href="/" class="flex items-center gap-2">
             <div class="w-8 h-8 bg-green-800 rounded-full logo-circle"></div>
             <span class="text-lg font-semibold text-green-800">${document.querySelector('header .logo-circle')?.nextElementSibling?.textContent || 'Site Name'}</span>
           </a>
         </div>
         <nav class="py-4">
           <ul class="space-y-4">
             ${['about', 'services', 'projects', 'careers', 'contact']
               .map(
                 (item) => `
                 <li class="py-2 border-b border-gray-200" data-mobile-menu="${item}">
                   <a href="#" class="flex justify-between items-center text-lg font-medium hover:text-green-700 mobile-menu-link"
                      data-menu="${item}">
                     ${item.charAt(0).toUpperCase() + item.slice(1)}
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                       <polyline points="9 18 15 12 9 6"></polyline>
                     </svg>
                   </a>
                 </li>
               `,
               )
               .join('')}
           </ul>
         </nav>
       </div>
     </div>
   `;

  // Insert into DOM
  document.body.insertAdjacentHTML('beforeend', mobileNavHTML);

  // Setup mobile menu links to open mega menus
  const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');

  // .forEach(link => {
  for (const link of mobileMenuLinks) {
    link.addEventListener('click', (e) => {
      e.preventDefault();

      const menuName = link.getAttribute('data-menu');
      if (!menuName) return;

      // Find corresponding mega menu
      const megaMenu = document.querySelector(`.mobile-mega-menu[data-mega-menu="${menuName}"]`);
      if (megaMenu) {
        megaMenu.classList.add('active');

        // Show overlay
        const overlay = document.querySelector('.mobile-mega-menu-overlay');
        if (overlay) overlay.classList.add('active');
      }
    });
  }

  console.log('Mobile navigation container created with animation support');
};
