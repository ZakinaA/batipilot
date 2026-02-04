import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';


document.addEventListener('DOMContentLoaded', () => {
    const colors = [
        '#2563eb',
        '#10b981',
        '#f59e0b',
        '#8b5cf6',
        '#ec4899',
        '#14b8a6',
        '#f97316'
    ];

    document.querySelectorAll('[data-random-border]').forEach(el => {
        const color = colors[Math.floor(Math.random() * colors.length)];

        // Cas DETAILS → on cible le summary
        if (el.tagName === 'DETAILS') {
            const summary = el.querySelector('summary');
            if (summary) {
                summary.style.borderLeft = `6px solid ${color}`;
            }
        }

        // Cas CARD
        if (el.classList.contains('card')) {
            el.style.borderTop = `4px solid ${color}`;
        }
    });

    console.log('Random borders applied');
});





console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
