<template>
    <div>
        <!-- Generate API Token -->
        <gui-form-section @submitted="createApiToken">
            <template #title>
                Create API Token
            </template>

            <template #description>
                API tokens allow third-party services to authenticate with our application on your behalf.
            </template>

            <template #form>
                <!-- Token Name -->
                <div class="col-span-6 sm:col-span-4">
                    <gui-label for="name" value="Name" />
                    <gui-input id="name" type="text" class="mt-1 block w-full" v-model="createApiTokenForm.name" autofocus />
                    <gui-input-error :message="createApiTokenForm.error('name')" class="mt-2" />
                </div>

                <!-- Token Permissions -->
                <div class="col-span-6" v-if="availablePermissions.length > 0">
                    <gui-label for="permissions" value="Permissions" />

                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox" :value="permission" v-model="createApiTokenForm.permissions">
                                <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <gui-action-message :on="createApiTokenForm.recentlySuccessful" class="mr-3">
                    Created.
                </gui-action-message>

                <gui-button :class="{ 'opacity-25': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing">
                    Create
                </gui-button>
            </template>
        </gui-form-section>

        <div v-if="tokens.length > 0">
            <gui-section-border />

            <!-- Manage API Tokens -->
            <div class="mt-10 sm:mt-0">
                <gui-action-section>
                    <template #title>
                        Manage API Tokens
                    </template>

                    <template #description>
                        You may delete any of your existing tokens if they are no longer needed.
                    </template>

                    <!-- API Token List -->
                    <template #content>
                        <div class="space-y-6">
                            <div class="flex items-center justify-between" v-for="token in tokens" :key="token.id">
                                <div>
                                    {{ token.name }}
                                </div>

                                <div class="flex items-center">
                                    <div class="text-sm text-gray-400" v-if="token.last_used_at">
                                        Last used {{ fromNow(token.last_used_at) }}
                                    </div>

                                    <button class="cursor-pointer ml-6 text-sm text-gray-400 underline focus:outline-none"
                                                @click="manageApiTokenPermissions(token)"
                                                v-if="availablePermissions.length > 0">
                                        Permissions
                                    </button>

                                    <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" @click="confirmApiTokenDeletion(token)">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </gui-action-section>
            </div>
        </div>

        <!-- Token Value Modal -->
        <gui-dialog-modal :show="displayingToken" @close="displayingToken = false">
            <template #title>
                API Token
            </template>

            <template #content>
                <div>
                    Please copy your new API token. For your security, it won't be shown again.
                </div>

                <div class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500" v-if="$page.jetstream.flash.token">
                    {{ $page.jetstream.flash.token }}
                </div>
            </template>

            <template #footer>
                <gui-secondary-button @click.native="displayingToken = false">
                    Close
                </gui-secondary-button>
            </template>
        </gui-dialog-modal>

        <!-- API Token Permissions Modal -->
        <gui-dialog-modal :show="managingPermissionsFor" @close="managingPermissionsFor = null">
            <template #title>
                API Token Permissions
            </template>

            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="permission in availablePermissions" :key="permission">
                        <label class="flex items-center">
                            <input type="checkbox" class="form-checkbox" :value="permission" v-model="updateApiTokenForm.permissions">
                            <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #footer>
                <gui-secondary-button @click.native="managingPermissionsFor = null">
                    Nevermind
                </gui-secondary-button>

                <gui-button class="ml-2" @click.native="updateApiToken" :class="{ 'opacity-25': updateApiTokenForm.processing }" :disabled="updateApiTokenForm.processing">
                    Save
                </gui-button>
            </template>
        </gui-dialog-modal>

        <!-- Delete Token Confirmation Modal -->
        <gui-confirmation-modal :show="apiTokenBeingDeleted" @close="apiTokenBeingDeleted = null">
            <template #title>
                Delete API Token
            </template>

            <template #content>
                Are you sure you would like to delete this API token?
            </template>

            <template #footer>
                <gui-secondary-button @click.native="apiTokenBeingDeleted = null">
                    Nevermind
                </gui-secondary-button>

                <gui-danger-button class="ml-2" @click.native="deleteApiToken" :class="{ 'opacity-25': deleteApiTokenForm.processing }" :disabled="deleteApiTokenForm.processing">
                    Delete
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
            'tokens',
            'availablePermissions',
            'defaultPermissions',
        ],

        data() {
            return {
                createApiTokenForm: this.$inertia.form({
                    name: '',
                    permissions: this.defaultPermissions,
                }, {
                    bag: 'createApiToken',
                    resetOnSuccess: true,
                }),

                updateApiTokenForm: this.$inertia.form({
                    permissions: []
                }, {
                    resetOnSuccess: false,
                    bag: 'updateApiToken',
                }),

                deleteApiTokenForm: this.$inertia.form(),

                displayingToken: false,
                managingPermissionsFor: null,
                apiTokenBeingDeleted: null,
            }
        },

        methods: {
            createApiToken() {
                this.createApiTokenForm.post(route('api-tokens.store'), {
                    preserveScroll: true,
                }).then(response => {
                    if (! this.createApiTokenForm.hasErrors()) {
                        this.displayingToken = true
                    }
                })
            },

            manageApiTokenPermissions(token) {
                this.updateApiTokenForm.permissions = token.abilities

                this.managingPermissionsFor = token
            },

            updateApiToken() {
                this.updateApiTokenForm.put(route('api-tokens.update', this.managingPermissionsFor), {
                    preserveScroll: true,
                    preserveState: true,
                }).then(response => {
                    this.managingPermissionsFor = null
                })
            },

            confirmApiTokenDeletion(token) {
                this.apiTokenBeingDeleted = token
            },

            deleteApiToken() {
                this.deleteApiTokenForm.delete(route('api-tokens.destroy', this.apiTokenBeingDeleted), {
                    preserveScroll: true,
                    preserveState: true,
                }).then(() => {
                    this.apiTokenBeingDeleted = null
                })
            },

            fromNow(timestamp) {
                return moment(timestamp).local().fromNow()
            },
        },
    }
</script>
