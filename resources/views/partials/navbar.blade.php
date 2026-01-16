<div class="navbar-header border-b border-neutral-200 dark:border-neutral-600">
    <div class="flex items-center justify-between">
        <div class="col-auto">
            <div class="flex flex-wrap items-center gap-[16px]">
                <button type="button" class="sidebar-toggle" @click="toggleSidebar()"
                    :class="{ 'active': isSidebarActive }">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon non-active"></iconify-icon>
                    <iconify-icon icon="iconoir:arrow-right" class="icon active"></iconify-icon>
                </button>
                <button type="button" class="sidebar-mobile-toggle d-flex !leading-[0]" @click="toggleMobileSidebar()">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon !text-[30px]"></iconify-icon>
                </button>
                <form class="navbar-search">
                    <input type="text" name="search" placeholder="Search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>

            </div>
        </div>
        <div class="col-auto">
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" id="theme-toggle"
                    class="w-10 h-10 bg-neutral-200 dark:bg-neutral-700 dark:text-white rounded-full flex justify-center items-center">
                    <span id="theme-toggle-dark-icon" class="hidden">
                        <i class="ri-sun-line"></i>
                    </span>
                    <span id="theme-toggle-light-icon" class="hidden">
                        <i class="ri-moon-line"></i>
                    </span>
                </button>

                <!-- Language Dropdown Start  -->
                <div class="hidden sm:inline-block" x-data="{
                        open: false,
                        currentLang: '{{ App::getLocale() }}',
                        languages: {
                            'en': { name: '{{ __('English') }}', flag: '{{ asset('assets/images/flags/flag1.png') }}' },
                            'pt_BR': { name: '{{ __('Portuguese (Brazil)') }}', flag: '{{ asset('assets/images/flags/flag2.png') }}' },
                            'es': { name: '{{ __('Spanish') }}', flag: '{{ asset('assets/images/flags/flag3.png') }}' }
                        },
                        switchLang(val) {
                            window.location.href = '{{ route('lang.switch', ':id') }}'.replace(':id', val);
                        }
                    }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="has-indicator w-10 h-10 bg-neutral-200 dark:bg-neutral-700 dark:text-white rounded-full flex justify-center items-center"
                        type="button">
                        <img :src="languages[currentLang].flag" alt="image" class="w-6 h-6 object-cover rounded-full">
                    </button>
                    <div x-show="open" style="display: none;"
                        class="z-10 absolute right-0 bg-white dark:bg-neutral-700 rounded-lg shadow-lg dropdown-menu-sm p-3 mt-2 min-w-[200px]"
                        x-transition>
                        <div
                            class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 mb-4 flex items-center justify-between gap-2">
                            <div>
                                <h6 class="text-lg text-neutral-900 font-semibold mb-0">Choose Your Language</h6>
                            </div>
                        </div>

                        <div class="max-h-[400px] overflow-y-auto scroll-sm pe-2">
                            <div class="mt-4 flex flex-col gap-4">
                                <!-- Languages -->
                                <div class="form-check style-check flex items-center justify-between mb-4">
                                    <label class="form-check-label line-height-1 font-medium text-secondary-light"
                                        for="english">
                                        <span
                                            class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3">
                                            <img src="{{ asset('assets/images/flags/flag1.png') }}" alt=""
                                                class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                                            <span class="text-base font-semibold mb-0">{{ __('English') }}</span>
                                        </span>
                                    </label>
                                    <input class="form-check-input rounded-full" name="language" type="radio"
                                        id="english" value="en" x-model="currentLang"
                                        @change="switchLang($event.target.value)">
                                </div>

                                <div class="form-check style-check flex items-center justify-between mb-4">
                                    <label class="form-check-label line-height-1 font-medium text-secondary-light"
                                        for="portuguese">
                                        <span
                                            class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3">
                                            <img src="{{ asset('assets/images/flags/flag2.png') }}" alt=""
                                                class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                                            <span
                                                class="text-base font-semibold mb-0">{{ __('Portuguese (Brazil)') }}</span>
                                        </span>
                                    </label>
                                    <input class="form-check-input rounded-full" name="language" type="radio"
                                        id="portuguese" value="pt_BR" x-model="currentLang"
                                        @change="switchLang($event.target.value)">
                                </div>

                                <div class="form-check style-check flex items-center justify-between">
                                    <label class="form-check-label line-height-1 font-medium text-secondary-light"
                                        for="spanish">
                                        <span
                                            class="text-black hover-bXg-transparent hover-text-primary flex items-center gap-3">
                                            <img src="{{ asset('assets/images/flags/flag3.png') }}" alt=""
                                                class="w-9 h-9 bg-success-subtle text-success-600 rounded-full shrink-0">
                                            <span class="text-base font-semibold mb-0">{{ __('Spanish') }}</span>
                                        </span>
                                    </label>
                                    <input class="form-check-input rounded-full" name="language" type="radio"
                                        id="spanish" value="es" x-model="currentLang"
                                        @change="switchLang($event.target.value)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Language Dropdown End  -->

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="flex justify-center items-center rounded-full" type="button">
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/user.png') }}"
                            alt="image" class="w-10 h-10 object-cover rounded-full">
                    </button>
                    <div x-show="open" style="display: none;"
                        class="z-10 absolute right-0 top-full mt-2 bg-white dark:bg-neutral-700 rounded-lg shadow-lg dropdown-menu-sm p-3 min-w-[200px]"
                        x-transition>
                        <div
                            class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 mb-4 flex items-center justify-between gap-2">
                            <div>
                                <h6 class="text-lg text-neutral-900 font-semibold mb-0">{{ Auth::user()->name }}</h6>
                                <span class="text-neutral-500">{{ Auth::user()->role }}</span>
                            </div>
                            <button type="button" class="hover:text-danger-600" @click="open = false">
                                <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                            </button>
                        </div>

                        <div class="max-h-[400px] overflow-y-auto scroll-sm pe-2">
                            <ul class="flex flex-col">
                                <li>
                                    <a class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4"
                                        href="{{ route('view-profile') }}">
                                        <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>
                                        {{ __('My Profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="text-black px-0 py-2 hover:text-danger-600 flex items-center gap-4"
                                        href="{{ route('logout') }}">
                                        <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon>
                                        {{ __('Log Out') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>