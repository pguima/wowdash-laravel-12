@section('title', __('View Profile'))
@section('subTitle', __('View Profile'))

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-4">
        <div
            class="user-grid-card relative border border-neutral-200 dark:border-neutral-600 rounded-2xl overflow-hidden bg-white dark:bg-neutral-700 h-full">
            <img src="{{ asset('assets/images/user-grid/user-grid-bg1.png') }}" alt="" class="w-full object-fit-cover">
            <div class="pb-6 ms-6 mb-6 me-6 -mt-[100px]">
                <div class="text-center border-b border-neutral-200 dark:border-neutral-600">
                    <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/user-grid/user-grid-img14.png') }}"
                        alt=""
                        class="border br-white border-width-2-px w-200-px h-[200px] rounded-full object-fit-cover mx-auto">
                    <h6 class="mb-0 mt-4">{{ Auth::user()->name }}</h6>
                    <span class="text-secondary-light mb-4">{{ Auth::user()->email }}</span>
                </div>
                <div class="mt-6">
                    <h6 class="text-xl mb-4">{{ __('Personal Info') }}</h6>
                    <ul>
                        <li class="flex items-center gap-1 mb-3">
                            <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200">{{ __('Full Name') }}</span>
                            <span class="w-[70%] text-secondary-light font-medium">: {{ Auth::user()->name }}</span>
                        </li>
                        <li class="flex items-center gap-1 mb-3">
                            <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200">{{ __('Email') }}</span>
                            <span class="w-[70%] text-secondary-light font-medium">: {{ Auth::user()->email }}</span>
                        </li>
                        <li class="flex items-center gap-1 mb-3">
                            <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200">{{ __('Department') }}</span>
                            <span class="w-[70%] text-secondary-light font-medium">:
                                {{ Auth::user()->department ?? '-' }}</span>
                        </li>
                        <li class="flex items-center gap-1 mb-3">
                            <span class="w-[30%] text-base font-semibold text-neutral-600 dark:text-neutral-200">{{ __('Designation') }}</span>
                            <span class="w-[70%] text-secondary-light font-medium">:
                                {{ Auth::user()->designation ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-8">
        <div class="card h-full border-0">
            <div class="card-body p-6" x-data="{ activeTab: 'edit-profile' }">

                <ul class="tab-style-gradient flex flex-wrap text-sm font-medium text-center mb-5">
                    <li class="cursor-pointer">
                        <button @click="activeTab = 'edit-profile'"
                            :class="{ 'text-primary-600 border-primary-600 bg-primary-50': activeTab === 'edit-profile', 'text-neutral-600 border-transparent hover:text-gray-600 hover:border-gray-300': activeTab !== 'edit-profile' }"
                            class="py-2.5 px-4 border-t-2 font-semibold text-base inline-flex items-center gap-3 transition-colors duration-200"
                            type="button">
                            {{ __('Edit Profile') }}
                        </button>
                    </li>
                    <li class="cursor-pointer">
                        <button @click="activeTab = 'change-password'"
                            :class="{ 'text-primary-600 border-primary-600 bg-primary-50': activeTab === 'change-password', 'text-neutral-600 border-transparent hover:text-gray-600 hover:border-gray-300': activeTab !== 'change-password' }"
                            class="py-2.5 px-4 border-t-2 font-semibold text-base inline-flex items-center gap-3 transition-colors duration-200"
                            type="button">
                            {{ __('Change Password') }}
                        </button>
                    </li>
                    <li class="cursor-pointer">
                        <button @click="activeTab = 'notification-password'"
                            :class="{ 'text-primary-600 border-primary-600 bg-primary-50': activeTab === 'notification-password', 'text-neutral-600 border-transparent hover:text-gray-600 hover:border-gray-300': activeTab !== 'notification-password' }"
                            class="py-2.5 px-4 border-t-2 font-semibold text-base inline-flex items-center gap-3 transition-colors duration-200"
                            type="button">
                            {{ __('Notification Settings') }}
                        </button>
                    </li>
                </ul>

                <div>
                    <!-- Edit Profile Tab -->
                    <div x-show="activeTab === 'edit-profile'" class="space-y-6">
                        @if (session()->has('message'))
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <h6 class="text-base text-neutral-600 dark:text-neutral-200 mb-4">{{ __('Profile Image') }}</h6>
                        <!-- Upload Image Start -->
                        <div class="mb-6 mt-4">
                            <div class="avatar-upload">
                                <div class="avatar-edit absolute bottom-0 end-0 me-6 mt-4 z-[1] cursor-pointer">
                                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" hidden
                                        wire:model="image">
                                    <label for="imageUpload"
                                        class="w-8 h-8 flex justify-center items-center bg-primary-100 dark:bg-primary-600/25 text-primary-600 dark:text-primary-400 border border-primary-600 hover:bg-primary-100 text-lg rounded-full">
                                        <iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
                                    </label>
                                </div>
                                <div class="avatar-preview">
                                    @if ($image)
                                        <div id="imagePreview"
                                            style="background-image: url('{{ $image->temporaryUrl() }}');">
                                        </div>
                                    @else
                                        <div id="imagePreview"
                                            style="background-image: url('{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/user-grid/user-grid-img14.png') }}');">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Upload Image End -->

                        <div wire:loading wire:target="image" class="text-sm text-primary-600 mt-2">
                            {{ __('Uploading image...') }}
                        </div>

                        <form wire:submit.prevent="updateProfile">
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6">
                                <div class="col-span-12 sm:col-span-6">
                                    <div class="mb-5">
                                        <label for="name"
                                            class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">{{ __('Full Name') }} <span class="text-danger-600">*</span></label>
                                        <input type="text" wire:model="name" class="form-control rounded-lg" id="name"
                                            placeholder="{{ __('Enter Full Name') }}">
                                        @error('name') <span class="text-danger-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <div class="mb-5">
                                        <label for="email"
                                            class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">{{ __('Email') }}
                                            <span class="text-danger-600">*</span></label>
                                        <input type="email" wire:model="email" class="form-control rounded-lg"
                                            id="email" placeholder="{{ __('Enter email address') }}">
                                        @error('email') <span class="text-danger-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <div class="mb-5">
                                        <label for="depart"
                                            class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">{{ __('Department') }}</label>
                                        <input type="text" wire:model="department" class="form-control rounded-lg"
                                            id="depart" placeholder="{{ __('Enter Department') }}">
                                        @error('department') <span class="text-danger-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <div class="mb-5">
                                        <label for="desig"
                                            class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">{{ __('Designation') }}</label>
                                        <input type="text" wire:model="designation" class="form-control rounded-lg"
                                            id="desig" placeholder="{{ __('Enter Designation') }}">
                                        @error('designation') <span
                                        class="text-danger-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-center gap-3">
                                <button type="submit"
                                    class="btn btn-primary border border-primary-600 text-base px-14 py-3 rounded-lg">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Tab -->
                    <div x-show="activeTab === 'change-password'" class="space-y-6" style="display: none;">
                        @if (session()->has('password_message'))
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                {{ session('password_message') }}
                            </div>
                        @endif

                        <form wire:submit.prevent="updatePassword">
                            <div class="mb-5">
                                <label for="current_password"
                                    class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">{{ __('Current Password') }} <span class="text-danger-600">*</span></label>
                                <div class="relative" x-data="{ show: false }">
                                    <input :type="show ? 'text' : 'password'" wire:model="current_password"
                                        class="form-control rounded-lg" id="current_password"
                                        placeholder="{{ __('Enter Current Password') }}">
                                    <span @click="show = !show"
                                        class="cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light">
                                        <iconify-icon :icon="show ? 'ri:eye-off-line' : 'ri:eye-line'"></iconify-icon>
                                    </span>
                                </div>
                                @error('current_password') <span class="text-danger-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="password"
                                    class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">{{ __('New Password') }} <span class="text-danger-600">*</span></label>
                                <div class="relative" x-data="{ show: false }">
                                    <input :type="show ? 'text' : 'password'" wire:model="password"
                                        class="form-control rounded-lg" id="password" placeholder="{{ __('Enter New Password') }}">
                                    <span @click="show = !show"
                                        class="cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light">
                                        <iconify-icon :icon="show ? 'ri:eye-off-line' : 'ri:eye-line'"></iconify-icon>
                                    </span>
                                </div>
                                @error('password') <span class="text-danger-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="password_confirmation"
                                    class="inline-block font-semibold text-neutral-600 dark:text-neutral-200 text-sm mb-2">{{ __('Confirm Password') }} <span class="text-danger-600">*</span></label>
                                <div class="relative" x-data="{ show: false }">
                                    <input :type="show ? 'text' : 'password'" wire:model="password_confirmation"
                                        class="form-control rounded-lg" id="password_confirmation"
                                        placeholder="{{ __('Confirm Password') }}">
                                    <span @click="show = !show"
                                        class="cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light">
                                        <iconify-icon :icon="show ? 'ri:eye-off-line' : 'ri:eye-line'"></iconify-icon>
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center justify-center gap-3">
                                <button type="submit"
                                    class="btn btn-primary border border-primary-600 text-base px-14 py-3 rounded-lg">
                                    {{ __('Change Password') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Notification Settings Tab -->
                    <div x-show="activeTab === 'notification-password'" class="space-y-6" style="display: none;">
                        <div class="form-switch switch-primary py-3 px-4 border rounded-lg relative mb-4">
                            <label for="companzNew" class="absolute w-full h-full start-0 top-0"></label>
                            <div class="flex items-center gap-3 justify-between">
                                <span class="form-check-label line-height-1 font-medium text-secondary-light">{{ __('Company News') }}</span>
                                <input class="form-check-input" type="checkbox" role="switch" id="companzNew">
                            </div>
                        </div>
                        <div class="form-switch switch-primary py-3 px-4 border rounded-lg relative mb-4">
                            <label for="pushNotifcation" class="absolute w-full h-full start-0 top-0"></label>
                            <div class="flex items-center gap-3 justify-between">
                                <span class="form-check-label line-height-1 font-medium text-secondary-light">{{ __('Push Notification') }}</span>
                                <input class="form-check-input" type="checkbox" role="switch" id="pushNotifcation"
                                    checked>
                            </div>
                        </div>
                        <div class="form-switch switch-primary py-3 px-4 border rounded-lg relative mb-4">
                            <label for="weeklyLetters" class="absolute w-full h-full start-0 top-0"></label>
                            <div class="flex items-center gap-3 justify-between">
                                <span class="form-check-label line-height-1 font-medium text-secondary-light">{{ __('Weekly News Letters') }}</span>
                                <input class="form-check-input" type="checkbox" role="switch" id="weeklyLetters"
                                    checked>
                            </div>
                        </div>
                        <div class="form-switch switch-primary py-3 px-4 border rounded-lg relative mb-4">
                            <label for="meetUp" class="absolute w-full h-full start-0 top-0"></label>
                            <div class="flex items-center gap-3 justify-between">
                                <span class="form-check-label line-height-1 font-medium text-secondary-light">{{ __('Meetups Near you') }}</span>
                                <input class="form-check-input" type="checkbox" role="switch" id="meetUp">
                            </div>
                        </div>
                        <div class="form-switch switch-primary py-3 px-4 border rounded-lg relative mb-4">
                            <label for="orderNotification" class="absolute w-full h-full start-0 top-0"></label>
                            <div class="flex items-center gap-3 justify-between">
                                <span class="form-check-label line-height-1 font-medium text-secondary-light">{{ __('Orders Notifications') }}</span>
                                <input class="form-check-input" type="checkbox" role="switch" id="orderNotification"
                                    checked>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>