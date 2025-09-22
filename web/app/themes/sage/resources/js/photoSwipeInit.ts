import PhotoSwipeLightbox from 'photoswipe/lightbox';

/**
 * Initialize PhotoSwipe galleries
 *
 * @param {string} selector - CSS selector for gallery containers
 * @param {object} customOptions - Additional options to pass to PhotoSwipe
 */
export function initPhotoSwipe(selector = '[data-pswp-gallery]', customOptions = {}): void {
  // Using a single PhotoSwipeLightbox instance for all galleries
  const lightbox = new PhotoSwipeLightbox({
    // Target all galleries with the selector
    gallery: selector,
    children: 'a',
    pswpModule: () => import('photoswipe'),
    showHideAnimationType: 'fade',
    closeTitle: 'Close gallery',
    zoomTitle: 'Zoom in/out',
    arrowPrevTitle: 'Previous',
    arrowNextTitle: 'Next',
    errorMsg: 'The image cannot be loaded',
    loop: true, // Enable looping through images
    preload: [5, 5], // Preload one image before and after the current one
    ...customOptions,
  });

  lightbox.on('uiRegister', function () {
    lightbox?.pswp?.ui?.registerElement({
      name: 'custom-caption',
      order: 9,
      isButton: false,
      appendTo: 'root',
      html: 'Caption text',
      onInit: (el) => {
        lightbox?.pswp?.on('change', () => {
          const currSlideElement = lightbox?.pswp?.currSlide?.data.element;
          console.log('Current slide element:', currSlideElement);
          let captionHTML = '';
          if (currSlideElement) {
            // @ts-expect-error
            const hiddenCaption = currSlideElement?.dataset?.pswpCaption ?? 'This is a test';
            if (hiddenCaption) {
              // Retrieve caption from element with class hidden-caption-content
              captionHTML = hiddenCaption;
            } else {
              // Fallback: retrieve caption from image alt attribute
              const img = currSlideElement.querySelector('img');
              captionHTML = img ? img.getAttribute('alt') || '' : '';
            }
          }
          el.innerHTML = captionHTML;
        });
      },
    });
  });

  lightbox.on('beforeOpen', function () {
    // Logic before gallery opens
  });

  // Add loading state effect to clicked items
  document.querySelectorAll(`${selector} a`).forEach((item) => {
    item.addEventListener('click', () => {
      const img = item.querySelector('img');
      if (img) {
        img.classList.add('opacity-60');
        setTimeout(() => {
          img.classList.remove('opacity-60');
        }, 500);
      }
    });
  });

  // Initialize the single lightbox instance
  lightbox.init();
}

export default initPhotoSwipe;
