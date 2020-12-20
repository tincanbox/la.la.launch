require('./bootstrap');
require('moment');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import {__, trans, setLocale, getLocale, transChoice, MaticeLocalizationConfig, locales} from "matice";

Vue.mixin({
    methods: {
        route
    }
});

// moment
import moment from 'moment';
Vue.prototype.$moment = moment;

// Swal
import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss';
Vue.prototype.$swal = Swal;

// FontAwesome
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// Vue.component('fa-icon', FontAwesomeIcon);

// Bootstrap-Vue
// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'
// Vue.use(BootstrapVue);
// Vue.use(IconsPlugin);

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

// helper
Vue.mixin({
    methods: {
        notify(message){
            let swal = this.$swal;
            let toast = swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', swal.stopTimer)
                    toast.addEventListener('mouseleave', swal.resumeTimer)
                }
            });
            toast.fire({
                icon: '',
                title: message
            });
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
