export interface Testimonial {
  iconClass: string;
  title: string;
  name: string;
  description: string;
}

export class StackedCardTestimonials {
  private selected = 0;
  private testimonials: Testimonial[];
  private selectBtnsContainer: HTMLElement;
  private cardsContainer: HTMLElement;
  private autoAdvanceInterval: number | null = null;

  constructor(
    testimonials: Testimonial[],
    containerId = 'stacked-card-testimonials',
    autoAdvance = true,
  ) {
    this.testimonials = testimonials;

    const container = document.getElementById(containerId);
    if (!container) {
      throw new Error(`Container with ID "${containerId}" not found`);
    }

    this.selectBtnsContainer = container.querySelector('#select-btns') as HTMLElement;
    this.cardsContainer = container.querySelector('#cards-container') as HTMLElement;

    if (!this.selectBtnsContainer || !this.cardsContainer) {
      throw new Error('Required containers not found within the testimonials container');
    }

    this.init();

    if (autoAdvance) {
      this.startAutoAdvance();
    }
  }

  private init(): void {
    // Clear any existing content
    this.selectBtnsContainer.innerHTML = '';
    this.cardsContainer.innerHTML = '';

    // Initialize select buttons
    this.initSelectBtns();

    // Initialize cards
    this.initCards();

    // Initial update
    this.updateCards();
    this.updateSelectBtns();
  }

  private initSelectBtns(): void {
    for (let i = 0; i < this.testimonials.length; i++) {
      const btn = document.createElement('button');
      btn.className = 'h-1.5 w-full bg-slate-300 relative';

      const progressBar = document.createElement('span');
      progressBar.className = 'progress-bar absolute top-0 left-0 bottom-0 bg-slate-950';
      progressBar.style.width = '0%';

      btn.appendChild(progressBar);

      btn.addEventListener('click', () => {
        this.setSelected(i);
      });

      this.selectBtnsContainer.appendChild(btn);
    }
  }

  private initCards(): void {
    this.testimonials.forEach((testimonial, index) => {
      const card = document.createElement('div');
      card.className =
        'absolute top-0 left-0 w-full min-h-full p-8 lg:p-12 cursor-pointer flex flex-col justify-between';
      card.style.transformOrigin = 'left bottom';
      card.style.transition = 'transform 0.25s ease-out';
      card.style.background = index % 2 ? 'black' : 'white';
      card.style.color = index % 2 ? 'white' : 'black';

      // Icon
      const icon = document.createElement('div');
      icon.className = `text-7xl mx-auto ${testimonial.iconClass}`;

      // Description
      const description = document.createElement('p');
      description.className = 'text-lg lg:text-xl font-light italic my-8';
      description.textContent = `"${testimonial.description}"`;

      // Info container
      const infoContainer = document.createElement('div');

      // Name
      const name = document.createElement('span');
      name.className = 'block font-semibold text-lg';
      name.textContent = testimonial.name;

      // Title
      const title = document.createElement('span');
      title.className = 'block text-sm';
      title.textContent = testimonial.title;

      infoContainer.appendChild(name);
      infoContainer.appendChild(title);

      // Append all elements to card
      card.appendChild(icon);
      card.appendChild(description);
      card.appendChild(infoContainer);

      // Add hover effect
      card.addEventListener('mouseenter', () => {
        this.handleCardHover(card, true);
      });

      card.addEventListener('mouseleave', () => {
        this.handleCardHover(card, false);
      });

      // Add click event
      card.addEventListener('click', () => {
        const position = Number.parseInt(card.getAttribute('data-position') || '0', 10);
        this.setSelected(position);
      });

      this.cardsContainer.appendChild(card);
    });
  }

  private handleCardHover(card: HTMLElement, isEnter: boolean): void {
    const position = Number.parseInt(card.getAttribute('data-position') || '0', 10);

    if (position !== this.selected) {
      if (isEnter) {
        const currentTransform = card.style.transform;
        card.style.transform = `${currentTransform} translateX(-3px)`;
      } else {
        this.updateCards();
      }
    }
  }

  private updateCards(): void {
    const cards = Array.from(this.cardsContainer.children) as HTMLElement[];

    cards.forEach((card, i) => {
      const scale = i <= this.selected ? 1 : 1 + 0.015 * (i - this.selected);
      const offset = i <= this.selected ? 0 : 95 + (i - this.selected) * 3;

      card.style.zIndex = i.toString();
      card.style.transform = `translateX(${offset}%) scale(${scale})`;
      card.setAttribute('data-position', i.toString());
    });
  }

  private updateSelectBtns(): void {
    const buttons = Array.from(this.selectBtnsContainer.children) as HTMLElement[];

    buttons.forEach((btn, i) => {
      const progressBar = btn.querySelector('.progress-bar') as HTMLElement;

      if (this.selected === i) {
        // Reset animation
        progressBar.style.width = '0%';

        // Force reflow
        void progressBar.offsetWidth;

        // Start animation
        progressBar.style.width = '100%';
        progressBar.style.transition = 'width 5s linear';
      } else {
        progressBar.style.transition = 'none';
        progressBar.style.width = this.selected > i ? '100%' : '0%';
      }
    });
  }

  public setSelected(index: number): void {
    // Restart auto-advance if manually changed
    this.restartAutoAdvance();

    this.selected = index;
    this.updateCards();
    this.updateSelectBtns();
  }

  public nextSlide(): void {
    this.setSelected(this.selected === this.testimonials.length - 1 ? 0 : this.selected + 1);
  }

  public prevSlide(): void {
    this.setSelected(this.selected === 0 ? this.testimonials.length - 1 : this.selected - 1);
  }

  private startAutoAdvance(): void {
    // Clear any existing interval first
    this.stopAutoAdvance();

    // Set up progress bar transition end event for auto-advance
    const progressBars = Array.from(
      this.selectBtnsContainer.querySelectorAll('.progress-bar'),
    ) as HTMLElement[];

    progressBars.forEach((bar, index) => {
      bar.addEventListener('transitionend', () => {
        if (index === this.selected) {
          this.nextSlide();
        }
      });
    });

    // Start auto-advance for the first time
    this.updateSelectBtns();
  }

  private stopAutoAdvance(): void {
    if (this.autoAdvanceInterval) {
      window.clearInterval(this.autoAdvanceInterval);
      this.autoAdvanceInterval = null;
    }
  }

  private restartAutoAdvance(): void {
    if (this.autoAdvanceInterval) {
      this.stopAutoAdvance();
      this.startAutoAdvance();
    }
  }

  public destroy(): void {
    this.stopAutoAdvance();
    // Additional cleanup if needed
  }
}
