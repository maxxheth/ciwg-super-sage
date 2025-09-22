interface ParallaxOptions {
  speed: number;
  reverse?: boolean;
}

export class VanillaParallax {
  private wrappers: HTMLElement[] = [];
  private scrollY: number = 0;
  private windowHeight: number = 0;
  private ticking: boolean = false;
  private options: Map<HTMLElement, ParallaxOptions> = new Map();
  private serviceItems: Map<HTMLElement, HTMLElement> = new Map();
  private serviceBounds: Map<HTMLElement, DOMRect> = new Map();

  constructor() {
    // Initialize
    this.init();

    // Event listeners
    window.addEventListener('scroll', this.handleScroll.bind(this), { passive: true });
    window.addEventListener('resize', this.handleResize.bind(this), { passive: true });

    // Initial position calculation
    this.calculatePositions();
  }

  public init(): void {
    // Get all parallax wrappers
    const wrappers = document.querySelectorAll(
      '.parallax-image-wrapper',
    ) as NodeListOf<HTMLElement>;

    // Reset collections
    this.wrappers = [];
    this.options.clear();
    this.serviceItems.clear();
    this.serviceBounds.clear();

    // Store wrappers and their options
    wrappers.forEach((wrapper) => {
      this.wrappers.push(wrapper);

      // Find the image inside for data attributes
      const img = wrapper.querySelector('.parallax-image') as HTMLElement;

      // Find the service item container
      const serviceItem = wrapper.closest('.service-item') as HTMLElement;
      if (serviceItem) {
        this.serviceItems.set(wrapper, serviceItem);
        this.serviceBounds.set(serviceItem, serviceItem.getBoundingClientRect());
      }

      // Get data attributes from the image
      const speed = img ? parseFloat(img.dataset.parallaxSpeed || '0.2') : 0.2;
      const reverse = img ? img.dataset.parallaxReverse === 'true' : false;

      // Store options on the wrapper
      this.options.set(wrapper, {
        speed,
        reverse,
      });
    });

    // Get initial window measurements
    this.windowHeight = window.innerHeight;
    this.scrollY = window.scrollY;
  }

  private calculatePositions(): void {
    this.wrappers.forEach((wrapper) => {
      // Get service item bounds
      const serviceItem = this.serviceItems.get(wrapper);
      if (serviceItem) {
        // Update bounds each time to account for accordion changes
        this.serviceBounds.set(serviceItem, serviceItem.getBoundingClientRect());
      }

      // Calculate and apply transform
      this.applyParallax(wrapper);
    });
  }

  private handleScroll(): void {
    this.scrollY = window.scrollY;

    // Throttle calculations using requestAnimationFrame
    if (!this.ticking) {
      window.requestAnimationFrame(() => {
        this.calculatePositions();
        this.ticking = false;
      });

      this.ticking = true;
    }
  }

  private handleResize(): void {
    this.windowHeight = window.innerHeight;

    // Recalculate all bounds
    this.wrappers.forEach((wrapper) => {
      const serviceItem = this.serviceItems.get(wrapper);
      if (serviceItem) {
        this.serviceBounds.set(serviceItem, serviceItem.getBoundingClientRect());
      }
    });

    this.calculatePositions();
  }

  private applyParallax(wrapper: HTMLElement): void {
    const serviceItem = this.serviceItems.get(wrapper);
    if (!serviceItem) return;

    const serviceBounds = this.serviceBounds.get(serviceItem);
    const options = this.options.get(wrapper);

    if (!serviceBounds || !options) return;

    // Only apply parallax if service item is visible
    if (serviceBounds.bottom < 0 || serviceBounds.top > this.windowHeight) {
      return;
    }

    // Calculate service item's position relative to viewport
    const serviceHeight = serviceBounds.height;
    const serviceTop = serviceBounds.top;

    // Calculate the progress of the service item through the viewport
    const progress = (this.windowHeight - serviceTop) / (this.windowHeight + serviceHeight);

    // Determine movement range in pixels
    const maxMovement = serviceHeight * 0.3 * options.speed;

    // Calculate parallax offset - centered around the middle of the container
    let parallaxOffset = (progress - 0.5) * maxMovement * 2;

    // Reverse if needed
    if (options.reverse) {
      parallaxOffset *= -1;
    }

    // Apply transform to the wrapper
    wrapper.style.transform = `translateY(${parallaxOffset}px)`;
  }

  // Public method to refresh calculations
  public refresh(): void {
    this.init();
    this.calculatePositions();
  }
}
