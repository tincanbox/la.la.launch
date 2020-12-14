<template>
    <gui-form-section @submitted="updateProfileInformation">
        <template #title>
            {{ __('page.profile:update:title') }}
        </template>

        <template #description>
            {{ __('page.profile:update:desc') }}
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <gui-label for="photo" :value="__('page.profile:update:photo')" />

                <div class="row mb-3">

                    <!-- Current Profile Photo -->
                    <div class="col-12 m-auto" v-show="! photoPreview">
                        <img
                            :src="user.profile_photo_url"
                            alt="Current Profile Photo" 
                            class="profile-photo-preview rounded-full object-cover"
                            :style="photoPreviewStyle"
                            >
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div class="col-12 m-auto" v-show="photoPreview">
                        <span
                            class="profile-photo-preview block rounded-full"
                            :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');' + photoPreviewStyle">
                        </span>
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-12 text-center">

                    <gui-secondary-button
                        @click.native.prevent="selectNewPhoto"
                        class="mt-2 mr-2"
                        type="button"
                        >
                        {{ __('page.profile:update:photo:select') }}
                    </gui-secondary-button>

                    <gui-secondary-button
                        v-if="user.profile_photo_path"
                        @click.native.prevent="deletePhoto"
                        type="button"
                        class="mt-2 mr-2"
                        >
                        {{ __('page.profile:update:photo:remove') }}
                    </gui-secondary-button>

                    <gui-secondary-button
                        v-if="photoPreview"
                        @click.native.prevent="cancelPhoto"
                        type="button"
                        class="mt-2 mr-2"
                        >
                        {{ __('$.nevermind') }}
                    </gui-secondary-button>

                    <gui-input-error :message="form.error('photo')" class="mt-2" />

                    </div>
                </div>

            </div>

            <div class="row mb-5">
                <!-- Name -->
                <div class="col-12 col-md-10 mb-3">
                    <gui-label for="name" :value="__('$.fullname')" />
                    <gui-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                    <gui-input-error :message="form.error('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="col-12 col-md-10 mb-3">
                    <gui-label for="email" :value="__('$.email')" />
                    <gui-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                    <gui-input-error :message="form.error('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="col-12 col-md-10 mb-3">
                    <gui-label for="phone" :value="__('$.phone')" />
                    <gui-input id="phone" type="phone" class="mt-1 block w-full" v-model="form.phone" />
                    <gui-input-error :message="form.error('phone')" class="mt-2" />
                </div>

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
    import GuiButton from '@/Component/Button'
    import GuiFormSection from '@/Component/FormSection'
    import GuiInput from '@/Component/Input'
    import GuiInputError from '@/Component/InputError'
    import GuiLabel from '@/Component/Label'
    import GuiActionMessage from '@/Component/ActionMessage'
    import GuiSecondaryButton from '@/Component/SecondaryButton'

    export default {
        components: {
            GuiActionMessage,
            GuiButton,
            GuiFormSection,
            GuiInput,
            GuiInputError,
            GuiLabel,
            GuiSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    phone: this.user.phone,
                    photo: null,
                }, {
                    bag: 'updateProfileInformation',
                    resetOnSuccess: false,
                }),

                photoPreview: null,

                photoPreviewStyle: "width:clamp(6rem, 40vw, 10rem); height:clamp(6rem, 40vw, 10rem);margin:auto;"
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            cancelPhoto(){
                this.photoPreview = null;
                this.$refs.photo.value = null;
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                }).then(() => {
                    this.photoPreview = null
                });
            },
        },
    }
</script>
