<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class Users extends Component
{
    use WithPagination;

    // public $departmentsList; // Removed in favor of computed property
    public $designationsList = [];

    public $search = '';

    public $perPage = 10;
    public $viewMode = 'list';

    // Form properties
    public $userId;
    public $name;
    public $email;
    public $password; // Only for creation/update if needed
    public $department_id;
    public $designation_id;
    public $status = 'Active';
    public $role = 'User';
    public $image;
    public $currentImage;

    // UI State
    public $isOffcanvasOpen = false;
    public $isDeleteModalOpen = false;
    public $userToDeleteId;

    protected $queryString = ['search'];

    #[Computed]
    public function departmentsList()
    {
        return Department::orderBy('name')->get();
    }

    public function updatedDepartmentId($value)
    {
        // Reset designation
        $this->designation_id = '';

        if (!empty($value)) {
            $this->designationsList = Designation::where('department_id', $value)->orderBy('name')->get();
        } else {
            $this->designationsList = [];
        }
    }

    public function render()
    {
        // Initial load for edit mode or if department is selected
        if ($this->department_id && empty($this->designationsList)) {
            $this->designationsList = Designation::where('department_id', $this->department_id)->orderBy('name')->get();
        }

        $users = User::query()
            ->with(['department', 'designation'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.users', [
            'users' => $users
        ])->extends('layouts.app')->section('content');
    }

    public function create()
    {
        $this->resetInput();
        $this->isOffcanvasOpen = true;
    }

    public function edit($id)
    {
        $this->resetInput();
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->department_id = $user->department_id;
        $this->designation_id = $user->designation_id;

        $this->status = $user->status;
        $this->role = $user->role;

        $this->isOffcanvasOpen = true;
    }

    public function save()
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->userId)],
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'status' => ['required', Rule::enum(UserStatus::class)],
            'role' => ['required', Rule::enum(UserRole::class)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
        ];

        if (!$this->userId) {
            $validationRules['password'] = 'required|min:6';
        }

        $this->validate($validationRules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'department_id' => $this->department_id,
            'designation_id' => $this->designation_id,
            'status' => $this->status,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        // Handle image upload
        if ($this->image instanceof UploadedFile) {
            $user = $this->userId ? User::find($this->userId) : new User();
            
            // Delete old image if exists
            if ($user->image) {
                $user->deleteImage();
            }
            
            // Upload new image
            $data['image'] = $user->uploadImage($this->image);
        }

        if ($this->userId) {
            User::where('id', $this->userId)->update($data);
        } else {
            User::create($data);
        }

        $this->closeOffcanvas();
        $this->resetInput();
    }

    public function confirmDelete($id)
    {
        $this->userToDeleteId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        try {
            if ($this->userToDeleteId) {
                $user = User::findOrFail($this->userToDeleteId);
                
                // Delete user image if exists
                if ($user->image) {
                    $user->deleteImage();
                }
                
                User::destroy($this->userToDeleteId);
                session()->flash('success', 'User deleted successfully');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete user: ' . $e->getMessage());
            Log::error('User deletion failed: ' . $e->getMessage());
        }
        
        $this->closeDeleteModal();
    }

    public function closeOffcanvas()
    {
        $this->isOffcanvasOpen = false;
        $this->resetInput();
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->userToDeleteId = null;
    }

    private function resetInput()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->department_id = '';
        $this->designation_id = '';
        $this->status = 'Active';
        $this->role = 'User';
        $this->image = null;
        $this->currentImage = null;
        $this->resetErrorBag();
    }

    public function exportPdf()
    {
        try {
            // Use chunking to avoid memory exhaustion with large datasets
            $users = collect();
            User::chunk(100, function ($chunk) use ($users) {
                $chunk->load(['department', 'designation']);
                $users->push(...$chunk);
            });
            
            $pdf = Pdf::loadView('exports.users-pdf', ['users' => $users]);
            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, 'users.pdf');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to export PDF: ' . $e->getMessage());
            return redirect()->route('users');
        }
    }

    public function exportCsv()
    {
        try {
            return response()->streamDownload(function () {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['ID', 'Name', 'Email', 'Department', 'Designation', 'Status', 'Role', 'Created At']);

                User::chunk(100, function ($users) use ($handle) {
                    foreach ($users as $user) {
                        fputcsv($handle, [
                            $user->id,
                            $user->name,
                            $user->email,
                            optional($user->department)->name,
                            optional($user->designation)->name,
                            $user->status,
                            $user->role,
                            $user->created_at,
                        ]);
                    }
                });

                fclose($handle);
            }, 'users.csv');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to export CSV: ' . $e->getMessage());
            return redirect()->route('users');
        }
    }
}
