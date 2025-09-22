interface IconData {
  imagePath: string;
  className: string;
}

interface SizeConfig {
  sm: number;
  md: number;
  lg: number;
}

interface StyleConfig {
  container?: string;
  outerCircle?: string;
  centerLogoWrapper?: string;
  iconWrapper?: string;
}

interface AnimationConfig {
  outerCircleAnimation?: string;
  centerLogoAnimation?: string;
  animationDuration?: string;
  fadeInDuration?: string;
  fadeOutDuration?: string;
  sequentialDisplay?: boolean;
  displayOrder?: 'clockwise' | 'counter-clockwise' | 'random';
  displayDelay?: string;
}

interface LogosConfig {
  icons?: IconData[];
  centerLogo?: {
    text?: string;
    imagePath?: string;
    className?: string;
  };
  sizes?: {
    radiusToCenterOfIcons?: Partial<SizeConfig>;
    iconWrapperWidth?: Partial<SizeConfig>;
    ringPadding?: Partial<SizeConfig>;
    logoFontSize?: Partial<SizeConfig>;
    centerLogoSize?: Partial<SizeConfig>;
  };
  styles?: StyleConfig;
  animations?: AnimationConfig;
}

export class SpinningLogo {
  private rootElement: HTMLElement;
  private outerCircle: HTMLElement | null = null;
  private centerLogo: HTMLElement | null = null;
  private iconWrappers: HTMLElement[] = [];
  private centerIcons: HTMLElement[] = [];
  private activeIconIndex = -1;
  private displayTimeout: number | null = null;
  private centerDisplayArea: HTMLElement | null = null;

  private BREAKPOINTS = {
    sm: 480,
    md: 845,
  };

  private RADIUS_TO_CENTER_OF_ICONS: SizeConfig = {
    sm: 200,
    md: 325,
    lg: 425,
  };

  private ICON_WRAPPER_WIDTH: SizeConfig = {
    sm: 40,
    md: 65,
    lg: 80,
  };

  private RING_PADDING: SizeConfig = {
    sm: 4,
    md: 8,
    lg: 12,
  };

  private LOGO_FONT_SIZE: SizeConfig = {
    sm: 18,
    md: 24,
    lg: 36,
  };

  private CENTER_LOGO_SIZE: SizeConfig = {
    sm: 80,
    md: 120,
    lg: 160,
  };

  private ICONS: IconData[] = [
    {
      imagePath: '/path/to/your/logo1.png',
      className: 'bg-[#0766FF] text-white',
    },
    {
      imagePath: '/path/to/your/logo2.png',
      className: 'bg-[#FF0200] text-white',
    },
    {
      imagePath: '/path/to/your/logo3.png',
      className: 'bg-[#A101FF] text-white',
    },
    {
      imagePath: '/path/to/your/logo4.png',
      className: 'bg-[#CE0E03] text-white',
    },
    {
      imagePath: '/path/to/your/logo5.png',
      className: 'bg-[#FF4500] text-white',
    },
    {
      imagePath: '/path/to/your/logo6.png',
      className: 'bg-[#0052FF] text-white',
    },
    {
      imagePath: '/path/to/your/logo7.png',
      className: 'bg-[#F96C59] text-white',
    },
  ];

  private centerLogoConfig = {
    text: 'YOUR LOGO',
    imagePath: '',
    className: 'text-neutral-900',
  };

  private styles = {
    container: 'grid place-content-center rounded-full bg-neutral-100 shadow-inner',
    outerCircle: 'relative grid place-items-center rounded-full bg-white shadow spin-clockwise',
    centerLogoWrapper: 'spin-counter-clockwise',
    iconWrapper:
      'absolute grid place-content-center rounded-full shadow-lg spin-counter-clockwise p-2 bg-white',
  };

  private animations: AnimationConfig = {
    outerCircleAnimation: 'spin-clockwise',
    centerLogoAnimation: 'spin-counter-clockwise',
    animationDuration: '60s',
    fadeInDuration: '1s',
    fadeOutDuration: '1s',
    sequentialDisplay: false,
    displayOrder: 'clockwise',
    displayDelay: '3s',
  };

