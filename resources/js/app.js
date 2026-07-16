import './bootstrap';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// ============================================================
// GSAP Animation System for Ehl-i Keyf
// ============================================================

function initGsapAnimations() {
    ScrollTrigger.refresh();

    // 1. Fade-in-up with stagger (generic .gsap-fade-in)
    gsap.utils.toArray('.gsap-fade-in').forEach((el) => {
        if (el._gsapInited) return;
        el._gsapInited = true;
        gsap.fromTo(el,
            { autoAlpha: 0, y: 40 },
            {
                autoAlpha: 1, y: 0, duration: 0.9, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 85%', once: true }
            }
        );
    });

    // 2. Parallax elements (.gsap-parallax — moves at different speed)
    gsap.utils.toArray('.gsap-parallax').forEach((el) => {
        const speed = parseFloat(el.dataset.parallaxSpeed) || 0.3;
        gsap.to(el, {
            y: () => (1 - speed) * 100,
            ease: 'none',
            scrollTrigger: {
                trigger: el,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1,
            }
        });
    });

    // 3. Hero parallax — background image moves slower than foreground
    gsap.utils.toArray('.gsap-hero-parallax').forEach((hero) => {
        const bg = hero.querySelector('.gsap-hero-bg');
        if (!bg) return;
        gsap.to(bg, {
            yPercent: 15,
            ease: 'none',
            scrollTrigger: {
                trigger: hero,
                start: 'top top',
                end: 'bottom top',
                scrub: 1,
            }
        });
    });

    // 4. Blur-in: starts blurred and unblurs as it enters viewport
    gsap.utils.toArray('.gsap-blur-in').forEach((el) => {
        if (el._gsapInited) return;
        el._gsapInited = true;
        gsap.fromTo(el,
            { autoAlpha: 0, filter: 'blur(15px)', scale: 1.05 },
            {
                autoAlpha: 1, filter: 'blur(0px)', scale: 1,
                duration: 1.2, ease: 'power2.out',
                scrollTrigger: { trigger: el, start: 'top 80%', once: true }
            }
        );
    });

    // 5. Scale-in: element scales up from 0.8
    gsap.utils.toArray('.gsap-scale-in').forEach((el) => {
        if (el._gsapInited) return;
        el._gsapInited = true;
        gsap.fromTo(el,
            { autoAlpha: 0, scale: 0.85 },
            {
                autoAlpha: 1, scale: 1, duration: 0.8, ease: 'back.out(1.4)',
                scrollTrigger: { trigger: el, start: 'top 85%', once: true }
            }
        );
    });

    // 6. Slide-in from left/right
    gsap.utils.toArray('.gsap-slide-left').forEach((el) => {
        if (el._gsapInited) return;
        el._gsapInited = true;
        gsap.fromTo(el,
            { autoAlpha: 0, x: -60 },
            {
                autoAlpha: 1, x: 0, duration: 1, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 80%', once: true }
            }
        );
    });

    gsap.utils.toArray('.gsap-slide-right').forEach((el) => {
        if (el._gsapInited) return;
        el._gsapInited = true;
        gsap.fromTo(el,
            { autoAlpha: 0, x: 60 },
            {
                autoAlpha: 1, x: 0, duration: 1, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 80%', once: true }
            }
        );
    });

    // 7. Stagger groups: animates children in sequence
    gsap.utils.toArray('[data-gsap-stagger]').forEach((container) => {
        const children = container.querySelectorAll('[data-gsap-item]');
        if (!children.length || container._gsapInited) return;
        container._gsapInited = true;
        gsap.fromTo(children,
            { autoAlpha: 0, y: 50 },
            {
                autoAlpha: 1, y: 0, duration: 0.7, stagger: 0.12, ease: 'power3.out',
                scrollTrigger: { trigger: container, start: 'top 80%', once: true }
            }
        );
    });

    // 8. Pin sections for parallax storytelling (.gsap-pin)
    gsap.utils.toArray('.gsap-pin-section').forEach((section) => {
        const inner = section.querySelector('.gsap-pin-inner');
        if (!inner) return;
        gsap.fromTo(inner,
            { autoAlpha: 0, scale: 1.1 },
            {
                autoAlpha: 1, scale: 1, duration: 1, ease: 'power2.out',
                scrollTrigger: {
                    trigger: section,
                    start: 'top 80%',
                    end: 'center center',
                    scrub: 1,
                }
            }
        );
    });

    // 9. Animated counters (.gsap-counter with data-target)
    gsap.utils.toArray('.gsap-counter').forEach((el) => {
        if (el._gsapInited) return;
        el._gsapInited = true;
        const target = parseInt(el.dataset.target || '0');
        const obj = { val: 0 };
        gsap.to(obj, {
            val: target,
            duration: 2.5,
            ease: 'power2.out',
            snap: { val: 1 },
            scrollTrigger: { trigger: el, start: 'top 80%', once: true },
            onUpdate: () => {
                el.textContent = Math.floor(obj.val).toLocaleString('tr-TR');
            }
        });
    });

    // 10. Text reveal: splits text into lines and reveals (CSS .gsap-text-reveal handles the mask)
    gsap.utils.toArray('.gsap-text-reveal').forEach((el) => {
        if (el._gsapInited) return;
        el._gsapInited = true;
        gsap.fromTo(el,
            { yPercent: 100, autoAlpha: 0 },
            {
                yPercent: 0, autoAlpha: 1, duration: 1, ease: 'power4.out',
                scrollTrigger: { trigger: el, start: 'top 85%', once: true }
            }
        );
    });

    // 11. Magnetic hover effect on buttons (.gsap-magnetic)
    gsap.utils.toArray('.gsap-magnetic').forEach((el) => {
        if (el._gsapMagnetic) return;
        el._gsapMagnetic = true;
        const strength = 0.3;
        el.addEventListener('mousemove', (e) => {
            const rect = el.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            gsap.to(el, { x: x * strength, y: y * strength, duration: 0.3, ease: 'power2.out' });
        });
        el.addEventListener('mouseleave', () => {
            gsap.to(el, { x: 0, y: 0, duration: 0.5, ease: 'elastic.out(1, 0.3)' });
        });
    });
}

// Run on initial load and Livewire navigation
document.addEventListener('DOMContentLoaded', initGsapAnimations);
document.addEventListener('livewire:navigated', initGsapAnimations);
