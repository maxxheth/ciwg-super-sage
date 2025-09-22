interface Testimonial {
  icon: string;
  title: string;
  name: string;
  description: string;
}

export class StackedCardTestimonials {
  private testimonials: Testimonial[];
  private selected = 0;
  private autoRotateTimer: number | null = null;
  private progressAnimation: Animation | null = null;
  private readonly animationDuration: number = 5000; // 5s in ms
  private isPaused = false;

  constructor(testimonials: Testimonial[] | string) {
    this.testimonials = typeof testimonials === 'string' ? JSON.parse(testimonials) : testimonials;
    this.init();
  }

  private init(): void {
    this.setupEventListeners();
    this.updateCards();
    this.startProgressAnimation();
  }

  private setupEventListeners(): void {
    const buttons = document.querySelectorAll<HTMLButtonElement>('#testimonial-buttons button');
    for (const button of buttons) {
      button.addEventListener('click', () => {
        const index = Number.parseInt(button.getAttribute('data-index') || '0');
        this.setSelected(index);
      });

      // Pause on hover for better UX
      button.addEventListener('mouseenter', () => this.pause());
      button.addEventListener('mouseleave', () => this.resume());
    }

    const cards = document.querySelectorAll<HTMLDivElement>('#testimonial-cards > div');
    for (const card of cards) {
      card.addEventListener('mouseenter', () => {
        const position = Number.parseInt(card.getAttribute('data-index') || '0');
        if (position !== this.selected) {
          const currentTransform = card.style.transform;
          card.style.transform = currentTransform.replace(
            /translateX\(([^)]+)\)/,
            'translateX(calc($1 - 3%))',
          );
        }
      });

      card.addEventListener('mouseleave', () => {
        this.updateCards();
      });
    }
  }

  private setSelected(index: number): void {
    this.selected = index;
    this.updateCards();
    this.restartProgressAnimation();
  }

  private updateCards(): void {
    const cards = document.querySelectorAll<HTMLDivElement>('#testimonial-cards > div');

    for (const [position, card] of Array.from(cards).entries()) {
      const scale = position <= this.selected ? 1 : 1 + 0.015 * (position - this.selected);
      const offset = position <= this.selected ? 0 : 95 + (position - this.selected) * 3;

      card.style.transform = `scale(${scale}) translateX(${offset}%)`;
      card.style.transitionDuration = '300ms';
    }
  }

  private startProgressAnimation(): void {
    const progressBar = document.querySelector<HTMLSpanElement>(
      `[data-progress="${this.selected}"]`,
    );
    if (!progressBar) return;

    // Reset all progress bars
    const progressBars = document.querySelectorAll<HTMLSpanElement>('[data-progress]');

    for (const bar of progressBars) {
      bar.style.width = '0%';
    }

    // Create new animation
    this.progressAnimation = progressBar.animate([{ width: '0%' }, { width: '100%' }], {
      duration: this.animationDuration,
      fill: 'forwards',
      easing: 'linear',
    });

    this.progressAnimation.onfinish = () => {
      const nextIndex = (this.selected + 1) % this.testimonials.length;
      this.setSelected(nextIndex);
    };
  }

  private restartProgressAnimation(): void {
    if (this.progressAnimation) {
      this.progressAnimation.cancel();
    }
    this.startProgressAnimation();
  }

  private pause(): void {
    if (this.progressAnimation && !this.isPaused) {
      this.progressAnimation.pause();
      this.isPaused = true;
    }
  }

  private resume(): void {
    if (this.progressAnimation && this.isPaused) {
      this.progressAnimation.play();
      this.isPaused = false;
    }
  }

  public destroy(): void {
    if (this.progressAnimation) {
      this.progressAnimation.cancel();
    }
    if (this.autoRotateTimer) {
      clearTimeout(this.autoRotateTimer);
    }
  }
}