  private sizes = {
    radiusToCenterOfIcons: this.RADIUS_TO_CENTER_OF_ICONS.lg,
    iconWrapperWidth: this.ICON_WRAPPER_WIDTH.lg,
    ringPadding: this.RING_PADDING.lg,
    logoFontSize: this.LOGO_FONT_SIZE.lg,
    centerLogoSize: this.CENTER_LOGO_SIZE.lg,
  };

  constructor(rootElementId: string, config?: LogosConfig) {
    const rootElement = document.getElementById(rootElementId);

    if (!rootElement) {
      // throw new Error(`Root element with ID "${rootElementId}" not found.`);
      return;
    }

    this.rootElement = rootElement;

    if (config) {
      this.applyConfig(config);
    } else {
      this.tryLoadConfigFromHead();
    }

    this.init();
  }

  private applyConfig(config: LogosConfig): void {
    if (config.icons && config.icons.length > 0) {
      this.ICONS = config.icons;
    }

    if (config.centerLogo) {
      if (config.centerLogo.text) {
        this.centerLogoConfig.text = config.centerLogo.text;
      }
      if (config.centerLogo.imagePath) {
        this.centerLogoConfig.imagePath = config.centerLogo.imagePath;
      }
      if (config.centerLogo.className) {
        this.centerLogoConfig.className = config.centerLogo.className;
      }
    }

    if (config.sizes) {
      if (config.sizes.radiusToCenterOfIcons) {
        this.RADIUS_TO_CENTER_OF_ICONS = {
          ...this.RADIUS_TO_CENTER_OF_ICONS,
          ...config.sizes.radiusToCenterOfIcons,
        };
      }

      if (config.sizes.iconWrapperWidth) {
        this.ICON_WRAPPER_WIDTH = {
          ...this.ICON_WRAPPER_WIDTH,
          ...config.sizes.iconWrapperWidth,
        };
      }

      if (config.sizes.ringPadding) {
        this.RING_PADDING = {
          ...this.RING_PADDING,
          ...config.sizes.ringPadding,
        };
      }

      if (config.sizes.logoFontSize) {
        this.LOGO_FONT_SIZE = {
          ...this.LOGO_FONT_SIZE,
          ...config.sizes.logoFontSize,
        };
      }

      if (config.sizes.centerLogoSize) {
        this.CENTER_LOGO_SIZE = {
          ...this.CENTER_LOGO_SIZE,
          ...config.sizes.centerLogoSize,
        };
      }
    }

    if (config.styles) {
      if (config.styles.container) {
        this.styles.container = config.styles.container;
      }

      if (config.styles.outerCircle) {
        this.styles.outerCircle = config.styles.outerCircle;
      }

      if (config.styles.centerLogoWrapper) {
        this.styles.centerLogoWrapper = config.styles.centerLogoWrapper;
      }

      if (config.styles.iconWrapper) {
        this.styles.iconWrapper = config.styles.iconWrapper;
      }
    }

    if (config.animations) {
      this.animations = {
        ...this.animations,
        ...config.animations,
      };
    }
  }

  private tryLoadConfigFromHead(): void {
    const scriptElement = document.getElementById('spinningLogoData');
    if (scriptElement?.textContent) {
      try {
        const logosData = JSON.parse(scriptElement.textContent);
        const icons: IconData[] = [];
        let centerLogo = null;

        if (logosData._config) {
          if (logosData._config.styles) {
            this.styles = {
              ...this.styles,
              ...logosData._config.styles,
            };
          }

          if (logosData._config.animations) {
            this.animations = {
              ...this.animations,
              ...logosData._config.animations,
            };
          }

          if (logosData._config.sizes) {
            const sizesConfig = logosData._config.sizes;

            if (sizesConfig.radiusToCenterOfIcons) {
              this.RADIUS_TO_CENTER_OF_ICONS = {
                ...this.RADIUS_TO_CENTER_OF_ICONS,
                ...sizesConfig.radiusToCenterOfIcons,
              };
            }

            if (sizesConfig.iconWrapperWidth) {
              this.ICON_WRAPPER_WIDTH = {
                ...this.ICON_WRAPPER_WIDTH,
                ...sizesConfig.iconWrapperWidth,
              };
            }

            if (sizesConfig.ringPadding) {
              this.RING_PADDING = {
                ...this.RING_PADDING,
                ...sizesConfig.ringPadding,
              };
            }

            if (sizesConfig.logoFontSize) {
              this.LOGO_FONT_SIZE = {
                ...this.LOGO_FONT_SIZE,
                ...sizesConfig.logoFontSize,
              };
            }

            if (sizesConfig.centerLogoSize) {
              this.CENTER_LOGO_SIZE = {
                ...this.CENTER_LOGO_SIZE,
                ...sizesConfig.centerLogoSize,
              };
            }
          }
        }

        for (const key in logosData) {
          if (key === '_config') continue;

          const logo = logosData[key];

          if (key === 'centerLogo' || logo.isCenter) {
            centerLogo = {
              text: logo.text || '',
              imagePath: logo.url || '',
              className: logo.className || 'text-neutral-900',
            };
          } else {
            icons.push({
              imagePath: logo.url,
              className: logo.className || 'bg-neutral-500 text-white',
            });
          }
        }

        if (centerLogo) {
          this.centerLogoConfig = centerLogo;
        }

        if (icons.length > 0) {
          this.ICONS = icons;
        }
      } catch (e) {
        console.error('Error parsing spinning logo data:', e);
      }
    }
  }

