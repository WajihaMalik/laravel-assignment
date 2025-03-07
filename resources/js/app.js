import './bootstrap';
import Alpine from 'alpinejs';

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'admin-lte/dist/css/adminlte.min.css';

window.Alpine = Alpine;
Alpine.start();
