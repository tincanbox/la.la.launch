<template>

    <div id="navigation-profile">

        <dropdown align="right" width="48">

            <template #trigger>
            <div
                id="navigation-profile-trigger"
                class="-mr-2"
                style="position: fixed; right: 1em; top: 10px;"
                > 
                <button 
                    v-if="$page.jetstream.managesProfilePhotos"
                    @click="showingNavigationDropdown = ! showingNavigationDropdown"
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out"
                    >
                    <img class="h-8 w-8 rounded-full object-cover" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                </button>

                <button
                    v-else
                    @click="showingNavigationDropdown = ! showingNavigationDropdown"
                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                    >
                    <div>{{ $page.user.name }}</div>

                    <div class="ml-1">
                        <svg
                            class="fill-current h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>

            </div>
            </template><!-- trigger -->

            <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('gui.nav:manage_account') }}
                </div>

                <dropdown-link :href="route('profile.show')">
                    {{ __('page.profile:title') }}
                </dropdown-link>

                <!--
                <dropdown-link :href="route('api-tokens.index')" v-if="$page.jetstream.hasApiFeatures">
                    API Tokens
                </dropdown-link>

                <div class="border-t border-gray-100"></div>
                -->

                <!-- Team Management -->
                <template v-if="$page.jetstream.hasTeamFeatures">
                    <!--
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Manage Team
                    </div>
                    -->

                    <!-- Team Settings -->
                    <!--
                    <dropdown-link :href="route('teams.show', $page.user.current_team)">
                        Team Settings
                    </dropdown-link>

                    <dropdown-link :href="route('teams.create')" v-if="$page.jetstream.canCreateTeams">
                        Create New Team
                    </dropdown-link>

                    <div class="border-t border-gray-100"></div>
                    -->

                    <!-- Team Switcher -->
                    <!--
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Switch Teams
                    </div>

                    <template v-for="team in $page.user.all_teams">
                        <form @submit.prevent="switchToTeam(team)" :key="team.id">
                            <dropdown-link as="button">
                                <div class="flex items-center">
                                    <svg v-if="team.id == $page.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <div>{{ team.name }}</div>
                                </div>
                            </dropdown-link>
                        </form>
                    </template>

                    <div class="border-t border-gray-100"></div>
                    -->
                </template>

                <!-- Authentication -->
                <form @submit.prevent="logout">
                    <dropdown-link as="button">
                        {{ __('$.logout') }}
                    </dropdown-link>
                </form>
            </template>
        </dropdown>

    </div>
 
</template>

<script>
import Dropdown from './Dropdown'
import DropdownLink from './DropdownLink'

export default {
    components: {
        Dropdown,
        DropdownLink,
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
