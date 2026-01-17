<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Settings extends Component
{
    use WithFileUploads;

    // Logos
    public $logo_light;
    public $logo_dark;
    public $logo_icon_light;
    public $logo_icon_dark;
    public $favicon;
    public $currentLogoLight;
    public $currentLogoDark;
    public $currentLogoIconLight;
    public $currentLogoIconDark;
    public $currentFavicon;

    // Auth Pages
    public $auth_bg_light;
    public $auth_bg_dark;
    public $forgot_bg_light;
    public $forgot_bg_dark;
    public $currentAuthBgLight;
    public $currentAuthBgDark;
    public $currentForgotBgLight;
    public $currentForgotBgDark;

    // Departments
    public $departments;
    public $newDepartment;

    // Designations
    public $designations;
    public $newDesignation;
    public $selectedDepartmentId;

    public $activeTab = 'general';

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->currentLogoLight = Setting::where('key', 'logo_light')->value('value');
        $this->currentLogoDark = Setting::where('key', 'logo_dark')->value('value');
        $this->currentLogoIconLight = Setting::where('key', 'logo_icon_light')->value('value');
        $this->currentLogoIconDark = Setting::where('key', 'logo_icon_dark')->value('value');
        $this->currentFavicon = Setting::where('key', 'favicon')->value('value');

        $this->currentAuthBgLight = Setting::where('key', 'auth_bg_light')->value('value');
        $this->currentAuthBgDark = Setting::where('key', 'auth_bg_dark')->value('value');
        $this->currentForgotBgLight = Setting::where('key', 'forgot_bg_light')->value('value');
        $this->currentForgotBgDark = Setting::where('key', 'forgot_bg_dark')->value('value');

        $this->departments = Department::orderBy('name')->get();
        $this->designations = Designation::orderBy('name')->get();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function saveLogos()
    {
        $this->validate([
            'logo_light' => 'nullable|image|max:1024',
            'logo_dark' => 'nullable|image|max:1024',
            'logo_icon_light' => 'nullable|image|max:1024',
            'logo_icon_dark' => 'nullable|image|max:1024',
            'favicon' => 'nullable|image|max:1024',
            'auth_bg_light' => 'nullable|image|max:2048',
            'auth_bg_dark' => 'nullable|image|max:2048',
            'forgot_bg_light' => 'nullable|image|max:2048',
            'forgot_bg_dark' => 'nullable|image|max:2048',
        ]);

        if ($this->logo_light) {
            $path = $this->logo_light->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'logo_light'], ['value' => $path]);
        }

        if ($this->logo_dark) {
            $path = $this->logo_dark->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'logo_dark'], ['value' => $path]);
        }

        if ($this->logo_icon_light) {
            $path = $this->logo_icon_light->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'logo_icon_light'], ['value' => $path]);
        }

        if ($this->logo_icon_dark) {
            $path = $this->logo_icon_dark->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'logo_icon_dark'], ['value' => $path]);
        }

        if ($this->favicon) {
            $path = $this->favicon->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'favicon'], ['value' => $path]);
        }

        if ($this->auth_bg_light) {
            $path = $this->auth_bg_light->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'auth_bg_light'], ['value' => $path]);
        }

        if ($this->auth_bg_dark) {
            $path = $this->auth_bg_dark->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'auth_bg_dark'], ['value' => $path]);
        }

        if ($this->forgot_bg_light) {
            $path = $this->forgot_bg_light->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'forgot_bg_light'], ['value' => $path]);
        }

        if ($this->forgot_bg_dark) {
            $path = $this->forgot_bg_dark->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'forgot_bg_dark'], ['value' => $path]);
        }

        $this->logo_light = null;
        $this->logo_dark = null;
        $this->logo_icon_light = null;
        $this->logo_icon_dark = null;
        $this->favicon = null;
        $this->auth_bg_light = null;
        $this->auth_bg_dark = null;
        $this->forgot_bg_light = null;
        $this->forgot_bg_dark = null;

        $this->refreshData();
        session()->flash('message', 'Settings updated successfully.');
    }

    public function addDepartment()
    {
        $this->validate(['newDepartment' => 'required|string|max:255|unique:departments,name']);

        Department::create(['name' => $this->newDepartment]);
        $this->newDepartment = '';
        $this->refreshData();
    }

    public function removeDepartment($id)
    {
        Department::destroy($id);
        $this->refreshData();
    }

    public function addDesignation()
    {
        $this->validate([
            'newDesignation' => 'required|string|max:255|unique:designations,name',
            'selectedDepartmentId' => 'required|exists:departments,id',
        ]);

        Designation::create([
            'name' => $this->newDesignation,
            'department_id' => $this->selectedDepartmentId,
        ]);

        $this->newDesignation = '';
        $this->selectedDepartmentId = '';
        $this->refreshData();
    }

    public function removeDesignation($id)
    {
        Designation::destroy($id);
        $this->refreshData();
    }

    public function render()
    {
        return view('livewire.settings')->extends('layouts.app')->section('content');
    }
}
