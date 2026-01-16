<aside class="sidebar" :class="{ 'active': isSidebarActive, 'sidebar-open': isMobileSidebarOpen }">
    <button type="button" class="sidebar-close-btn !mt-4" @click="isMobileSidebarOpen = false">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ url('/') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active' : '' }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span class="text-xs">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('users') }}" class="{{ Request::is('users') ? 'active' : '' }}">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span class="text-xs">{{ __('Users') }}</span>
                </a>
            </li>

            <li class="sidebar-menu-group-title">Application</li>

            <li class="dropdown" x-data="{ open: false }">
                <a href="javascript:void(0)" @click="open = !open" :class="{ 'dropdown-open': open }">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>{{ __('Users') }}</span>
                </a>
                <ul class="sidebar-submenu" x-show="open" x-collapse style="display: none;">
                    <li>
                        <a href="{{ route('users') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            {{ __('Users List') }}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>