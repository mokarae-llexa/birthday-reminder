
import './bootstrap';
import 'bootstrap';
import '../css/app.css';
import '../css/landing.css';

import { gsap } from 'gsap';
import lottie from 'lottie-web';

function initLandingAnimations() {
    const landingPage = document.querySelector('.landing-page');

    if (!landingPage) return;

    gsap.from('.landing-page .hero-copy > *', {
        opacity: 0,
        y: 24,
        duration: 0.8,
        stagger: 0.13,
        ease: 'power3.out'
    });

    gsap.from('.landing-page .sticker', {
        opacity: 0,
        scale: 0.75,
        duration: 0.7,
        stagger: 0.09,
        delay: 0.25,
        ease: 'back.out(1.7)'
    });

    gsap.to('.landing-page .sticker-cake', {
        y: -10,
        rotation: -3,
        duration: 2.4,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    });

    gsap.to('.landing-page .sticker-gift', {
        y: -8,
        rotation: 8,
        duration: 2.8,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    });

    gsap.to('.landing-page .sticker-balloon', {
        y: -13,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    });

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
    
    gsap.utils.toArray('.birthday-stickers .sticker').forEach((sticker, index) => {
        gsap.to(sticker, {
            y: index % 2 === 0 ? -12 : 12,
            rotation: index % 2 === 0 ? 6 : -6,
            duration: 2 + (index * 0.2),
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });
    });
}

function initSidebarAnimation() {
    const sidebarAnimation = document.getElementById('sidebar-birthday-animation');

    console.log('1. Elemen sidebar:', sidebarAnimation);
    console.log('2. Lottie:', lottie);

    if (!sidebarAnimation) return;

    const animation = lottie.loadAnimation({
        container: sidebarAnimation,
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '/animations/birthday-cake.json'
    });

    animation.addEventListener('DOMLoaded', () => {
        console.log('3. ANIMASI BERHASIL DIMUAT');
    });

    animation.addEventListener('data_failed', () => {
        console.log('3. ANIMASI GAGAL DIMUAT');
    });
}

function initAnimations() {
    initLandingAnimations();
    initSidebarAnimation();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAnimations);
} else {
    initAnimations();
}
