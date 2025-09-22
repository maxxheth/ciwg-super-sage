export interface ModalOptions {
  onOpen?: () => void;
  onClose?: () => void;
  preventScroll?: boolean;
  closeOnEscape?: boolean;
  closeOnBackdropClick?: boolean;
}

export interface ModalInterface {
  element: HTMLElement;
  closeButton?: HTMLElement | null;
  backdrop?: HTMLElement | null;
  options?: ModalOptions;
  init(): void;
  open(): void;
  close(): void;
  isOpen(): boolean;
  toggle(): void;
}

export class Modal implements ModalInterface {
  element: HTMLElement;
  closeButton?: HTMLElement | null;
  backdrop?: HTMLElement | null;
  options?: ModalOptions;

  constructor(elementId: string, options: ModalOptions = {}) {
    this.element = document.getElementById(elementId) as HTMLElement;

    if (!this.element) {
      console.error(`Modal with ID "${elementId}" not found`);
      return;
    }

    this.closeButton = this.element.querySelector('.modal-close');
    this.backdrop = this.element.querySelector('.modal-backdrop');

    this.options = {
      preventScroll: true,
      closeOnEscape: true,
      closeOnBackdropClick: true,
      ...options,
    };

    this.init();
  }

  init(): void {
    // Set up close button
    if (this.closeButton) {
      this.closeButton.addEventListener('click', () => this.close());
    }

    // Set up backdrop click
    if (this.backdrop && this.options?.closeOnBackdropClick) {
      this.backdrop.addEventListener('click', () => this.close());
    }

    // Set up escape key
    if (this.options?.closeOnEscape) {
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && this.isOpen()) {
          this.close();
        }
      });
    }
  }

  open(): void {
    this.element.classList.remove('hidden');
    this.element.classList.add('flex');

    if (this.options?.preventScroll) {
      document.body.style.overflow = 'hidden';
    }

    // Optional callback
    if (this.options?.onOpen) {
      this.options.onOpen();
    }
  }

  close(): void {
    this.element.classList.add('hidden');
    this.element.classList.remove('flex');

    if (this.options?.preventScroll) {
      document.body.style.overflow = '';
    }

    // Optional callback
    if (this.options?.onClose) {
      this.options.onClose();
    }
  }

  isOpen(): boolean {
    return !this.element.classList.contains('hidden');
  }

  toggle(): void {
    if (this.isOpen()) {
      this.close();
    } else {
      this.open();
    }
  }
}

export function initModal(elementId: string, options: ModalOptions = {}): Modal {
  return new Modal(elementId, options);
}