  private init(): void {
    this.updateSizes();
    this.render();

    window.addEventListener('resize', () => {
      this.updateSizes();
      this.render();
    });

    this.addAnimationStyles();
  }

  private addAnimationStyles(): void {
    if (document.getElementById('spinning-logos-styles')) {
      return;
    }

    const styleElement = document.createElement('style');
    styleElement.id = 'spinning-logos-styles';

    const duration = this.animations.animationDuration;

    styleElement.textContent = `
            @keyframes spin-clockwise {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            @keyframes spin-counter-clockwise {
                from { transform: rotate(0deg); }
                to { transform: rotate(-360deg); }
            }

            .spin-clockwise {
                animation: spin-clockwise ${duration} linear infinite;
            }

            .spin-counter-clockwise {
                animation: spin-counter-clockwise ${duration} linear infinite;
            }

            .paused {
                animation-play-state: paused;
            }
        `;

    document.head.appendChild(styleElement);
  }

  private updateSizes(): void {
    const width = window.innerWidth;

    if (width < this.BREAKPOINTS.sm) {
      this.sizes = {
        radiusToCenterOfIcons: this.RADIUS_TO_CENTER_OF_ICONS.sm,
        iconWrapperWidth: this.ICON_WRAPPER_WIDTH.sm,
        ringPadding: this.RING_PADDING.sm,
        logoFontSize: this.LOGO_FONT_SIZE.sm,
        centerLogoSize: this.CENTER_LOGO_SIZE.sm,
      };
    } else if (width < this.BREAKPOINTS.md) {
      this.sizes = {
        radiusToCenterOfIcons: this.RADIUS_TO_CENTER_OF_ICONS.md,
        iconWrapperWidth: this.ICON_WRAPPER_WIDTH.md,
        ringPadding: this.RING_PADDING.md,
        logoFontSize: this.LOGO_FONT_SIZE.md,
        centerLogoSize: this.CENTER_LOGO_SIZE.md,
      };
    } else {
      this.sizes = {
        radiusToCenterOfIcons: this.RADIUS_TO_CENTER_OF_ICONS.lg,
        iconWrapperWidth: this.ICON_WRAPPER_WIDTH.lg,
        ringPadding: this.RING_PADDING.lg,
        logoFontSize: this.LOGO_FONT_SIZE.lg,
        centerLogoSize: this.CENTER_LOGO_SIZE.lg,
      };
    }
  }

