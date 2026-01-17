<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Users extends Component
{
    use WithPagination;

    public $departmentsList;
    public $designationsList = [];

    public $search = '';
    public $perPage = 10;
    public $viewMode = 'list';

    // Form properties
    public $userId;
    public $name;
    public $email;
    public $password; // Only for creation/update if needed
    public $department;
    public $designation;
    public $status = 'Active';
    public $role = 'User';

    // UI State
    public $isOffcanvasOpen = false;
    public $isDeleteModalOpen = false;
    public $userToDeleteId;

    protected $queryString = ['search'];

    public function updatedDepartment($value)
    {
        // Reset designation
        $this->designation = '';

        if (!empty($value)) {
            // Find the department ID from the name since previously we stored name.
            // Wait, previous request was to store Name. But now designations link to Department ID.
            // The relationship is DBFK but Users table stores string 'department' and 'designation'.
            // To filter Designations effectively, we need the Department ID.
            // Let's assume we fetch Department ID where name matches $value.
            $dept = Department::where('name', $value)->first();
            if ($dept) {
                $this->designationsList = Designation::where('department_id', $dept->id)->orderBy('name')->get();
            } else {
                $this->designationsList = [];
            }
        } else {
            $this->designationsList = [];
        }
    }

    public function render()
    {
        $this->departmentsList = Department::orderBy('name')->get();
        // Initial load for edit mode or if department is selected
        if ($this->department && empty($this->designationsList)) {
            $dept = Department::where('name', $this->department)->first();
            if ($dept) {
                $this->designationsList = Designation::where('department_id', $dept->id)->orderBy('name')->get();
            }
        }

        $users = User::query()
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
        $this->department = $user->department;
        $this->designation = $user->designation;

        $this->status = $user->status;
        $this->role = $user->role;

        $this->isOffcanvasOpen = true;
    }

    public function save()
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->userId)],
            'department' => 'nullable|string',
            'designation' => 'nullable|string',

            'status' => 'required|in:Active,Inactive',
            'role' => 'required|in:Admin,User',
        ];

        if (!$this->userId) {
            $validationRules['password'] = 'required|min:6';
        }

        $this->validate($validationRules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'department' => $this->department,
            'designation' => $this->designation,

            'status' => $this->status,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
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
        if ($this->userToDeleteId) {
            User::destroy($this->userToDeleteId);
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
        $this->department = '';
        $this->designation = '';

        $this->status = 'Active';
        $this->role = 'User';
        $this->resetErrorBag();
    }

    public function exportPdf()
    {
        $users = User::all();
        $pdf = Pdf::loadView('exports.users-pdf', ['users' => $users]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'users.pdf');
    }

    public function exportCsv()
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Department', 'Designation', 'Status', 'Role', 'Created At']);

            User::chunk(100, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->department,
                        $user->designation,

                        $user->status,
                        $user->role,
                        $user->created_at,
                    ]);
                }
            });

            fclose($handle);
        }, 'users.csv');
    }
}
