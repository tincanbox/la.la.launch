<template>
    <gui-form-section @submitted="updateTeamName">
        <template #title>
            Team Name
        </template>

        <template #description>
            The team's name and owner information.
        </template>

        <template #form>
            <!-- Team Owner Information -->
            <div class="col-span-6">
                <gui-label value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" :src="team.owner.profile_photo_url" :alt="team.owner.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ team.owner.name }}</div>
                        <div class="text-gray-700 text-sm">{{ team.owner.email }}</div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <gui-label for="name" value="Team Name" />

                <gui-input id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            :disabled="! permissions.canUpdateTeam" />

                <gui-input-error :message="form.error('name')" class="mt-2" />
            </div>
        </template>

        <template #actions v-if="permissions.canUpdateTeam">
            <gui-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </gui-action-message>

            <gui-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </gui-button>
        </template>
    </gui-form-section>
</template>

<script>
    import GuiActionMessage from '@/Component/ActionMessage'
    import GuiButton from '@/Component/Button'
    import GuiFormSection from '@/Component/FormSection'
    import GuiInput from '@/Component/Input'
    import GuiInputError from '@/Component/InputError'
    import GuiLabel from '@/Component/Label'

    export default {
        components: {
            GuiActionMessage,
            GuiButton,
            GuiFormSection,
            GuiInput,
            GuiInputError,
            GuiLabel,
        },

        props: ['team', 'permissions'],

        data() {
            return {
                form: this.$inertia.form({
                    name: this.team.name,
                }, {
                    bag: 'updateTeamName',
                    resetOnSuccess: false,
                })
            }
        },

        methods: {
            updateTeamName() {
                this.form.put(route('teams.update', this.team), {
                    preserveScroll: true
                });
            },
        },
    }
</script>
