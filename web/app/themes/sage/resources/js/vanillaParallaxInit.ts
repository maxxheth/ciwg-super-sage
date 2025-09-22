import { VanillaParallax } from './UI/VanillaParallax';

export const vanillaParallaxInit = () => {
  console.log('VanillaParallaxInit - DOM loaded');

  // Initialize the parallax effect
  const parallax = new VanillaParallax();
  console.log('Parallax instance created');

  // Check all elements with service-layout class to debug
  const allServiceLayouts = document.querySelectorAll('.service-layout');
  console.log('All service layouts found:', allServiceLayouts.length);

  allServiceLayouts.forEach((layout, i) => {
    console.log(`Service layout ${i} classes:`, layout.className);
    console.log(`Service layout ${i} data-layout:`, layout.getAttribute('data-layout'));
  });

  // Find the service layout with alternating layout
  // Try multiple selectors to see which one works
  let layoutSection = document.querySelector('.service-layout.layout-alternating');
  if (!layoutSection) {
    layoutSection = document.querySelector('.service-layout[data-layout="alternating"]');
    console.log('Trying alternate selector with data-attribute');
  }

  if (layoutSection) {
    console.log('Alternating layout found:', layoutSection);

    // Ensure the layout-alternating class is applied
    if (!layoutSection.classList.contains('layout-alternating')) {
      console.log('Adding layout-alternating class to section');
      layoutSection.classList.add('layout-alternating');
    }

    // Find the container inside the layout
    const container = layoutSection.querySelector('.service-layout__container');
    if (container) {
      console.log('Container found:', container);

      // Get all service items directly inside the container
      const serviceItems = container.querySelectorAll(':scope > .service-item');
      console.log('Service items found:', serviceItems.length);

      // Log each service item for diagnostics
      serviceItems.forEach((item, index) => {
        console.log(`Service item ${index}:`, item);

        // Make sure service-item class is present
        if (!item.classList.contains('service-item')) {
          console.log(`Adding service-item class to item ${index}`);
          item.classList.add('service-item');
        }
      });
    } else {
      console.warn('Container not found inside layout section!');

      // Check for any possible containers
      const anyContainer = layoutSection.querySelector('*');
      if (anyContainer) {
        console.log('First child element found:', anyContainer);
        console.log('Child classes:', anyContainer.className);
      }
    }
  } else {
    console.warn('No alternating layout found! Looking for .service-layout.layout-alternating');
  }

  // Always refresh the parallax effect
  console.log('Refreshing parallax effect');
  parallax.refresh();
};
