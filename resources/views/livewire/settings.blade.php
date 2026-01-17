<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Left Column: System Status/Branding -->
    <div class="col-span-12 lg:col-span-4">
        <div
            class="user-grid-card relative border border-neutral-200 dark:border-neutral-600 rounded-2xl overflow-hidden bg-white dark:bg-neutral-700 h-full">
            <div class="pb-6 ms-6 mb-6 me-6 mt-6">
                <div class="text-center border-b border-neutral-200 dark:border-neutral-600 pb-6">
                    <div
                        class="border br-white border-width-2-px w-full h-[120px] rounded-lg object-fit-contain mx-auto bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center p-4">
                        @if($currentLogoLight)
                            <img src="{{ asset('storage/' . $currentLogoLight) }}" alt="System Logo"
                                class="max-h-full max-w-full">
                        @else
                            <span class="text-neutral-400">No Logo</span>
                        @endif
                    </div>
                    <h6 class="mb-0 mt-4 font-semibold text-lg">{{ __('System Settings') }}</h6>
                    <span class="text-secondary-light mb-4 text-sm">{{ __('Manage global configurations') }}</span>
                </div>
                <div class="mt-6">
                    <h6 class="text-xl mb-4 font-semibold">{{ __('Quick Status') }}</h6>
                    <ul>
                        <li class="flex items-center gap-1 mb-3">
                            <span
                                class="w-[40%] text-sm font-semibold text-neutral-600 dark:text-neutral-200">{{ __('Departments') }}</span>
                            <span class="w-[60%] text-secondary-light font-medium text-sm">:
                                {{ \App\Models\Department::count() }}</span>
                        </li>
                        <li class="flex items-center gap-1 mb-3">
                            <span
                                class="w-[40%] text-sm font-semibold text-neutral-600 dark:text-neutral-200">{{ __('Designations') }}</span>
                            <span class="w-[60%] text-secondary-light font-medium text-sm">:
                                {{ \App\Models\Designation::count() }}</span>
                        </li>
                        <li class="flex items-center gap-1 mb-3">
                            <span
                                class="w-[40%] text-sm font-semibold text-neutral-600 dark:text-neutral-200">{{ __('Favicon') }}</span>
                            <span class="w-[60%] text-secondary-light font-medium text-sm text-center">
                                @if($currentFavicon)
                                    : <img src="{{ asset('storage/' . $currentFavicon) }}" class="h-4 w-4 inline ml-1"
                                        alt="Favicon">
                                @else
                                    : {{ __('Not Set') }}
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Settings Tabs & Content -->
    <div class="col-span-12 lg:col-span-8">
        <div class="card h-full border-0">
            <div class="card-body p-6">

                <!-- Tabs Navigation -->
                <ul
                    class="tab-style-gradient flex flex-wrap text-sm font-medium text-center mb-5 border-b border-neutral-200 dark:border-neutral-600">
                    <li class="me-2" role="presentation">
                        <button wire:click="$set('activeTab', 'general')"
                            class="py-2.5 px-4 rounded-t-lg border-t-2 font-semibold text-base inline-flex items-center gap-3 transition-colors duration-200
                            {{ $activeTab === 'general'
    ? 'border-primary-600 text-primary-600 bg-primary-50 dark:bg-primary-900/10'
    : 'border-transparent text-neutral-600 hover:text-neutral-800 hover:bg-neutral-50 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-700' }}"
                            type="button" role="tab">
                            <iconify-icon icon="solar:settings-bold" class="text-lg"></iconify-icon>
                            {{ __('General') }}
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button wire:click="$set('activeTab', 'departments')"
                            class="py-2.5 px-4 rounded-t-lg border-t-2 font-semibold text-base inline-flex items-center gap-3 transition-colors duration-200
                            {{ $activeTab === 'departments'
    ? 'border-primary-600 text-primary-600 bg-primary-50 dark:bg-primary-900/10'
    : 'border-transparent text-neutral-600 hover:text-neutral-800 hover:bg-neutral-50 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-700' }}"
                            type="button" role="tab">
                            <iconify-icon icon="solar:buildings-2-bold" class="text-lg"></iconify-icon>
                            {{ __('Departments') }}
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button wire:click="$set('activeTab', 'designations')"
                            class="py-2.5 px-4 rounded-t-lg border-t-2 font-semibold text-base inline-flex items-center gap-3 transition-colors duration-200
                            {{ $activeTab === 'designations'
    ? 'border-primary-600 text-primary-600 bg-primary-50 dark:bg-primary-900/10'
    : 'border-transparent text-neutral-600 hover:text-neutral-800 hover:bg-neutral-50 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-700' }}"
                            type="button" role="tab">
                            <iconify-icon icon="solar:user-id-bold" class="text-lg"></iconify-icon>
                            {{ __('Designations') }}
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div>
                    <!-- General Settings -->
                    @if($activeTab === 'general')
                        <form wire:submit.prevent="saveLogos" enctype="multipart/form-data" class="animate-fade-in">
                            <h6 class="mb-4 text-lg font-semibold text-neutral-600 dark:text-neutral-200">
                                {{ __('Theme & Logo Settings') }}
                            </h6>

                            <!-- Sidebar Open Logos -->
                            <div class="grid md:grid-cols-2 gap-x-6 mb-6">
                                <!-- Light Mode Logo -->
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold mb-2 text-neutral-600 dark:text-neutral-200">
                                        {{ __('Light Mode Logo') }} <span
                                            class="text-xs font-normal text-neutral-400">({{ __('168 x 40 px') }})</span>
                                    </label>
                                    <div class="upload-image-wrapper flex items-center gap-3">
                                        @if ($logo_light)
                                            <!-- Preview New Upload -->
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <button wire:click="$set('logo_light', null)" type="button"
                                                    class="uploaded-img__remove absolute top-0 end-0 z-1 text-2xxl line-height-1 me-2 mt-2 flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img src="{{ $logo_light->temporaryUrl() }}"
                                                    class="w-full h-full object-contain p-2" alt="New Logo">
                                            </div>
                                        @elseif($currentLogoLight)
                                            <!-- Current Logo -->
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <img src="{{ asset('storage/' . $currentLogoLight) }}"
                                                    class="w-full h-full object-contain p-2" alt="Current Logo">
                                            </div>
                                        @endif

                                        <!-- Upload Input -->
                                        <label
                                            class="upload-file h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-500 cursor-pointer flex items-center flex-col justify-center gap-1 transition-colors duration-200"
                                            for="upload-logo-light">
                                            <div wire:loading.remove wire:target="logo_light"
                                                class="flex flex-col items-center gap-1">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="font-semibold text-secondary-light">{{ __('Upload') }}</span>
                                            </div>
                                            <div wire:loading wire:target="logo_light"
                                                class="spinner-border text-secondary-light"></div>
                                            <input type="file" id="upload-logo-light" wire:model="logo_light" hidden
                                                accept="image/*">
                                        </label>
                                    </div>
                                    @error('logo_light') <span
                                    class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    <p class="text-xs text-neutral-500 mt-2">
                                        {{ __('Visible when sidebar is expanded in Light Mode.') }}
                                    </p>
                                </div>

                                <!-- Dark Mode Logo -->
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold mb-2 text-neutral-600 dark:text-neutral-200">
                                        {{ __('Dark Mode Logo') }} <span
                                            class="text-xs font-normal text-neutral-400">({{ __('168 x 40 px') }})</span>
                                    </label>
                                    <div class="upload-image-wrapper flex items-center gap-3">
                                        @if ($logo_dark)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <button wire:click="$set('logo_dark', null)" type="button"
                                                    class="uploaded-img__remove absolute top-0 end-0 z-1 text-2xxl line-height-1 me-2 mt-2 flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img src="{{ $logo_dark->temporaryUrl() }}"
                                                    class="w-full h-full object-contain p-2" alt="New Logo">
                                            </div>
                                        @elseif($currentLogoDark)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <img src="{{ asset('storage/' . $currentLogoDark) }}"
                                                    class="w-full h-full object-contain p-2" alt="Current Logo">
                                            </div>
                                        @endif

                                        <label
                                            class="upload-file h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-500 cursor-pointer flex items-center flex-col justify-center gap-1 transition-colors duration-200"
                                            for="upload-logo-dark">
                                            <div wire:loading.remove wire:target="logo_dark"
                                                class="flex flex-col items-center gap-1">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="font-semibold text-secondary-light">{{ __('Upload') }}</span>
                                            </div>
                                            <div wire:loading wire:target="logo_dark"
                                                class="spinner-border text-secondary-light"></div>
                                            <input type="file" id="upload-logo-dark" wire:model="logo_dark" hidden
                                                accept="image/*">
                                        </label>
                                    </div>
                                    @error('logo_dark') <span
                                    class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    <p class="text-xs text-neutral-500 mt-2">
                                        {{ __('Visible when sidebar is expanded in Dark Mode.') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Sidebar Closed & Favicon -->
                            <div class="grid md:grid-cols-2 gap-x-6 mb-6">
                                <!-- Logo Icon Light -->
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold mb-2 text-neutral-600 dark:text-neutral-200">
                                        {{ __('Logo Icon') }} <span
                                            class="text-xs font-normal text-neutral-400">({{ __('Light Mode - 43 x 40 px') }})</span>
                                    </label>
                                    <div class="upload-image-wrapper flex items-center gap-3">
                                        @if ($logo_icon_light)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <button wire:click="$set('logo_icon_light', null)" type="button"
                                                    class="uploaded-img__remove absolute top-0 end-0 z-1 text-2xxl line-height-1 me-2 mt-2 flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img src="{{ $logo_icon_light->temporaryUrl() }}"
                                                    class="w-full h-full object-contain p-2" alt="New Icon">
                                            </div>
                                        @elseif($currentLogoIconLight)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <img src="{{ asset('storage/' . $currentLogoIconLight) }}"
                                                    class="w-full h-full object-contain p-2" alt="Current Icon">
                                            </div>
                                        @endif

                                        <label
                                            class="upload-file h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-500 cursor-pointer flex items-center flex-col justify-center gap-1 transition-colors duration-200"
                                            for="upload-logo-icon-light">
                                            <div wire:loading.remove wire:target="logo_icon_light"
                                                class="flex flex-col items-center gap-1">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="font-semibold text-secondary-light">{{ __('Upload') }}</span>
                                            </div>
                                            <div wire:loading wire:target="logo_icon_light"
                                                class="spinner-border text-secondary-light"></div>
                                            <input type="file" id="upload-logo-icon-light" wire:model="logo_icon_light"
                                                hidden accept="image/*">
                                        </label>
                                    </div>
                                    @error('logo_icon_light') <span
                                    class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    <p class="text-xs text-neutral-500 mt-2">
                                        {{ __('Visible when sidebar is collapsed in Light Mode.') }}
                                    </p>
                                </div>

                                <!-- Logo Icon Dark -->
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold mb-2 text-neutral-600 dark:text-neutral-200">
                                        {{ __('Logo Icon') }} <span
                                            class="text-xs font-normal text-neutral-400">({{ __('Dark Mode - 43 x 40 px') }})</span>
                                    </label>
                                    <div class="upload-image-wrapper flex items-center gap-3">
                                        @if ($logo_icon_dark)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <button wire:click="$set('logo_icon_dark', null)" type="button"
                                                    class="uploaded-img__remove absolute top-0 end-0 z-1 text-2xxl line-height-1 me-2 mt-2 flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img src="{{ $logo_icon_dark->temporaryUrl() }}"
                                                    class="w-full h-full object-contain p-2" alt="New Icon">
                                            </div>
                                        @elseif($currentLogoIconDark)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <img src="{{ asset('storage/' . $currentLogoIconDark) }}"
                                                    class="w-full h-full object-contain p-2" alt="Current Icon">
                                            </div>
                                        @endif

                                        <label
                                            class="upload-file h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-500 cursor-pointer flex items-center flex-col justify-center gap-1 transition-colors duration-200"
                                            for="upload-logo-icon-dark">
                                            <div wire:loading.remove wire:target="logo_icon_dark"
                                                class="flex flex-col items-center gap-1">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="font-semibold text-secondary-light">{{ __('Upload') }}</span>
                                            </div>
                                            <div wire:loading wire:target="logo_icon_dark"
                                                class="spinner-border text-secondary-light"></div>
                                            <input type="file" id="upload-logo-icon-dark" wire:model="logo_icon_dark" hidden
                                                accept="image/*">
                                        </label>
                                    </div>
                                    @error('logo_icon_dark') <span
                                    class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    <p class="text-xs text-neutral-500 mt-2">
                                        {{ __('Visible when sidebar is collapsed in Dark Mode.') }}
                                    </p>
                                </div>

                                <!-- Favicon -->
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold mb-2 text-neutral-600 dark:text-neutral-200">
                                        {{ __('Favicon') }} <span
                                            class="text-xs font-normal text-neutral-400">({{ __('16 x 16 px') }})</span>
                                    </label>
                                    <div class="upload-image-wrapper flex items-center gap-3">
                                        @if ($favicon)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <button wire:click="$set('favicon', null)" type="button"
                                                    class="uploaded-img__remove absolute top-0 end-0 z-1 text-2xxl line-height-1 me-2 mt-2 flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img src="{{ $favicon->temporaryUrl() }}"
                                                    class="w-full h-full object-contain p-2" alt="New Favicon">
                                            </div>
                                        @elseif($currentFavicon)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <img src="{{ asset('storage/' . $currentFavicon) }}"
                                                    class="w-full h-full object-contain p-2" alt="Current Favicon">
                                            </div>
                                        @endif

                                        <label
                                            class="upload-file h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-500 cursor-pointer flex items-center flex-col justify-center gap-1 transition-colors duration-200"
                                            for="upload-favicon">
                                            <div wire:loading.remove wire:target="favicon"
                                                class="flex flex-col items-center gap-1">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="font-semibold text-secondary-light">{{ __('Upload') }}</span>
                                            </div>
                                            <div wire:loading wire:target="favicon"
                                                class="spinner-border text-secondary-light"></div>
                                            <input type="file" id="upload-favicon" wire:model="favicon" hidden
                                                accept="image/*">
                                        </label>
                                    </div>
                                    @error('favicon') <span class="text-danger-600 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                    <p class="text-xs text-neutral-500 mt-2">{{ __('Browser tab icon.') }}</p>
                                </div>
                            </div>

                            <hr class="border-neutral-200 dark:border-neutral-700 my-8">

                            <h6 class="text-lg font-bold mb-4 text-neutral-800 dark:text-neutral-100">
                                {{ __('Auth Pages Images') }}
                            </h6>

                            <!-- Login/Register Backgrounds -->
                            <div class="grid md:grid-cols-2 gap-x-6 mb-6">
                                <!-- Auth BG Light -->
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold mb-2 text-neutral-600 dark:text-neutral-200">
                                        {{ __('Login/Register BG') }} <span
                                            class="text-xs font-normal text-neutral-400">({{ __('Light Mode - 917 x 917 px') }})</span>
                                    </label>
                                    <div class="upload-image-wrapper flex items-center gap-3">
                                        @if ($auth_bg_light)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <button wire:click="$set('auth_bg_light', null)" type="button"
                                                    class="uploaded-img__remove absolute top-0 end-0 z-1 text-2xxl line-height-1 me-2 mt-2 flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img src="{{ $auth_bg_light->temporaryUrl() }}"
                                                    class="w-full h-full object-contain p-2" alt="New Auth BG">
                                            </div>
                                        @elseif($currentAuthBgLight)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <img src="{{ asset('storage/' . $currentAuthBgLight) }}"
                                                    class="w-full h-full object-contain p-2" alt="Current Auth BG">
                                            </div>
                                        @endif

                                        <label
                                            class="upload-file h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-500 cursor-pointer flex items-center flex-col justify-center gap-1 transition-colors duration-200"
                                            for="upload-auth-bg-light">
                                            <div wire:loading.remove wire:target="auth_bg_light"
                                                class="flex flex-col items-center gap-1">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="font-semibold text-secondary-light">{{ __('Upload') }}</span>
                                            </div>
                                            <div wire:loading wire:target="auth_bg_light"
                                                class="spinner-border text-secondary-light"></div>
                                            <input type="file" id="upload-auth-bg-light" wire:model="auth_bg_light" hidden
                                                accept="image/*">
                                        </label>
                                    </div>
                                    @error('auth_bg_light') <span
                                    class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <!-- Auth BG Dark -->
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold mb-2 text-neutral-600 dark:text-neutral-200">
                                        {{ __('Login/Register BG') }} <span
                                            class="text-xs font-normal text-neutral-400">({{ __('Dark Mode - 917 x 917 px') }})</span>
                                    </label>
                                    <div class="upload-image-wrapper flex items-center gap-3">
                                        @if ($auth_bg_dark)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <button wire:click="$set('auth_bg_dark', null)" type="button"
                                                    class="uploaded-img__remove absolute top-0 end-0 z-1 text-2xxl line-height-1 me-2 mt-2 flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img src="{{ $auth_bg_dark->temporaryUrl() }}"
                                                    class="w-full h-full object-contain p-2" alt="New Auth BG">
                                            </div>
                                        @elseif($currentAuthBgDark)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <img src="{{ asset('storage/' . $currentAuthBgDark) }}"
                                                    class="w-full h-full object-contain p-2" alt="Current Auth BG">
                                            </div>
                                        @endif

                                        <label
                                            class="upload-file h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-500 cursor-pointer flex items-center flex-col justify-center gap-1 transition-colors duration-200"
                                            for="upload-auth-bg-dark">
                                            <div wire:loading.remove wire:target="auth_bg_dark"
                                                class="flex flex-col items-center gap-1">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="font-semibold text-secondary-light">{{ __('Upload') }}</span>
                                            </div>
                                            <div wire:loading wire:target="auth_bg_dark"
                                                class="spinner-border text-secondary-light"></div>
                                            <input type="file" id="upload-auth-bg-dark" wire:model="auth_bg_dark" hidden
                                                accept="image/*">
                                        </label>
                                    </div>
                                    @error('auth_bg_dark') <span
                                    class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Forgot Password Backgrounds -->
                            <div class="grid md:grid-cols-2 gap-x-6 mb-6">
                                <!-- Forgot BG Light -->
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold mb-2 text-neutral-600 dark:text-neutral-200">
                                        {{ __('Forgot Password BG') }} <span
                                            class="text-xs font-normal text-neutral-400">({{ __('Light Mode - 796 x 796 px') }})</span>
                                    </label>
                                    <div class="upload-image-wrapper flex items-center gap-3">
                                        @if ($forgot_bg_light)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <button wire:click="$set('forgot_bg_light', null)" type="button"
                                                    class="uploaded-img__remove absolute top-0 end-0 z-1 text-2xxl line-height-1 me-2 mt-2 flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img src="{{ $forgot_bg_light->temporaryUrl() }}"
                                                    class="w-full h-full object-contain p-2" alt="New Forgot BG">
                                            </div>
                                        @elseif($currentForgotBgLight)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <img src="{{ asset('storage/' . $currentForgotBgLight) }}"
                                                    class="w-full h-full object-contain p-2" alt="Current Forgot BG">
                                            </div>
                                        @endif

                                        <label
                                            class="upload-file h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-500 cursor-pointer flex items-center flex-col justify-center gap-1 transition-colors duration-200"
                                            for="upload-forgot-bg-light">
                                            <div wire:loading.remove wire:target="forgot_bg_light"
                                                class="flex flex-col items-center gap-1">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="font-semibold text-secondary-light">{{ __('Upload') }}</span>
                                            </div>
                                            <div wire:loading wire:target="forgot_bg_light"
                                                class="spinner-border text-secondary-light"></div>
                                            <input type="file" id="upload-forgot-bg-light" wire:model="forgot_bg_light"
                                                hidden accept="image/*">
                                        </label>
                                    </div>
                                    @error('forgot_bg_light') <span
                                    class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <!-- Forgot BG Dark -->
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold mb-2 text-neutral-600 dark:text-neutral-200">
                                        {{ __('Forgot Password BG') }} <span
                                            class="text-xs font-normal text-neutral-400">({{ __('Dark Mode - 796 x 796 px') }})</span>
                                    </label>
                                    <div class="upload-image-wrapper flex items-center gap-3">
                                        @if ($forgot_bg_dark)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <button wire:click="$set('forgot_bg_dark', null)" type="button"
                                                    class="uploaded-img__remove absolute top-0 end-0 z-1 text-2xxl line-height-1 me-2 mt-2 flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img src="{{ $forgot_bg_dark->temporaryUrl() }}"
                                                    class="w-full h-full object-contain p-2" alt="New Forgot BG">
                                            </div>
                                        @elseif($currentForgotBgDark)
                                            <div
                                                class="uploaded-img relative h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600">
                                                <img src="{{ asset('storage/' . $currentForgotBgDark) }}"
                                                    class="w-full h-full object-contain p-2" alt="Current Forgot BG">
                                            </div>
                                        @endif

                                        <label
                                            class="upload-file h-[120px] w-[120px] border input-form-light rounded-lg overflow-hidden border-dashed bg-neutral-50 dark:bg-neutral-600 hover:bg-neutral-200 dark:hover:bg-neutral-500 cursor-pointer flex items-center flex-col justify-center gap-1 transition-colors duration-200"
                                            for="upload-forgot-bg-dark">
                                            <div wire:loading.remove wire:target="forgot_bg_dark"
                                                class="flex flex-col items-center gap-1">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="font-semibold text-secondary-light">{{ __('Upload') }}</span>
                                            </div>
                                            <div wire:loading wire:target="forgot_bg_dark"
                                                class="spinner-border text-secondary-light"></div>
                                            <input type="file" id="upload-forgot-bg-dark" wire:model="forgot_bg_dark" hidden
                                                accept="image/*">
                                        </label>
                                    </div>
                                    @error('forgot_bg_dark') <span
                                    class="text-danger-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex justify-end mt-4">
                                <button type="submit" class="btn btn-primary px-6 py-2 rounded-lg flex items-center gap-2">
                                    <div wire:loading wire:target="saveLogos" class="spinner-border spinner-border-sm">
                                    </div>
                                    {{ __('Save Changes') }}
                                </button>
                            </div>
                        </form>

                        <!-- Departments Tab -->
                    @elseif($activeTab === 'departments')
                        <div class="animate-fade-in">
                            <h6 class="mb-4 text-lg font-semibold text-neutral-600 dark:text-neutral-200">
                                {{ __('Manage Departments') }}
                            </h6>
                            <div class="flex gap-2 mb-6">
                                <input type="text" wire:model="newDepartment" wire:keydown.enter="addDepartment"
                                    placeholder="{{ __('New Department Name') }}"
                                    class="form-control w-full md:w-1/2 rounded-lg">
                                <button wire:click="addDepartment"
                                    class="btn btn-primary px-4 py-2 rounded-lg">{{ __('Add') }}</button>
                            </div>
                            @error('newDepartment') <span class="text-danger-600 text-sm block mb-4">{{ $message }}</span>
                            @enderror

                            <div class="table-responsive">
                                <table class="table bordered-table sm-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th class="text-end">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($departments as $dept)
                                            <tr>
                                                <td>{{ $dept->name }}</td>
                                                <td class="text-end">
                                                    <button wire:click="removeDepartment({{ $dept->id }})"
                                                        class="text-danger-600 hover:text-danger-700">
                                                        <iconify-icon icon="fluent:delete-24-regular"
                                                            class="text-xl"></iconify-icon>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-neutral-400">
                                                    {{ __('No departments found.') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Designations Tab -->
                    @elseif($activeTab === 'designations')
                        <div class="animate-fade-in">
                            <h6 class="mb-4 text-lg font-semibold text-neutral-600 dark:text-neutral-200">
                                {{ __('Manage Designations') }}
                            </h6>
                            <div class="flex gap-2 mb-6">
                                <select wire:model="selectedDepartmentId" class="form-select w-full md:w-1/3 rounded-lg">
                                    <option value="">{{ __('Select Department') }}</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" wire:model="newDesignation" wire:keydown.enter="addDesignation"
                                    placeholder="{{ __('New Designation Name') }}"
                                    class="form-control w-full md:w-1/2 rounded-lg">
                                <button wire:click="addDesignation"
                                    class="btn btn-primary px-4 py-2 rounded-lg">{{ __('Add') }}</button>
                            </div>
                            @error('selectedDepartmentId') <span
                            class="text-danger-600 text-sm block mb-1">{{ $message }}</span> @enderror
                            @error('newDesignation') <span class="text-danger-600 text-sm block mb-4">{{ $message }}</span>
                            @enderror

                            <div class="table-responsive">
                                <table class="table bordered-table sm-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Department') }}</th>
                                            <th class="text-end">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($designations as $desig)
                                            <tr>
                                                <td>{{ $desig->name }}</td>
                                                <td>{{ $desig->department->name ?? '-' }}</td>
                                                <td class="text-end">
                                                    <button wire:click="removeDesignation({{ $desig->id }})"
                                                        class="text-danger-600 hover:text-danger-700">
                                                        <iconify-icon icon="fluent:delete-24-regular"
                                                            class="text-xl"></iconify-icon>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-neutral-400">
                                                    {{ __('No designations found.') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>