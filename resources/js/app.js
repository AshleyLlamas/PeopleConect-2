import './bootstrap';
import '../css/app.css';
import 'sweetalert2/dist/sweetalert2.min.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

import { faSearch, faUser, faEnvelope, faLock, faBars, faUsers, faHome, faAddressCard, faArrowRightFromBracket, faChevronDown, faArrowRotateLeft, faTimes, faXmark, faImage, faFileImage, faPeopleGroup, faEye } from '@fortawesome/free-solid-svg-icons';
library.add(faSearch, faUser, faEnvelope, faLock, faBars, faUsers, faHome, faAddressCard, faArrowRightFromBracket, faChevronDown, faArrowRotateLeft, faTimes, faXmark, faImage, faFileImage, faPeopleGroup, faEye);

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('font-awesome-icon', FontAwesomeIcon)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
