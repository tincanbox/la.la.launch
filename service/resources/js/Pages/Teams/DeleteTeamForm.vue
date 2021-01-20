<template>
    <gui-action-section>
        <template #title>
            Delete Team
        </template>

        <template #description>
            Permanently delete this team.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.
            </div>

            <div class="mt-5">
                <gui-danger-button @click.native="confirmTeamDeletion">
                    Delete Team
                </gui-danger-button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <gui-confirmation-modal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    Delete Team
                </template>

                <template #content>
                    Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
                </template>

                <template #footer>
                    <gui-secondary-button @click.native="confirmingTeamDeletion = false">
                        Nevermind
                    </gui-secondary-button>

                    <gui-danger-button class="ml-2" @click.native="deleteTeam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Team
                    </gui-danger-button>
                </template>
            </gui-confirmation-modal>
        </template>
    </gui-action-section>
</template>

<script>
    import GuiActionSection from '@/Component/ActionSection'
    import GuiButton from '@/Component/Button'
    import GuiConfirmationModal from '@/Component/ConfirmationModal'
    import GuiDangerButton from '@/Component/DangerButton'
    import GuiSecondaryButton from '@/Component/SecondaryButton'

    export default {
        props: ['team'],

        components: {
            GuiActionSection,
            GuiButton,
            GuiConfirmationModal,
            GuiDangerButton,
            GuiSecondaryButton,
        },

        data() {
            return {
                confirmingTeamDeletion: false,
                deleting: false,

                form: this.$inertia.form({
                    //
                }, {
                    bag: 'deleteTeam'
                })
            }
        },

        methods: {
            confirmTeamDeletion() {
                this.confirmingTeamDeletion = true
            },

            deleteTeam() {
                this.form.delete(route('teams.destroy', this.team), {
                    preserveScroll: true
                });
            },
        },
    }
</script>
