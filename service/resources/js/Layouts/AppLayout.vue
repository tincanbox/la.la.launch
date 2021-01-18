<template>
    <div class="layout-container theme-container container-flued">

        <navigation></navigation>

        <!-- Page Heading -->
        <div class="layout-page-header bg-white shadow">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                <div class="row">
                    <h2 class="layout-page-title col-6 py-3 font-semibold text-gray-800 leading-tight">
                        <slot name="header-title"></slot>
                    </h2>
                    <div class="col-6 text-right">
                        <slot name="header-action"></slot>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="layout-yield">
            <slot></slot>
        </main>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple>
        </portal-target>
    </div>
</template>

<script>
import Logo from '@/SVG/Logo'
import Navigation from '@/Layouts/Navigation'

export default {
    components: {
        Logo,
        Navigation,
    },

    mounted: function () {
        const self = this;
        setInterval(function(){
            if (self.$page.flash.notification) {
                let message = self.$page.flash.notification;
                self.notify(message);
                self.$page.flash.notification = null;
            }
        }, 800)
    },

    methods: {
    }
}
</script>
