<template>
    <gui-action-section>
        <template #title>
            {{ __('page.profile:loginsession:title') }}
        </template>

        <template #description>
            {{ __('page.profile:loginsession:desc') }}
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                {{ __('page.profile:loginsession:explain') }}
            </div>

            <!-- Other Browser Sessions -->
            <div class="mt-5 space-y-6" v-if="sessions.length > 0">
                <div class="flex items-center" v-for="(session, i) in sessions" :key="i">
                    <div>
                        <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-gray-500" v-if="session.agent.is_desktop">
                            <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-gray-500" v-else>
                            <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                        </svg>
                    </div>

                    <div class="ml-3">
                        <div class="text-sm text-gray-600">
                            {{ session.agent.platform }} - {{ session.agent.browser }}
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">
                                {{ session.ip_address }},

                                <span
                                    v-if="session.is_current_device"
                                    class="text-green-500 font-semibold"
                                    >{{ __('page.profile:loginsession:currentdevice') }}</span>
                                <span
                                    v-else
                                    >
                                    {{ __('page.profile:loginsession:lastactive(:date)', { date: session.last_active }) }}
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center mt-5">
                <gui-button @click.native="confirmLogout">
                    {{ __('page.profile:loginsession:execute') }}
                </gui-button>

                <gui-action-message :on="form.recentlySuccessful" class="ml-3">
                    {{ __('$.done') }}
                </gui-action-message>
            </div>

            <!-- Logout Other Devices Confirmation Modal -->
            <gui-dialog-modal :show="confirmingLogout" @close="confirmingLogout = false">
                <template #title>
                    {{ __('page.profile:loginsession:execute') }}
                </template>

                <template #content>
                    {{ __('page.profile:loginsession:execute_password') }}

                    <div class="mt-4">
                        <gui-input type="password" class="mt-1 block w-3/4" placeholder="Password"
                                    ref="password"
                                    v-model="form.password"
                                    @keyup.enter.native="logoutOtherBrowserSessions" />

                        <gui-input-error :message="form.error('password')" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <gui-secondary-button @click.native="confirmingLogout = false">
                        {{ __('$.nevermind') }}
                    </gui-secondary-button>

                    <gui-button
                        class="ml-2"
                        @click.native="logoutOtherBrowserSessions"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        >
                        {{ __('page.profile:loginsession:execute') }}
                    </gui-button>

                </template>
            </gui-dialog-modal>
        </template>
    </gui-action-section>
</template>

<script>
    import GuiActionMessage from '@/Component/ActionMessage'
    import GuiActionSection from '@/Component/ActionSection'
    import GuiButton from '@/Component/Button'
    import GuiDialogModal from '@/Component/DialogModal'
    import GuiInput from '@/Component/Input'
    import GuiInputError from '@/Component/InputError'
    import GuiSecondaryButton from '@/Component/SecondaryButton'

    export default {
        props: ['sessions'],

        components: {
            GuiActionMessage,
            GuiActionSection,
            GuiButton,
            GuiDialogModal,
            GuiInput,
            GuiInputError,
            GuiSecondaryButton,
        },

        data() {
            return {
                confirmingLogout: false,

                form: this.$inertia.form({
                    '_method': 'DELETE',
                    password: '',
                }, {
                    bag: 'logoutOtherBrowserSessions'
                })
            }
        },

        methods: {
            confirmLogout() {
                this.form.password = ''

                this.confirmingLogout = true

                setTimeout(() => {
                    this.$refs.password.focus()
                }, 250)
            },

            logoutOtherBrowserSessions() {
                this.form.post(route('other-browser-sessions.destroy'), {
                    preserveScroll: true
                }).then(response => {
                    if (! this.form.hasErrors()) {
                        this.confirmingLogout = false
                    }
                })
            },
        },
    }
</script>