  private render(): void {
    this.rootElement.innerHTML = '';

    const containerWidth =
      this.sizes.radiusToCenterOfIcons + this.sizes.iconWrapperWidth + this.sizes.ringPadding;
    const containerHeight =
      this.sizes.radiusToCenterOfIcons + this.sizes.iconWrapperWidth + this.sizes.ringPadding;

    const container = document.createElement('div');
    container.className = this.styles.container;
    container.style.width = `${containerWidth}px`;
    container.style.height = `${containerHeight}px`;

    const outerCircleWidth =
      this.sizes.radiusToCenterOfIcons - this.sizes.iconWrapperWidth - this.sizes.ringPadding;
    const outerCircleHeight =
      this.sizes.radiusToCenterOfIcons - this.sizes.iconWrapperWidth - this.sizes.ringPadding;

    this.outerCircle = document.createElement('div');
    this.outerCircle.className = `${this.styles.outerCircle} ${this.animations.outerCircleAnimation}`;
    this.outerCircle.style.width = `${outerCircleWidth}px`;
    this.outerCircle.style.height = `${outerCircleHeight}px`;

    this.outerCircle.addEventListener('mouseenter', () => this.pauseAnimation());
    this.outerCircle.addEventListener('mouseleave', () => this.resumeAnimation());

    this.centerDisplayArea = document.createElement('div');
    this.centerDisplayArea.className = 'center-display-area';
    this.centerDisplayArea.style.position = 'absolute';
    this.centerDisplayArea.style.top = '50%';
    this.centerDisplayArea.style.left = '50%';
    this.centerDisplayArea.style.transform = 'translate(-50%, -50%)';
    this.centerDisplayArea.style.width = `${this.sizes.centerLogoSize}px`;
    this.centerDisplayArea.style.height = `${this.sizes.centerLogoSize}px`;
    this.centerDisplayArea.style.display = 'flex';
    this.centerDisplayArea.style.alignItems = 'center';
    this.centerDisplayArea.style.justifyContent = 'center';
    this.centerDisplayArea.style.zIndex = '10';
    this.centerDisplayArea.style.pointerEvents = 'none'; // Let mouse events pass through

    // Add the outer spinning icons
    this.createSpinningOuterIcons();

    // Add the outer circle to the container
    container.appendChild(this.outerCircle);

    // Create center logo or sequential icons based on configuration
    if (this.animations.sequentialDisplay) {
      // Prepare the icons for sequential display in the center
      this.centerIcons = [];

      for (let i = 0; i < this.ICONS.length; i++) {
        const icon = this.ICONS[i];

        const iconElement = document.createElement('div');
        iconElement.className = `center-icon ${icon.className}`;
        iconElement.style.width = '100%';
        iconElement.style.height = '100%';
        iconElement.style.display = 'flex';
        iconElement.style.alignItems = 'center';
        iconElement.style.justifyContent = 'center';
        iconElement.style.opacity = '0';
        iconElement.style.visibility = 'hidden';
        iconElement.style.position = 'absolute';
        iconElement.style.top = '0';
        iconElement.style.left = '0';
        iconElement.style.transition = `opacity ${this.animations.fadeInDuration} ease-in, opacity ${this.animations.fadeOutDuration} ease-out`;
        iconElement.style.borderRadius = '50%';

        const img = document.createElement('img');
        img.src = icon.imagePath;
        img.alt = 'Logo';
        img.style.maxWidth = '80%';
        img.style.maxHeight = '80%';
        img.style.objectFit = 'contain';

        iconElement.appendChild(img);
        this.centerDisplayArea.appendChild(iconElement);
        this.centerIcons.push(iconElement);
      }

      // Add the center display area directly to the container, NOT the outer circle
      // This prevents it from inheriting the spin animation
      container.appendChild(this.centerDisplayArea);

      // Start the sequential display after a short delay
      setTimeout(() => this.startSequentialDisplay(), 100);
    } else {
      // Traditional center logo display - now outside the spinning circle
      this.centerLogo = document.createElement('div');
      this.centerLogo.className = `${this.centerLogoConfig.className}`;
      this.centerLogo.style.position = 'absolute';
      this.centerLogo.style.top = '50%';
      this.centerLogo.style.left = '50%';
      this.centerLogo.style.transform = 'translate(-50%, -50%)';
      this.centerLogo.style.zIndex = '10';
      this.centerLogo.style.pointerEvents = 'none';

      if (this.centerLogoConfig.imagePath) {
        const centerLogoImg = document.createElement('img');
        centerLogoImg.src = this.centerLogoConfig.imagePath;
        centerLogoImg.alt = this.centerLogoConfig.text || 'Center Logo';
        centerLogoImg.style.width = `${this.sizes.centerLogoSize}px`;
        centerLogoImg.style.height = 'auto';
        centerLogoImg.style.maxWidth = '100%';
        centerLogoImg.style.maxHeight = '100%';
        centerLogoImg.style.objectFit = 'contain';

        this.centerLogo.appendChild(centerLogoImg);
      } else {
        this.centerLogo.textContent = this.centerLogoConfig.text;
        this.centerLogo.classList.add('font-bold', 'uppercase');
        this.centerLogo.style.fontSize = `${this.sizes.logoFontSize}px`;
      }

      // Add the center logo directly to the container
      container.appendChild(this.centerLogo);
    }

    this.rootElement.appendChild(container);
  }

