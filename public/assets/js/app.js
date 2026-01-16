
'use strict';

'use strict';

function initApp() {
  // sidebar submenu collapsible js
  document.querySelectorAll(".sidebar-menu .dropdown").forEach(function (dropdown) {
    // Remove existing listeners to avoid duplicates if re-initializing on same nodes (though Livewire usually replaces them)
    // A clean way is to clone and replace or just trust the DOM replacement.
    // For simplicity and safety with Livewire's DOM diffing, we'll assume fresh elements, 
    // but if elements persist, we might double-bind. 
    // However, usually sidebar is part of layout which might NOT be replaced if it's outside the slot?
    // Wait, if sidebar is outside the {{ $slot }}, it is NOT replaced by wire:navigate unless it's in a persist block.
    // BUT, the user said sidebar "blinks", implying full page reload was happening before.
    // With wire:navigate, only the body changes. 
    // If sidebar is STATIC (in layout, outside @yield('content')), then wire:navigate DOES NOT replace it.
    // IF elements are not replaced, running this again duplicates listeners.
    // We should check if listener is already attached or use event delegation.

    // BETTER APPROACH for static sidebar: Event Delegation on the sidebar container.
  });

  // Actually, looking at the previous code, it binds to .dropdown.
  // If sidebar is static (not reloading), then we don't need to re-bind these listeners!
  // The issue reported is "sidebar and menu don't function".
  // This suggests they ARE being replaced or the state is lost.
  // OR, maybe the "Active Page" highlighting logic (which runs on load) isn't updating.

  // Let's stick to the user's request: "sidebar and top menu not working".
  // If they are static, they should keep working.
  // UNLESS the user implementation of wire:navigate REPLACED them?
  // In standard Livewire usage, wire:navigate creates a SPA experience.
  // If the sidebar is in the layout (app.blade.php) and we navigate, the head and body scripts re-evaluate?
  // No, scripts in head don't re-run.

  // Let's assume we need to re-run the "Active Page" logic for sure.
  // The toggles might be broken if the DOM was updated.

  runSidebarLogic();
  runThemeLogic();

  // Re-init Flowbite if available
  if (typeof initFlowbite === 'function') {
    initFlowbite();
  }
}

function runSidebarLogic() {
  // We'll use event delegation for the sidebar to be safe against DOM updates AND static elements
  const sidebarMenu = document.querySelector('.sidebar-menu');
  if (sidebarMenu && !sidebarMenu.dataset.bound) {
    sidebarMenu.addEventListener('click', function (e) {
      const dropdownTrigger = e.target.closest('.dropdown > a');
      if (dropdownTrigger) {
        const dropdown = dropdownTrigger.closest('.dropdown');
        const submenu = dropdown.querySelector('.sidebar-submenu');

        // Close siblings
        const siblings = dropdown.closest('ul').querySelectorAll('.dropdown');
        siblings.forEach(function (sibling) {
          if (sibling !== dropdown) {
            const sb = sibling.querySelector('.sidebar-submenu');
            if (sb) sb.style.display = 'none';
            sibling.classList.remove('dropdown-open', 'open');
          }
        });

        // Toggle current
        if (submenu) {
          submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
        }
        dropdown.classList.toggle('dropdown-open');
      }
    });
    sidebarMenu.dataset.bound = 'true';
  }

  // Toggle sidebar visibility
  const sidebarToggle = document.querySelector(".sidebar-toggle");
  if (sidebarToggle && !sidebarToggle.dataset.bound) {
    sidebarToggle.addEventListener("click", function () {
      this.classList.toggle("active");
      document.querySelector(".sidebar").classList.toggle("active");
      document.querySelector(".dashboard-main").classList.toggle("active");
    });
    sidebarToggle.dataset.bound = 'true';
  }

  // Mobile Toggle
  const sidebarMobileToggle = document.querySelector(".sidebar-mobile-toggle");
  if (sidebarMobileToggle && !sidebarMobileToggle.dataset.bound) {
    sidebarMobileToggle.addEventListener("click", function () {
      document.querySelector(".sidebar").classList.add("sidebar-open");
      document.body.classList.add("overlay-active");
    });
    sidebarMobileToggle.dataset.bound = 'true';
  }

  // Close sidebar
  const sidebarColseBtn = document.querySelector(".sidebar-close-btn");
  if (sidebarColseBtn && !sidebarColseBtn.dataset.bound) {
    sidebarColseBtn.addEventListener("click", function () {
      document.querySelector(".sidebar").classList.remove("sidebar-open");
      document.body.classList.remove("overlay-active");
    });
    sidebarColseBtn.dataset.bound = 'true';
  }

  // Active Page Highlighting - This MUST run every navigation
  var nk = window.location.href;
  var links = document.querySelectorAll("ul#sidebar-menu a");

  links.forEach(function (link) {
    // Reset classes first
    link.classList.remove('active-page');
    link.parentElement.classList.remove('active-page');

    if (link.href === nk) {
      link.classList.add("active-page");
      var parent = link.parentElement;
      parent.classList.add("active-page");

      while (parent && parent.tagName !== "BODY") {
        if (parent.tagName === "LI") {
          parent.classList.add("show");
          parent.classList.add("open");
          // Ensure parent submenu is visible
          const submenu = parent.querySelector('.sidebar-submenu');
          if (submenu) submenu.style.display = 'block';
        }
        parent = parent.parentElement;
      }
    }
  });
}

function runThemeLogic() {
  // Theme toggle logic - largely static but re-checking won't hurt
  // ... (restored theme logic) ...
  var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
  var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
  var themeToggleBtn = document.getElementById('theme-toggle');

  if (themeToggleBtn && !themeToggleBtn.dataset.bound) {
    themeToggleBtn.addEventListener('click', function () {
      // toggle icons
      if (themeToggleDarkIcon) themeToggleDarkIcon.classList.toggle('hidden');
      if (themeToggleLightIcon) themeToggleLightIcon.classList.toggle('hidden');

      // toggle theme
      if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
          document.documentElement.classList.add('dark');
          localStorage.setItem('color-theme', 'dark');
        } else {
          document.documentElement.classList.remove('dark');
          localStorage.setItem('color-theme', 'light');
        }
      } else {
        if (document.documentElement.classList.contains('dark')) {
          document.documentElement.classList.remove('dark');
          localStorage.setItem('color-theme', 'light');
        } else {
          document.documentElement.classList.add('dark');
          localStorage.setItem('color-theme', 'dark');
        }
      }
    });
    themeToggleBtn.dataset.bound = 'true';
  }

  // Initial icon state
  if (themeToggleDarkIcon || themeToggleLightIcon) {
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      if (themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
      if (themeToggleDarkIcon) themeToggleDarkIcon.classList.add('hidden');
    } else {
      if (themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
      if (themeToggleLightIcon) themeToggleLightIcon.classList.add('hidden');
    }
  }
}

// Initialize on Load and Navigation
document.addEventListener('DOMContentLoaded', initApp);
document.addEventListener('livewire:navigated', initApp);