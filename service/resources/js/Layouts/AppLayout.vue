<template>
    <div class="container-flued">

        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

                <button
                    class="navbar-toggler collapsed"
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
                    class="navbar-brand"
                    :href="route('dashboard')"
                    style="margin-right: auto;"
                    >
                    WEBAPP</a>

                <!-- Settings Dropdown -->
                <nav-profile />

                <div
                    id="navbarCollapse"
                    class="collapse navbar-collapse"
                    >
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
                        </li>
                    </ul>

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
    import Dropdown from '@/Component/Dropdown'
    import DropdownLink from '@/Component/DropdownLink'
    import NavLink from '@/Component/NavLink'
    import NavProfile from '@/Component/NavProfile'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            Dropdown,
            DropdownLink,
            NavLink,
            NavProfile
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                axios.post(route('logout').url()).then(response => {
                    window.location = '/';
                })
            },
        }
    }
</script>
