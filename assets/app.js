import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import './scripts/download.js';


const toggleBtn = document.querySelector('.toggle-menu');

toggleBtn.addEventListener('click', () => {
    if (window.matchMedia('(max-width: 1024px)').matches) {
        document.body.classList.toggle('sidebar-open');
    }
});
