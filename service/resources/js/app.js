require('./bootstrap');
require('moment');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import {__, trans, setLocale, getLocale, transChoice, MaticeLocalizationConfig, locales} from "matice";

import Element from 'element-ui'
Vue.use(Element);

Vue.mixin({
    methods: {
        route
    }
});

// matice
Vue.mixin({
    methods: {
        __: (msg, args, pru = false) => {
            try {
                return trans(msg, {args: args, pluralize: pru});
            } catch(e) {
                return msg
            }
        },
        $transChoice: transChoice,
        $setLocale: (locale) => {
          setLocale(locale);
          this.$forceUpdate() // Refresh the vue instance after locale change.
        },
        // The current locale
        $locale() {
            return getLocale()
        },
        // A listing of the available locales
        $locales() {
            return locales()
        }
    }
});
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
