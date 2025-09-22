import { createTimeline, stagger, animate, type JSAnimation } from 'animejs'; // Import AnimeInstance type

/**
 * Initializes a dynamic carousel/filter for featured projects using anime.js.
 * Assumes specific HTML structure and data attributes are present.
 *
 * @param containerSelector CSS selector for the main section container (e.g., '#featured-projects').
 */
export function FeaturedProjectsDynamicCarousel(containerSelector: string): void {
  const container = document.querySelector(containerSelector);
  if (!container) {
    console.error(`Featured projects container "${containerSelector}" not found.`);
    return;
  }

  const filterButtons = container.querySelectorAll<HTMLButtonElement>(
    '#featured-projects-filters button[data-filter]',
  );
  const projectsGrid = container.querySelector<HTMLElement>('#featured-projects-grid');
  const allProjectItems = projectsGrid
    ? Array.from(projectsGrid.querySelectorAll<HTMLElement>('.project-item'))
    : [];

  if (!projectsGrid || filterButtons.length === 0 || allProjectItems.length === 0) {
    console.warn('Featured projects: Missing filter buttons, project grid, or project items.');
    return;
  }

  const MAX_ITEMS_VISIBLE = 3;
  let currentFilter = 'All'; // Default filter
  let visibleItems: HTMLElement[] = []; // Track currently displayed items

  /**
   * Filters projects based on the category and animates the transition.
   * @param filter The category to filter by ('All' shows all).
   * @param isInitialLoad Flag to skip initial animation-out.
   */
  function filterAndAnimateProjects(filter: string, isInitialLoad = false): void {
    const filteredRaw = allProjectItems.filter(
      (item) =>
        filter === 'All' ||
        (item.dataset.category && item.dataset.category.toLowerCase() === filter.toLowerCase()),
    );

    // Ensure we use the order defined by the Composer (based on DOM order here)
    const itemsToShow = filteredRaw.slice(0, MAX_ITEMS_VISIBLE);

    // Determine which items are currently visible but need to be hidden
    const itemsToAnimateOut = isInitialLoad
      ? []
      : visibleItems.filter((item) => !itemsToShow.includes(item));
    // Determine which items need to be hidden immediately (were never visible or not part of new set)
    const itemsToHideStatically = allProjectItems.filter(
      (item) => !itemsToShow.includes(item) && !itemsToAnimateOut.includes(item),
    );

    // --- Define Animations ---

    // Animation for items fading out
    let outAnimation: JSAnimation | null = null;
    if (itemsToAnimateOut.length > 0) {
      outAnimation = animate(itemsToAnimateOut, {
        opacity: [1, 0],
        scale: [1, 0.95],
        translateY: [0, 15],
        duration: 400, // Slightly shorter duration for exit
        delay: stagger(50),
        easing: 'easeInQuad', // Different easing for exit
        complete: () => {
          // Hide them fully after animation
          itemsToAnimateOut.forEach((item) => (item.style.display = 'none'));
        },
      });
      // Prevent the animation from playing immediately
      outAnimation.pause();
    }

    // Prepare items to show (set initial state)
    itemsToShow.forEach((item) => {
      if (!visibleItems.includes(item) || isInitialLoad) {
        item.style.display = 'block'; // Make it part of the layout flow
        item.style.opacity = '0';
        item.style.transform = 'scale(0.95) translateY(15px)';
      } else {
        item.style.opacity = '1';
        item.style.transform = 'scale(1) translateY(0px)';
      }
    });

    // Animation for items fading in
    const inAnimation = animate(itemsToShow, {
      opacity: [0, 1],
      scale: [0.95, 1],
      translateY: [15, 0],
      duration: 450,
      delay: stagger(80),
      easing: 'easeOutExpo',
    });
    // Prevent the animation from playing immediately
    inAnimation.pause();

    // --- Hide Static Items ---
    itemsToHideStatically.forEach((item) => {
      item.style.display = 'none';
      item.style.opacity = '0';
    });

    // --- Create and Run Main Timeline ---
    const mainTimeline = createTimeline();

    if (outAnimation) {
      // Add the pre-defined out animation
      mainTimeline.sync(outAnimation);
      // Add the pre-defined in animation, starting slightly after the out animation begins
      mainTimeline.sync(inAnimation);
    } else {
      // If no items are animating out, start the 'in' animation immediately
      mainTimeline.sync(inAnimation);
    }

    // Play the coordinated timeline
    mainTimeline.play();

    // Update the list of currently visible items
    visibleItems = itemsToShow;
  }

  // Add event listeners to filter buttons
  filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const newFilter = button.dataset.filter;
      if (newFilter && newFilter !== currentFilter) {
        // Update active button state visually
        filterButtons.forEach((btn) => {
          btn.classList.remove('active', 'bg-white', 'text-green-800');
          btn.classList.add('bg-transparent', 'text-white'); // Reset style
        });
        button.classList.add('active', 'bg-white', 'text-green-800');
        button.classList.remove('bg-transparent', 'text-white');

        currentFilter = newFilter;
        filterAndAnimateProjects(newFilter);
      }
    });
  });

  // Initial setup: Filter and display the first set of projects ('All')
  filterAndAnimateProjects('All', true);
}
