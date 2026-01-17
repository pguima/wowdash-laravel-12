<aside class="sidebar" :class="{ 'active': isSidebarActive, 'sidebar-open': isMobileSidebarOpen }">
    <button type="button" class="sidebar-close-btn !mt-4" @click="isMobileSidebarOpen = false">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <style>
            /* Force hide light icon in dark mode */
            html.dark .sidebar .sidebar-logo img.logo-icon.light-icon {
                display: none !important;
            }

            /* Force hide dark icon in light mode */
            html:not(.dark) .sidebar .sidebar-logo img.logo-icon.dark-icon {
                display: none !important;
            }

            /* Active Route Styling (replaces active-page from legacy JS) */
            .sidebar-menu li>a.active-route {
                background-color: rgb(72 127 255);
                color: white;
            }

            .sidebar-menu .sidebar-submenu li a.active-route {
                background-color: rgb(228 241 255);
                color: rgb(17 24 39);
            }

            html.dark .sidebar-menu .sidebar-submenu li a.active-route {
                background-color: rgb(75 85 99);
                color: white;
            }

            /* Fix: Ensure submenu is hidden when sidebar is collapsed (active) AND not hovered.
               This allows the sidebar to shrink to icon-width. */
            html .sidebar.active:not(:hover) .sidebar-submenu {
                display: none !important;
            }
        </style>
        @php
            $logoLight = \App\Models\Setting::where('key', 'logo_light')->value('value');
            $logoDark = \App\Models\Setting::where('key', 'logo_dark')->value('value');
            $logoIconLight = \App\Models\Setting::where('key', 'logo_icon_light')->value('value') ?? 'assets/images/logo-icon.png';
            $logoIconDark = \App\Models\Setting::where('key', 'logo_icon_dark')->value('value') ?? 'assets/images/logo-icon.png';
        @endphp
        <a href="{{ url('/') }}" class="sidebar-logo">
            <!-- Sidebar Open Logos -->
            <img src="{{ $logoLight ? asset('storage/' . $logoLight) : asset('assets/images/logo.png') }}"
                alt="site logo" class="light-logo">
            <img src="{{ $logoDark ? asset('storage/' . $logoDark) : asset('assets/images/logo-light.png') }}"
                alt="site logo" class="dark-logo">

            <!-- Sidebar Closed Logos (Icon) -->
            <img src="{{ asset($logoIconLight) }}" alt="site logo" class="logo-icon light-icon">
            <img src="{{ asset($logoIconDark) }}" alt="site logo" class="logo-icon dark-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active-route' : '' }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span class="text-xs">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('users') }}" class="{{ Request::is('users') ? 'active-route' : '' }}">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span class="text-xs">{{ __('Users') }}</span>
                </a>
            </li>


            <li class="sidebar-menu-group-title">{{ __('Configuration') }}</li>
            <li>
                <a href="{{ route('settings') }}" class="{{ Request::is('settings') ? 'active-route' : '' }}">
                    <iconify-icon icon="solar:settings-outline" class="menu-icon"></iconify-icon>
                    <span class="text-xs">{{ __('System Settings') }}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>