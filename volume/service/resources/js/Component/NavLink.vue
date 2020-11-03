<template>
    <inertia-link :href="href" :class="classes" :active="active">
        <slot></slot>
    </inertia-link>
</template>

<script>
    export default {
        props: ['href', 'active'],

        computed: {
            classes() {
                let def = ['nav-link'];
                if (this.active) {
                    def.push('active');
                }
                return def.join(' ');
            }
        }
    }
</script>
