import 'keen-slider/keen-slider.css';

import SideMenu from './modules/side-menu.js';
import CatalogFilters from './modules/catalog-filters.js';
import { initSliders } from './modules/sliders.js';
import { initReadmore } from './modules/product-readmore.js';
import { initQty } from './modules/product-qty.js';
import { initLightbox } from './modules/lightbox.js';
import './cart/index.js';

const init = () => {
    new SideMenu('#main_side_menue');
    new CatalogFilters();
    initSliders();
    initReadmore();
    initQty();
    initLightbox();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
} else {
    init();
}
