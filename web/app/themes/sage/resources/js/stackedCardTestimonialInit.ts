import { StackedCardTestimonials } from './UI/StackedCardTestimonials';

export const stackedCardTestimonialInit = () => {
  const testimonials = [
    {
      name: 'John Doe',
      title: 'CEO, Company A',
      description: 'This is a great service!',
      icon: 'path/to/icon1.jpg',
    },
    {
      name: 'Jane Smith',
      title: 'CTO, Company B',
      description: 'I highly recommend this product.',
      icon: 'path/to/icon2.jpg',
    },
    {
      name: 'Alice Johnson',
      title: 'CMO, Company C',
      description: 'An amazing experience overall.',
      icon: 'path/to/icon3.jpg',
    },
  ];

  return new StackedCardTestimonials(testimonials);
};
