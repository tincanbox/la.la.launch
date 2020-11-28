<template>
    <gui-action-section>
        <template #title>
            {{ __('page.profile:2fa:title') }}
        </template>

        <template #description>
            {{ __('page.profile:2fa:desc') }}
        </template>

        <template #content>
            <h3 class="text-lg font-medium text-gray-900" v-if="twoFactorEnabled">
                {{ __('page.profile:2fa:enabled') }}
            </h3>

            <h3 class="text-lg font-medium text-gray-900" v-else>
                {{ __('page.profile:2fa:disabled') }}
            </h3>

            <div class="mt-3 max-w-xl text-sm text-gray-600">
                <p>
                    {{ __('page.profile:2fa:explain') }}
                </p>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode">
                    <div class="mt-4 max-w-xl text-sm text-gray-600">
                        <p class="font-semibold">
                            {{ __('page.profile:2fa:explain:qr') }}
                        </p>
                    </div>

                    <div class="mt-4 dark:p-4 dark:w-56 dark:bg-white" v-html="qrCode">
                    </div>
                </div>

                <div v-if="recoveryCodes.length > 0">
                    <div class="mt-4 max-w-xl text-sm text-gray-600">
                        <p class="font-semibold">
                            {{ __('page.profile:2fa:explain:recoverycode') }}
                        </p>
                    </div>

                    <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                        <div v-for="code in recoveryCodes" :key="code">
                            {{ code }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div v-if="! twoFactorEnabled">
                    <gui-confirms-password
                        @confirmed="enableTwoFactorAuthentication"
                        >
                        <gui-button type="button" :class="{ 'opacity-25': enabling }" :disabled="enabling">
                            {{ __('$.enable') }}
                        </gui-button>
                    </gui-confirms-password>
                </div>

                <div v-else>
                    <gui-confirms-password @confirmed="regenerateRecoveryCodes">
                        <gui-secondary-button class="mr-3"
                                        v-if="recoveryCodes.length > 0">
                            {{ __('page.profile:2fa:regenerate_recovery_code') }}
                        </gui-secondary-button>
                    </gui-confirms-password>

                    <gui-confirms-password @confirmed="showRecoveryCodes">
                        <gui-secondary-button class="mr-3" v-if="recoveryCodes.length == 0">
                            {{ __('page.profile:2fa:show_recovery_code') }}
                        </gui-secondary-button>
                    </gui-confirms-password>

                    <gui-confirms-password @confirmed="disableTwoFactorAuthentication">
                        <gui-danger-button
                                        :class="{ 'opacity-25': disabling }"
                                        :disabled="disabling">
                            {{ __('$.disable') }}
                        </gui-danger-button>
                    </gui-confirms-password>
                </div>
            </div>
        </template>
    </gui-action-section>
</template>

<script>
    import GuiActionSection from '@/Component/ActionSection'
    import GuiButton from '@/Component/Button'
    import GuiConfirmsPassword from '@/Component/ConfirmsPassword'
    import GuiDangerButton from '@/Component/DangerButton'
    import GuiSecondaryButton from '@/Component/SecondaryButton'

    export default {
        components: {
            GuiActionSection,
            GuiButton,
            GuiConfirmsPassword,
            GuiDangerButton,
            GuiSecondaryButton,
        },

        data() {
            return {
                enabling: false,
                disabling: false,

                qrCode: null,
                recoveryCodes: [],
            }
        },

        methods: {
            enableTwoFactorAuthentication() {
                this.enabling = true

                this.$inertia.post('/user/two-factor-authentication', {}, {
                    preserveScroll: true,
                }).then(() => {
                    return Promise.all([
                        this.showQrCode(),
                        this.showRecoveryCodes()
                    ])
                }).then(() => {
                    this.enabling = false
                })
            },

            showQrCode() {
                return axios.get('/user/two-factor-qr-code')
                        .then(response => {
                            this.qrCode = response.data.svg
                        })
            },

            showRecoveryCodes() {
                return axios.get('/user/two-factor-recovery-codes')
                        .then(response => {
                            this.recoveryCodes = response.data
                        })
            },

            regenerateRecoveryCodes() {
                axios.post('/user/two-factor-recovery-codes')
                        .then(response => {
                            this.showRecoveryCodes()
                        })
            },

            disableTwoFactorAuthentication() {
                this.disabling = true

                this.$inertia.delete('/user/two-factor-authentication', {
                    preserveScroll: true,
                }).then(() => {
                    this.disabling = false
                })
            },
        },

        computed: {
            twoFactorEnabled() {
                return ! this.enabling && this.$page.user.two_factor_enabled
            }
        }
    }
</script>
