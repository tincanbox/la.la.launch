<template>
    <gui-form-section @submitted="createTeam">
        <template #title>
            Team Details
        </template>

        <template #description>
            Create a new team to collaborate with others on projects.
        </template>

        <template #form>
            <div class="col-span-6">
                <gui-label value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" :src="$page.user.profile_photo_url" :alt="$page.user.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ $page.user.name }}</div>
                        <div class="text-gray-700 text-sm">{{ $page.user.email }}</div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <gui-label for="name" value="Team Name" />
                <gui-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
                <gui-input-error :message="form.error('name')" class="mt-2" />
            </div>
        </template>

        <template #actions>
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
    import JetActionMessage from '@/Component/ActionMessage'
    import JetButton from '@/Component/Button'
    import JetFormSection from '@/Component/FormSection'
    import JetInput from '@/Component/Input'
    import JetInputError from '@/Component/InputError'
    import JetLabel from '@/Component/Label'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                }, {
                    bag: 'createTeam',
                    resetOnSuccess: false,
                })
            }
        },

        methods: {
            createTeam() {
                this.form.post(route('teams.store'), {
                    preserveScroll: true
                });
            },
        },
    }
</script>
