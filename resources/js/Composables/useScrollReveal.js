import { onMounted, onUnmounted } from 'vue';

export function usePageAnimations() {
    let sectionObserver = null;
    let parallaxCleanup = null;

    onMounted(() => {
        const sections = document.querySelectorAll('.scroll-section');
        if (sections.length) {
            sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        sectionObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.05 });

            sections.forEach((el) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(40px)';
                el.style.transition = 'opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1)';
                sectionObserver.observe(el);
            });
        }

        const dividers = document.querySelectorAll('.parallax-divider');
        if (dividers.length) {
            function onScroll() {
                dividers.forEach((div) => {
                    const img = div.querySelector('img');
                    if (!img) return;
                    const rect = div.getBoundingClientRect();
                    const offset = (rect.top + rect.height / 2 - window.innerHeight / 2) * -0.2;
                    img.style.transform = `translateY(${offset}px) scale(1.15)`;
                });
            }
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
            parallaxCleanup = () => window.removeEventListener('scroll', onScroll);
        }
    });

    onUnmounted(() => {
        if (sectionObserver) sectionObserver.disconnect();
        if (parallaxCleanup) parallaxCleanup();
    });
}
