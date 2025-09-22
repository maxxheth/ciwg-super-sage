// Counter animation function (replaces React AnimatedCounter)
export const counterInit = () => {
  const counters = document.querySelectorAll('.counter-value');

  for (const counter of counters) {
    const target = Number.parseInt(counter.getAttribute('data-count') || '0');
    const duration = Number.parseInt(counter.getAttribute('data-duration') || '2');
    let count = 0;

    const observer = new IntersectionObserver(
      (entries) => {
        for (const entry of entries) {
          if (entry.isIntersecting) {
            const increment = Math.ceil(target / (duration * 10));
            const timer = setInterval(() => {
              count += increment;
              counter.textContent = count?.toString() || '0';

              if (count >= target) {
                counter.textContent = target?.toString() || '0';
                clearInterval(timer);
              }
            }, 100);

            observer.unobserve(entry.target);
          }
        }
      },
      { threshold: 0.5 },
    );

    observer.observe(counter);
  }
};
