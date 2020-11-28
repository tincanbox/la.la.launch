<template>
    <gui-form-section @submitted="updatePassword">
        <template #title>
            {{ __('page.profile:password:title') }}
        </template>

        <template #description>
            {{ __('page.profile:password:desc') }}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4 mb-3">
                <gui-label for="current_password" :value="__('page.profile:password:current')" />
                <gui-input id="current_password" type="password" class="mt-1 block w-full" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
                <gui-input-error :message="form.error('current_password')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mb-3">
                <gui-label for="password" :value="__('page.profile:password:new')" />
                <gui-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="new-password" />
                <gui-input-error :message="form.error('password')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mb-3">
                <gui-label for="password_confirmation" :value="__('page.profile:password:new_confirm')" />
                <gui-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                <gui-input-error :message="form.error('password_confirmation')" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <gui-action-message :on="form.recentlySuccessful" class="mr-3">
                {{ __('$.saved') }}
            </gui-action-message>

            <gui-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ __('$.save') }}
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

        data() {
            return {
                form: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }, {
                    bag: 'updatePassword',
                }),
            }
        },

        methods: {
            updatePassword() {
                this.form.put(route('user-password.update'), {
                    preserveScroll: true
                }).then(() => {
                    this.$refs.current_password.focus()
                })
            },
        },
    }
</script>
