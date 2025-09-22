import Swiper from 'swiper';
import { Navigation, Thumbs, FreeMode } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';

/**
 * Initialize Project Gallery Slider
 */
const initProjectGallerySlider = (): void => {
  // Find all project gallery sliders on the page
  const sliderContainers = document.querySelectorAll('.project-gallery-container');

  sliderContainers.forEach((container) => {
    const id = container.getAttribute('id');

    if (!id) return;

    // Initialize thumbnail swiper
    const thumbsSwiper = new Swiper(`#${id}-thumbs`, {
      modules: [FreeMode, Navigation],
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
      breakpoints: {
        // when window width is >= 320px
        320: {
          slidesPerView: 3,
        },
        // when window width is >= 640px
        640: {
          slidesPerView: 4,
        },
      },
    });

    // Initialize main swiper
    new Swiper(`#${id}-main`, {
      modules: [Navigation, Thumbs],
      spaceBetween: 10,
      navigation: {
        nextEl: `.swiper-button-next`,
        prevEl: `.swiper-button-prev`,
      },
      thumbs: {
        swiper: thumbsSwiper,
      },
    });
  });
};

export default initProjectGallerySlider;
