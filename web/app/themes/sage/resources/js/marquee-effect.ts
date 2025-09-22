interface Options {
  leftMarqueeDuration: number;
  rightMarqueeDuration: number;
}
export class MarqueeEffect {
  private topWrapper: HTMLElement | null;
  private bottomWrapper: HTMLElement | null;
  private readonly logoWidth: number;
  private resizeTimeout: number | null = null;

  /**
   * Initialize the MarqueeEffect
   * @param {Object} options - Configuration options
   * @param {string} options.topWrapperSelector - Selector for the top marquee wrapper
   * @param {string} options.bottomWrapperSelector - Selector for the bottom marquee wrapper
   * @param {number} options.logoWidth - Width of each logo item in pixels
   */
  constructor({
    topWrapperSelector = '.translate-wrapper',
    bottomWrapperSelector = '.translate-wrapper-reverse',
    logoWidth = 96, // 24rem = 96px by default,
    options = {
      leftMarqueeDuration: 140,
      rightMarqueeDuration: 140,
    },
  } = {}) {
    this.topWrapper = document.querySelector(topWrapperSelector);
    this.bottomWrapper = document.querySelector(bottomWrapperSelector);
    this.logoWidth = logoWidth;

    this.init(options);
  }

  /**
   * Initialize the marquee effect
   */
  private init(options: Options): void {
    if (!this.topWrapper || !this.bottomWrapper) {
      console.error('Marquee wrappers not found');
      return;
    }

    // Add a small delay to ensure DOM is fully loaded
    setTimeout(() => {
      this.setupMarquees(options);
      this.setupResizeHandler(options);
    }, 100);
  }

  /**
   * Set up both marquees
   */
  private setupMarquees(options: Options): void {
    if (this.topWrapper) this.cloneAndRandomize(this.topWrapper);
    if (this.bottomWrapper) this.cloneAndRandomize(this.bottomWrapper);
    const { leftMarqueeDuration, rightMarqueeDuration } = options;
    this.setupAnimation(leftMarqueeDuration, rightMarqueeDuration);
  }

  /**
   * Clone and randomize logos in a wrapper
   * @param {HTMLElement} wrapper - The marquee wrapper element
   */
  private cloneAndRandomize(wrapper: HTMLElement): void {
    // Get all logo items in the wrapper
    const logoItems = Array.from(wrapper.querySelectorAll('a'));
    if (!logoItems.length) {
      console.error('No logo items found in wrapper', wrapper);
      return;
    }

    console.log(`Found ${logoItems.length} original logos`);

    // Store original logos to keep them for reference
    const originalLogos = logoItems.map((item) => item.cloneNode(true) as HTMLElement);

    // Calculate how many sets we need to create an endless effect
    // Use a minimum of 2 sets regardless of screen width
    const screenWidth = window.innerWidth;
    const totalWidth = logoItems.length * this.logoWidth;
    const setsNeeded = Math.max(2, Math.ceil((screenWidth * 3) / totalWidth));

    console.log(`Creating ${setsNeeded} sets of logos`);

    // Keep original logos as the first set and add duplicates
    // Instead of clearing, we'll just append additional sets
    const originalSet = logoItems.map((item) => item.cloneNode(true) as HTMLElement);

    // First ensure we're starting with just one set of logos
    if (wrapper.children.length > originalSet.length) {
      wrapper.innerHTML = '';
      for (const logo of originalSet) {
        wrapper.appendChild(logo);
      }
    }

    // Now add additional sets
    for (let i = 0; i < setsNeeded; i++) {
      // Clone and shuffle the original logos for each set
      const shuffledLogos = [...originalLogos]
        .map((logo) => logo.cloneNode(true) as HTMLElement)
        .sort(() => Math.random() - 0.5);

      for (const logo of shuffledLogos) {
        wrapper.appendChild(logo);
      }
    }

    console.log(`Wrapper now has ${wrapper.children.length} logos`);
  }

  /**
   * Set up animation effect for continuous scrolling
   */
  private setupAnimation(leftMarqueeDuration: number, rightMarqueeDuration: number): void {
    if (!this.topWrapper || !this.bottomWrapper) return;

    this.setMarqueeAnimation(this.topWrapper, 'left', leftMarqueeDuration);
    this.setMarqueeAnimation(this.bottomWrapper, 'right', rightMarqueeDuration);
  }

  /**
   * Set up marquee animation for a specific wrapper
   * @param {HTMLElement} wrapper - The wrapper element
   * @param {'left' | 'right'} direction - The scroll direction
   * @param {number} duration - Animation duration in seconds
   */
  private setMarqueeAnimation(
    wrapper: HTMLElement,
    direction: 'left' | 'right',
    duration: number,
  ): void {
    const items = wrapper.querySelectorAll('a');
    const totalWidth = items.length * this.logoWidth;

    // Make sure we preserve padding and gaps from your original CSS
    wrapper.style.display = 'flex';
    // Don't override existing styles that might be needed
    if (!wrapper.style.gap) wrapper.style.gap = '1rem';
    if (!wrapper.style.paddingLeft) wrapper.style.paddingLeft = '0.5rem';
    if (!wrapper.style.paddingRight) wrapper.style.paddingRight = '0.5rem';

    wrapper.style.width = `${totalWidth}px`;
    wrapper.style.animation = `marquee${direction === 'left' ? 'Left' : 'Right'} ${duration}s linear infinite`;

    // Ensure the wrapper has proper overflow handling
    wrapper.style.overflowX = 'hidden';
    wrapper.style.whiteSpace = 'nowrap';
  }

  /**
   * Set up window resize handler
   */
  private setupResizeHandler(options: Options): void {
    window.addEventListener('resize', () => {
      // Debounce resize event
      if (this.resizeTimeout) {
        window.clearTimeout(this.resizeTimeout);
      }

      this.resizeTimeout = window.setTimeout(() => {
        this.setupMarquees(options);
      }, 250);
    });
  }

  /**
   * Pause the marquee animation
   */
  public pause(): void {
    if (this.topWrapper) this.topWrapper.style.animationPlayState = 'paused';
    if (this.bottomWrapper) this.bottomWrapper.style.animationPlayState = 'paused';
  }

  /**
   * Resume the marquee animation
   */
  public resume(): void {
    if (this.topWrapper) this.topWrapper.style.animationPlayState = 'running';
    if (this.bottomWrapper) this.bottomWrapper.style.animationPlayState = 'running';
  }

  /**
   * Change animation speed
   * @param {number} duration - New duration in seconds
   */
  public setSpeed(duration: number): void {
    if (this.topWrapper && this.bottomWrapper) {
      this.setMarqueeAnimation(this.topWrapper, 'left', duration);
      this.setMarqueeAnimation(this.bottomWrapper, 'right', duration);
    }
  }

  /**
   * Clean up event listeners and resources
   */
  public destroy(): void {
    if (this.resizeTimeout) {
      window.clearTimeout(this.resizeTimeout);
    }

    if (this.topWrapper) {
      this.topWrapper.style.animation = '';
      this.topWrapper.style.width = '';
    }

    if (this.bottomWrapper) {
      this.bottomWrapper.style.animation = '';
      this.bottomWrapper.style.width = '';
    }
  }
}
