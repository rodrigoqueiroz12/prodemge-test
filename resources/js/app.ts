import 'vuetify/styles';

import './bootstrap';
import '@mdi/font/css/materialdesignicons.css'
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const vuetify = createVuetify({
    ssr: true,
    components,
    directives,

    icons: {
        defaultSet: 'mdi',
    }
})

createInertiaApp({
    title: (title) => title ? `${title} - ${appName}` : appName,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(vuetify)
            .use(plugin)
            .use(ZiggyVue)
            .use((app) => app.config.globalProperties.$route = route)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
