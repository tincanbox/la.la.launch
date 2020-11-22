<template>
    <div class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

        <button class="navbar-toggler collapsed pl-1" type="button"
        data-toggle="collapse" data-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" >
            <span class="icon-bar top-bar"></span>
            <span class="icon-bar middle-bar"></span>
            <span class="icon-bar bottom-bar"></span>	
        </button>

        <a class="navbar-brand mr-auto pr-3" v-bind:href="route('dashboard')">
            {{ $page.app.env.app_name }}
        </a>

        <ul class="navbar-nav ml-auto" style="position: fixed; right: 1rem; top: .65rem;">
            <navigation-user />
        </ul>

        <div class="collapse navbar-collapse" id="navbarCollapse">

            <ul class="navbar-nav mr-auto">
                <!--
                <li class="nav-item">
                    <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                        {{ $__("page.dashboard:title") }}
                    </nav-link>
                </li>
                -->
            </ul>
        </div>



    </div>
</template>

<script>
    import ApplicationMark from '@/SVG/ApplicationMark'
    import NavigationUser from '@/Component/NavigationUser'
    import NavLink from '@/Component/NavLink'

    export default {
        components: {
            ApplicationMark,
            NavigationUser,
            NavLink,
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
