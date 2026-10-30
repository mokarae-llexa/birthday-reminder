
import './bootstrap';
import 'bootstrap';
import '../css/app.css';
import '../css/landing.css';

import { gsap } from 'gsap';

function initLandingAnimations() {
    // Jangan jalankan animasi di halaman selain landing page
    const landingPage = document.querySelector('.landing-page');

    if (!landingPage) return;

    // 1. Animasi teks muncul perlahan
    gsap.from('.landing-page .hero-copy > *', {
        opacity: 0,
        y: 24,
        duration: 0.8,
        stagger: 0.13,
        ease: 'power3.out'
    });

    // 2. Animasi stiker muncul
    gsap.from('.landing-page .sticker', {
        opacity: 0,
        scale: 0.75,
        duration: 0.7,
        stagger: 0.09,
        delay: 0.25,
        ease: 'back.out(1.7)'
    });

    // 3. Kue bergerak naik turun
    gsap.to('.landing-page .sticker-cake', {
        y: -10,
        rotation: -3,
        duration: 2.4,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    });

    // 4. Hadiah bergerak
    gsap.to('.landing-page .sticker-gift', {
        y: -8,
        rotation: 8,
        duration: 2.8,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    });

    // 5. Balon melayang
    gsap.to('.landing-page .sticker-balloon', {
        y: -13,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    });

    // 6. Bintang berdenyut
    gsap.to('.landing-page .star', {
        scale: 1.2,
        rotation: 12,
        duration: 1.2,
        repeat: -1,
        yoyo: true,
        stagger: 0.3,
        transformOrigin: 'center center',
        ease: 'sine.inOut'
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLandingAnimations);
} else {
    initLandingAnimations();
}