  private createSpinningOuterIcons(): void {
    this.iconWrappers = [];

    for (let i = 0; i < this.ICONS.length; i++) {
      const icon = this.ICONS[i];
      const degrees = (360 / this.ICONS.length) * i;
      const radians = this.degreesToRadians(degrees);

      const marginTop = this.sizes.radiusToCenterOfIcons * Math.sin(radians);
      const marginLeft = this.sizes.radiusToCenterOfIcons * Math.cos(radians);

      const iconWrapper = document.createElement('div');
      iconWrapper.className = `${this.styles.iconWrapper} spin-counter-clockwise ${icon.className}`;
      iconWrapper.style.marginTop = `${marginTop}px`;
      iconWrapper.style.marginLeft = `${marginLeft}px`;
      iconWrapper.style.width = `${this.sizes.iconWrapperWidth}px`;
      iconWrapper.style.height = `${this.sizes.iconWrapperWidth}px`;

      const img = document.createElement('img');
      img.src = icon.imagePath;
      img.alt = 'Logo';
      img.style.maxWidth = '100%';
      img.style.maxHeight = '100%';
      img.style.objectFit = 'contain';
      img.style.borderRadius = '100%';

      iconWrapper.appendChild(img);
      this.outerCircle?.appendChild(iconWrapper);
      this.iconWrappers.push(iconWrapper);
    }
  }

  private startSequentialDisplay(): void {
    if (!this.animations.sequentialDisplay || this.centerIcons.length === 0) return;

    if (this.displayTimeout) {
      window.clearTimeout(this.displayTimeout);
    }

    let iconOrder: number[] = Array.from({ length: this.centerIcons.length }, (_, i) => i);

    if (this.animations.displayOrder === 'counter-clockwise') {
      iconOrder = iconOrder.reverse();
    } else if (this.animations.displayOrder === 'random') {
      for (let i = iconOrder.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [iconOrder[i], iconOrder[j]] = [iconOrder[j], iconOrder[i]];
      }
    }

    this.activeIconIndex = -1;
    this.displayNextIcon(iconOrder);
  }

  private displayNextIcon(order: number[]): void {
    this.activeIconIndex = (this.activeIconIndex + 1) % order.length;
    const iconIndex = order[this.activeIconIndex];
    const icon = this.centerIcons[iconIndex];

    // this.centerIcons.forEach((centerIcon) => {
    for (const centerIcon of this.centerIcons) {
      centerIcon.style.opacity = '0';
      centerIcon.style.visibility = 'hidden';
    }

    icon.style.visibility = 'visible';
    setTimeout(() => {
      icon.style.opacity = '1';
    }, 50);

    const displayDuration = Number.parseFloat(this.animations?.displayDelay ?? '1') * 1000;
    const fadeOutDuration = Number.parseFloat(this.animations?.fadeOutDuration ?? '1') * 1000;

    this.displayTimeout = window.setTimeout(() => {
      icon.style.opacity = '0';

      this.displayTimeout = window.setTimeout(() => {
        icon.style.visibility = 'hidden';
        this.displayNextIcon(order);
      }, fadeOutDuration);
    }, displayDuration);
  }

  private pauseAnimation(): void {
    if (this.outerCircle) {
      this.outerCircle.classList.add('paused');
    }

    for (const iconWrapper of this.iconWrappers) {
      iconWrapper.classList.add('paused');
    }

    if (this.displayTimeout) {
      window.clearTimeout(this.displayTimeout);
    }
  }

  private resumeAnimation(): void {
    if (this.outerCircle) {
      this.outerCircle.classList.remove('paused');
    }

    for (const iconWrapper of this.iconWrappers) {
      iconWrapper.classList.remove('paused');
    }

    if (this.animations.sequentialDisplay) {
      this.startSequentialDisplay();
    }
  }

  public destroy(): void {
    if (this.displayTimeout) {
      window.clearTimeout(this.displayTimeout);
    }

    if (this.outerCircle) {
      this.outerCircle.removeEventListener('mouseenter', () => this.pauseAnimation());
      this.outerCircle.removeEventListener('mouseleave', () => this.resumeAnimation());
    }
  }

  private degreesToRadians(degrees: number): number {
    return degrees * (Math.PI / 180);
  }
}
