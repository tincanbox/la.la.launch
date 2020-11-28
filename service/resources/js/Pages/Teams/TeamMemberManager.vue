<template>
    <div>
        <div v-if="userPermissions.canAddTeamMembers">
            <gui-section-border />

            <!-- Add Team Member -->
            <gui-form-section @submitted="addTeamMember">
                <template #title>
                    Add Team Member
                </template>

                <template #description>
                    Add a new team member to your team, allowing them to collaborate with you.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            Please provide the email address of the person you would like to add to this team. The email address must be associated with an existing account.
                        </div>
                    </div>

                    <!-- Member Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <gui-label for="email" value="Email" />
                        <gui-input id="email" type="text" class="mt-1 block w-full" v-model="addTeamMemberForm.email" />
                        <gui-input-error :message="addTeamMemberForm.error('email')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="col-span-6 lg:col-span-4" v-if="availableRoles.length > 0">
                        <gui-label for="roles" value="Role" />
                        <gui-input-error :message="addTeamMemberForm.error('role')" class="mt-2" />

                        <div class="mt-1 border border-gray-200 rounded-lg cursor-pointer">
                            <div class="px-4 py-3"
                                            :class="{'border-t border-gray-200': i > 0}"
                                            @click="addTeamMemberForm.role = role.key"
                                            v-for="(role, i) in availableRoles"
                                            :key="role.key"
                                            >
                                <div :class="{'opacity-50': addTeamMemberForm.role && addTeamMemberForm.role != role.key}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-600" :class="{'font-semibold': addTeamMemberForm.role == role.key}">
                                            {{ role.name }}
                                        </div>

                                        <svg v-if="addTeamMemberForm.role == role.key" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600">
                                        {{ role.description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <gui-action-message :on="addTeamMemberForm.recentlySuccessful" class="mr-3">
                        Added.
                    </gui-action-message>

                    <gui-button :class="{ 'opacity-25': addTeamMemberForm.processing }" :disabled="addTeamMemberForm.processing">
                        Add
                    </gui-button>
                </template>
            </gui-form-section>
        </div>

        <div v-if="team.users.length > 0">
            <gui-section-border />

            <!-- Manage Team Members -->
            <gui-action-section class="mt-10 sm:mt-0">
                <template #title>
                    Team Members
                </template>

                <template #description>
                    All of the people that are part of this team.
                </template>

                <!-- Team Member List -->
                <template #content>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between" v-for="user in team.users" :key="user.id">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full" :src="user.profile_photo_url" :alt="user.name">
                                <div class="ml-4">{{ user.name }}</div>
                            </div>

                            <div class="flex items-center">
                                <!-- Manage Team Member Role -->
                                <button class="ml-2 text-sm text-gray-400 underline"
                                        v-if="userPermissions.canAddTeamMembers && availableRoles.length"
                                        @click="manageRole(user)">
                                    {{ displayableRole(user.membership.role) }}
                                </button>

                                <div class="ml-2 text-sm text-gray-400" v-else-if="availableRoles.length">
                                    {{ displayableRole(user.membership.role) }}
                                </div>

                                <!-- Leave Team -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                    @click="confirmLeavingTeam"
                                                    v-if="$page.user.id === user.id">
                                    Leave
                                </button>

                                <!-- Remove Team Member -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                    @click="confirmTeamMemberRemoval(user)"
                                                    v-if="userPermissions.canRemoveTeamMembers">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </gui-action-section>
        </div>

        <!-- Role Management Modal -->
        <gui-dialog-modal :show="currentlyManagingRole" @close="currentlyManagingRole = false">
            <template #title>
                Manage Role
            </template>

            <template #content>
                <div v-if="managingRoleFor">
                    <div class="mt-1 border border-gray-200 rounded-lg cursor-pointer">
                        <div class="px-4 py-3"
                                        :class="{'border-t border-gray-200': i > 0}"
                                        @click="updateRoleForm.role = role.key"
                                        v-for="(role, i) in availableRoles"
                                        :key="role.key"
                                        >
                            <div :class="{'opacity-50': updateRoleForm.role && updateRoleForm.role != role.key}">
                                <!-- Role Name -->
                                <div class="flex items-center">
                                    <div class="text-sm text-gray-600" :class="{'font-semibold': updateRoleForm.role == role.key}">
                                        {{ role.name }}
                                    </div>

                                    <svg v-if="updateRoleForm.role == role.key" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>

                                <!-- Role Description -->
                                <div class="mt-2 text-xs text-gray-600">
                                    {{ role.description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template #footer>
                <gui-secondary-button @click.native="currentlyManagingRole = false">
                    Nevermind
                </gui-secondary-button>

                <gui-button class="ml-2" @click.native="updateRole" :class="{ 'opacity-25': updateRoleForm.processing }" :disabled="updateRoleForm.processing">
                    Save
                </gui-button>
            </template>
        </gui-dialog-modal>

        <!-- Leave Team Confirmation Modal -->
        <gui-confirmation-modal :show="confirmingLeavingTeam" @close="confirmingLeavingTeam = false">
            <template #title>
                Leave Team
            </template>

            <template #content>
                Are you sure you would like to leave this team?
            </template>

            <template #footer>
                <gui-secondary-button @click.native="confirmingLeavingTeam = false">
                    {{ __('$.nevermind') }}
                </gui-secondary-button>

                <gui-danger-button class="ml-2" @click.native="leaveTeam" :class="{ 'opacity-25': leaveTeamForm.processing }" :disabled="leaveTeamForm.processing">
                    {{ __('$.leave') }}
                </gui-danger-button>
            </template>
        </gui-confirmation-modal>

        <!-- Remove Team Member Confirmation Modal -->
        <gui-confirmation-modal :show="teamMemberBeingRemoved" @close="teamMemberBeingRemoved = null">
            <template #title>
                Remove Team Member
            </template>

            <template #content>
                Are you sure you would like to remove this person from the team?
            </template>

            <template #footer>
                <gui-secondary-button @click.native="teamMemberBeingRemoved = null">
                    Nevermind
                </gui-secondary-button>

                <gui-danger-button class="ml-2" @click.native="removeTeamMember" :class="{ 'opacity-25': removeTeamMemberForm.processing }" :disabled="removeTeamMemberForm.processing">
                    Remove
                </gui-danger-button>
            </template>
        </gui-confirmation-modal>
    </div>
</template>

<script>
    import GuiActionMessage from '@/Component/ActionMessage'
    import GuiActionSection from '@/Component/ActionSection'
    import GuiButton from '@/Component/Button'
    import GuiConfirmationModal from '@/Component/ConfirmationModal'
    import GuiDangerButton from '@/Component/DangerButton'
    import GuiDialogModal from '@/Component/DialogModal'
    import GuiFormSection from '@/Component/FormSection'
    import GuiInput from '@/Component/Input'
    import GuiInputError from '@/Component/InputError'
    import GuiLabel from '@/Component/Label'
    import GuiSecondaryButton from '@/Component/SecondaryButton'
    import GuiSectionBorder from '@/Component/SectionBorder'

    export default {
        components: {
            GuiActionMessage,
            GuiActionSection,
            GuiButton,
            GuiConfirmationModal,
            GuiDangerButton,
            GuiDialogModal,
            GuiFormSection,
            GuiInput,
            GuiInputError,
            GuiLabel,
            GuiSecondaryButton,
            GuiSectionBorder,
        },

        props: [
            'team',
            'availableRoles',
            'userPermissions'
        ],

        data() {
            return {
                addTeamMemberForm: this.$inertia.form({
                    email: '',
                    role: null,
                }, {
                    bag: 'addTeamMember',
                    resetOnSuccess: true,
                }),

                updateRoleForm: this.$inertia.form({
                    role: null,
                }, {
                    bag: 'updateRole',
                    resetOnSuccess: false,
                }),

                leaveTeamForm: this.$inertia.form({
                    //
                }, {
                    bag: 'leaveTeam',
                }),

                removeTeamMemberForm: this.$inertia.form({
                    //
                }, {
                    bag: 'removeTeamMember',
                }),

                currentlyManagingRole: false,
                managingRoleFor: null,
                confirmingLeavingTeam: false,
                teamMemberBeingRemoved: null,
            }
        },

        methods: {
            addTeamMember() {
                this.addTeamMemberForm.post(route('team-members.store', this.team), {
                    preserveScroll: true
                });
            },

            manageRole(teamMember) {
                this.managingRoleFor = teamMember
                this.updateRoleForm.role = teamMember.membership.role
                this.currentlyManagingRole = true
            },

            updateRole() {
                this.updateRoleForm.put(route('team-members.update', [this.team, this.managingRoleFor]), {
                    preserveScroll: true,
                }).then(() => {
                    this.currentlyManagingRole = false
                })
            },

            confirmLeavingTeam() {
                this.confirmingLeavingTeam = true
            },

            leaveTeam() {
                this.leaveTeamForm.delete(route('team-members.destroy', [this.team, this.$page.user]))
            },

            confirmTeamMemberRemoval(teamMember) {
                this.teamMemberBeingRemoved = teamMember
            },

            removeTeamMember() {
                this.removeTeamMemberForm.delete(route('team-members.destroy', [this.team, this.teamMemberBeingRemoved]), {
                    preserveScroll: true,
                    preserveState: true,
                }).then(() => {
                    this.teamMemberBeingRemoved = null
                })
            },

            displayableRole(role) {
                return this.availableRoles.find(r => r.key == role).name
            },
        },
    }
</script>
