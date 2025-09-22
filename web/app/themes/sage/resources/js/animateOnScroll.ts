export const animateOnScroll = (className = '.animate-on-scroll'): void => {
  // Get all elements with the animate-on-scroll class
  const elements = document.querySelectorAll(className);

  // If no elements found, exit early
  if (elements.length === 0) return;

  // Configuration for the Intersection Observer
  const observerOptions = {
    root: null, // Use the viewport as the root
    rootMargin: '0px', // No margin around the root
    threshold: 0.1, // Trigger when at least 10% of the element is visible
  };

  // Create the observer
  const observer = new IntersectionObserver((entries) => {
    for (const entry of entries) {
      // When element enters viewport
      if (entry.isIntersecting) {
        // Add 'animated' class to trigger CSS animations
        entry.target.classList.add('animated');

        // Once animated, no need to observe anymore
        observer.unobserve(entry.target);
      }
    }
  }, observerOptions);

  // Start observing each element
  for (const element of elements) {
    observer.observe(element);
  }
};

/**
 * Handles both the visibility animation and counter animation for process numbers
 * Uses a single IntersectionObserver to coordinate both animations
 */
export const processNumberAnimation = () => {
  const processNumbers = document.querySelectorAll('.sop .process-number');
  const processContainers = document.querySelectorAll('.sop .animate-on-scroll');

  // Animation function to count up with overshoot effect
  const animateCounter = (element: Element, targetValue: number) => {
    // Animation duration in milliseconds
    const duration = 1500;
    // Slightly overshoot the target for visual effect
    const overshootValue = Math.min(targetValue * 10, targetValue + 3);

    let startTime: number | null = null;
    let currentValue = 0;

    element.textContent = '0';

    // Animation function using requestAnimationFrame
    const updateNumber = (timestamp: number) => {
      if (!startTime) startTime = timestamp;

      const elapsedTime = timestamp - startTime;
      const progress = Math.min(elapsedTime / duration, 1);

      // Easing function with slight overshoot
      let easedProgress: number;

      if (progress < 0.7) {
        // Accelerate up to 70% of the animation
        easedProgress = progress * 8;
      } else {
        // Simulate slight overshoot and settle back to final value
        easedProgress = 1 + Math.sin((progress - 0.7) * 5) * 0.1 * (1 - (progress - 0.7) * 3.33);
      }

      // Calculate current value
      currentValue = Math.floor(
        progress === 1 ? targetValue : targetValue + easedProgress * (overshootValue - targetValue),
      );

      // Update the element's text
      element.textContent = currentValue.toString();

      // Continue animation if not complete
      if (progress < 1) {
        requestAnimationFrame(updateNumber);
      }
    };

    // Start the animation
    requestAnimationFrame(updateNumber);
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
          // First animate the process number
          if (entry.target.classList.contains('process-number')) {
            setTimeout(() => {
              // Add visibility class for CSS animations
              entry.target.classList.add('is-visible');

              // Get the target value from the element's text content
              const targetValue = Number.parseInt(entry.target.textContent || '0', 10);
              if (!Number.isNaN(targetValue) && targetValue > 0) {
                // Start the counter animation
                animateCounter(entry.target, targetValue);
              }
            }, index * 150); // Stagger each number by 150ms
          }
          // Then animate the container
          else if (entry.target.classList.contains('animate-on-scroll')) {
            entry.target.classList.add('is-visible');
          }

          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 },
  );

  // Observe all process numbers first
  for (const number of processNumbers) {
    observer.observe(number);
  }

  // Then observe the containers
  for (const container of processContainers) {
    observer.observe(container);
  }
};
