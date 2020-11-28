<template>
    <gui-action-section>
        <template #title>
            {{ __('page.profile:delete:title') }}
        </template>

        <template #description>
            {{ __('page.profile:delete:desc') }}
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                {{ __('page.profile:delete:explain') }}
            </div>

            <div class="mt-5">
                <gui-danger-button @click.native="confirmUserDeletion">
                    {{ __('page.profile:delete:execute') }}
                </gui-danger-button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <gui-dialog-modal
                :show="confirmingUserDeletion"
                @close="confirmingUserDeletion = false"
                >
                <template #title>
                    {{ __('page.profile:delete:execute') }}
                </template>

                <template #content>
                    {{ __('page.profile:delete:confirmation') }}

                    <div class="mt-4">
                        <gui-input
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="Password"
                            ref="password"
                            v-model="form.password"
                            @keyup.enter.native="deleteUser" />

                        <gui-input-error :message="form.error('password')" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <gui-secondary-button @click.native="confirmingUserDeletion = false">
                        {{ __('$.nevermind') }}
                    </gui-secondary-button>

                    <gui-danger-button
                        class="ml-2"
                        @click.native="deleteUser"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        >
                        {{ __('page.profile:delete:execute') }}
                    </gui-danger-button>
                </template>
            </gui-dialog-modal>
        </template>
    </gui-action-section>
</template>

<script>
    import GuiActionSection from '@/Component/ActionSection'
    import GuiDialogModal from '@/Component/DialogModal'
    import GuiDangerButton from '@/Component/DangerButton'
    import GuiInput from '@/Component/Input'
    import GuiInputError from '@/Component/InputError'
    import GuiSecondaryButton from '@/Component/SecondaryButton'

    export default {
        components: {
            GuiActionSection,
            GuiDangerButton,
            GuiDialogModal,
            GuiInput,
            GuiInputError,
            GuiSecondaryButton,
        },

        data() {
            return {
                confirmingUserDeletion: false,

                form: this.$inertia.form({
                    '_method': 'DELETE',
                    password: '',
                }, {
                    bag: 'deleteUser'
                })
            }
        },

        methods: {
            confirmUserDeletion() {
                this.form.password = '';

                this.confirmingUserDeletion = true;

                setTimeout(() => {
                    this.$refs.password.focus()
                }, 250)
            },

            deleteUser() {
                this.form.post(route('current-user.destroy'), {
                    preserveScroll: true
                }).then(response => {
                    if (! this.form.hasErrors()) {
                        this.confirmingUserDeletion = false;
                    }
                })
            },
        },
    }
</script>
