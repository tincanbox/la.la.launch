<template>
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

            <button
                class="navbar-nav navbar-toggler collapsed"
                type="button"
                data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"
                style="padding-left:0;border:0;"
                >
                <span class="icon-bar top-bar"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>	
            </button>

            <inertia-link
                class="navbar-brand navbar-nav"
                :href="route('dashboard')"
                style="margin-right: auto;"
                >
                <logo style="height:30px;fill:#fe6754;"></logo>
            </inertia-link>

            <div
                id="navbarCollapse"
                class="navbar-nav collapse navbar-collapse"
                >
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" :href="route('dashboard')">{{ __('page.dashboard:title') }}</a>
                    </li>
                </ul>

            </div>

            <div
                class=""
                style="position: fixed; right: 1em; top: 10px;"
                >
                <!-- Settings Dropdown -->
                <navigation-user-menu />
            </div>

        </nav>
    </header>
</template>

<script>
import Logo from '@/SVG/Logo'
import NavigationUserMenu from './NavigationUserMenu'

export default {
    components: {
        Logo,
        NavigationUserMenu,
    },

    data() {
    },

    methods: {
    }
}
</script>
