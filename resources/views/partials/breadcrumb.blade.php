<div class="flex flex-wrap items-center justify-between gap-2 mb-6">
    <h6 class="font-semibold mb-0 dark:text-white">@yield('title')</h6>
    <ul class="flex items-center gap-[6px]">
        <li class="font-medium">
            <a href="index.php" class="flex items-center gap-2 hover:text-primary-600">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li class="-mt-0.5">
            <iconify-icon icon="heroicons:chevron-right-solid" class="icon text-sm"></iconify-icon>
        </li>
        <li class="font-medium text-primary-600">@yield('subTitle', 'Page')</li>
    </ul>
</div>