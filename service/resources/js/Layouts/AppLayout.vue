<template>
    <div class="container-flued">

        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

                <button
                    class="navbar-nav navbar-toggler collapsed"
                    type="button"
                    data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"
                    style="padding-left:0;"
                    >
                    <span class="icon-bar top-bar"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>	
                </button>

                <a
                    class="navbar-brand navbar-nav"
                    :href="route('dashboard')"
                    style="margin-right: auto;"
                    >
                    {{ $page.app.env.app_name }}</a>

                <div
                    id="navbarCollapse"
                    class="navbar-nav collapse navbar-collapse"
                    >
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" :href="route('dashboard')">Home</a>
                        </li>
                    </ul>

                </div>

                <div
                    class=""
                    style="position: fixed; right: 1em; top: 10px;"
                    >
                    <!-- Settings Dropdown -->
                    <nav-profile />
                </div>

           </nav>
        </header>

        <!-- Page Heading -->
        <div class="bg-white shadow" style="margin-top:56px;">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header"></slot>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple>
        </portal-target>
    </div>
</template>

<script>
import NavLink from '@/Component/NavLink'
import NavProfile from '@/Component/NavProfile'

export default {
    components: {
        NavLink,
        NavProfile
    },

    mounted: function () {
        console.log(this.$page);
    },

    methods: {
    }
}
</script>
