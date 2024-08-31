import Alpine from 'alpinejs';
import { setupEventListeners } from './modules/loan.js';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM fully loaded and parsed');

    setupEventListeners();
});
