@section('title', __('Users List'))
@section('subTitle', __('Users List'))

<div x-init="
    if (window.innerWidth < 768) {
        $wire.set('viewMode', 'grid');
    }
">
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card h-full p-0 rounded-xl border-0 overflow-hidden">
                <div
                    class="card-header border-b border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 py-4 px-6 flex items-center flex-wrap gap-3 justify-between">
                    <div class="flex items-center flex-wrap gap-3">
                        <div class="flex items-center gap-3">
                            <span class="text-base font-medium text-secondary-light mb-0">{{ __('Show') }}</span>
                            <select wire:model.live="perPage"
                                class="form-select form-select-sm w-auto dark:bg-neutral-600 dark:text-white border-neutral-200 dark:border-neutral-500 rounded-lg">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <form class="navbar-search relative">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="bg-white dark:bg-neutral-700 h-10 w-auto pl-10 pr-3 rounded-lg border border-neutral-200 dark:border-neutral-500"
                                placeholder="{{ __('Search') }}">
                            <iconify-icon icon="ion:search-outline"
                                class="icon absolute left-3 top-1/2 -translate-y-1/2 text-lg"></iconify-icon>
                        </form>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button wire:click="exportCsv"
                            class="btn border border-neutral-200 text-neutral-500 hover:bg-neutral-200 text-dark rounded-lg px-5 py-[11px] text-sm">
                            <iconify-icon icon="fa-solid:file-csv" class="icon text-xl line-height-1"></iconify-icon>
                            CSV
                        </button>
                        <button wire:click="exportPdf"
                            class="btn border border-neutral-200 text-neutral-500 hover:bg-neutral-200 text-dark rounded-lg px-5 py-[11px] text-sm">
                            <iconify-icon icon="fa-solid:file-pdf" class="icon text-xl line-height-1"></iconify-icon>
                            PDF
                        </button>
                        <button wire:click="$set('viewMode', 'list')"
                            class="btn btn-sm {{ $viewMode == 'list' ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-neutral-600' }} rounded-lg flex items-center justify-center p-3 text-sm">
                            <iconify-icon icon="heroicons:list-bullet" class="text-xl"></iconify-icon>
                        </button>
                        <button wire:click="$set('viewMode', 'grid')"
                            class="btn btn-sm {{ $viewMode == 'grid' ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-neutral-600' }} rounded-lg flex items-center justify-center p-3 text-sm">
                            <iconify-icon icon="heroicons:squares-2x2" class="text-xl"></iconify-icon>
                        </button>
                        <button wire:click="create"
                            class="btn bg-info-600 hover:bg-info-700 text-white rounded-lg px-5 py-[11px] text-sm">
                            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                            {{ __('New User') }}
                        </button>
                    </div>
                </div>
                <div class="card-body p-6">
                    @if ($viewMode == 'list')
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table sm-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Email') }}</th>
                                        <th scope="col">{{ __('Department') }}</th>
                                        <th scope="col">{{ __('Designation') }}</th>
                                        <th scope="col">{{ __('Role') }}</th>
                                        <th scope="col" class="text-center">{{ __('Status') }}</th>
                                        <th scope="col" class="text-center">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>
                                                <div class="flex items-center">
                                                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/images/user.png') }}"
                                                        alt=""
                                                        class="w-10 h-10 rounded-full shrink-0 me-2 object-cover overflow-hidden">
                                                    <div class="grow">
                                                        <span
                                                            class="text-base mb-0 font-normal text-secondary-light">{{ $user->name }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span
                                                    class="text-base mb-0 font-normal text-secondary-light">{{ $user->email }}</span>
                                            </td>
                                            <td>{{ $user->department ?? '-' }}</td>
                                            <td>{{ $user->designation ?? '-' }}</td>
                                            <td>{{ $user->role ?? '-' }}</td>
                                            <td class="text-center">
                                                @if($user->status == 'Active')
                                                    <span
                                                        class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 border border-success-600 px-6 py-1.5 rounded font-medium text-sm">{{ __('Active') }}</span>
                                                @else
                                                    <span
                                                        class="bg-neutral-200 dark:bg-neutral-600 text-neutral-600 border border-neutral-400 px-6 py-1.5 rounded font-medium text-sm">{{ __('Inactive') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="flex items-center gap-3 justify-center">
                                                    <button wire:click="edit({{ $user->id }})" type="button"
                                                        class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 bg-hover-success-200 font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                    </button>
                                                    <button wire:click="confirmDelete({{ $user->id }})" type="button"
                                                        class="bg-danger-100 dark:bg-danger-600/25 hover:bg-danger-200 text-danger-600 dark:text-danger-500 font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                        <iconify-icon icon="fluent:delete-24-regular"
                                                            class="menu-icon"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">{{ __('No users found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 3xl:grid-cols-4 gap-6">
                            @forelse ($users as $user)
                                <div class="user-grid-card">
                                    <div
                                        class="relative border border-neutral-200 dark:border-neutral-600 rounded-2xl overflow-hidden bg-white dark:bg-neutral-700">
                                        <!-- Background decoration -->
                                        <div class="h-[100px] bg-neutral-100 dark:bg-neutral-600 w-full object-cover"></div>

                                        <div class="dropdown absolute top-0 end-0 me-4 mt-4" x-data="{ open: false }">
                                            <button @click="open = !open" @click.outside="open = false"
                                                class="bg-white/50 dark:bg-neutral-800/50 w-8 h-8 rounded-lg border border-neutral-200 dark:border-neutral-500 flex justify-center items-center text-neutral-600 dark:text-white"
                                                type="button">
                                                <iconify-icon icon="ri:more-2-fill"></iconify-icon>
                                            </button>

                                            <div x-show="open" style="display: none;"
                                                class="z-10 absolute right-0 mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-neutral-100 dark:border-neutral-600 w-44 dark:bg-gray-700">
                                                <ul class="p-2 text-sm text-gray-700 dark:text-gray-200">
                                                    <li>
                                                        <button wire:click="edit({{ $user->id }})" @click="open = false"
                                                            class="w-full text-start px-4 py-2.5 hover:bg-gray-100 dark:hover:bg-gray-600 rounded dark:hover:text-white flex items-center gap-2">
                                                            {{ __('Edit') }}
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button wire:click="confirmDelete({{ $user->id }})"
                                                            @click="open = false"
                                                            class="w-full text-start px-4 py-2.5 hover:bg-danger-100 dark:hover:bg-danger-600/25 rounded hover:text-danger-500 dark:hover:text-danger-600 flex items-center gap-2">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="pe-6 pb-4 ps-6 text-center mt-[-50px]">
                                            @if ($user->image)
                                                <img src="{{ asset('storage/' . $user->image) }}" alt=""
                                                    class="w-[100px] h-[100px] mx-auto rounded-full border-[2px] border-white dark:border-neutral-700 object-cover shadow-sm">
                                            @else
                                                <div
                                                    class="w-[100px] h-[100px] mx-auto rounded-full border-[2px] border-white dark:border-neutral-700 bg-primary-100 flex items-center justify-center text-primary-600 text-3xl font-bold shadow-sm">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <h6 class="text-lg mb-0 mt-3 font-semibold text-neutral-900 dark:text-white">
                                                {{ $user->name }}
                                            </h6>
                                            <span
                                                class="text-secondary-light dark:text-neutral-400 text-sm mb-4 block">{{ $user->email }}</span>

                                            <div
                                                class="relative bg-primary-50 dark:bg-primary-900/20 rounded-lg p-3 flex items-center gap-4 border border-primary-100 dark:border-primary-800/30">
                                                <div
                                                    class="text-center w-1/2 border-e border-neutral-200 dark:border-neutral-600/50">
                                                    <h6
                                                        class="text-base mb-0 font-medium text-neutral-700 dark:text-neutral-200">
                                                        {{ $user->department ?? '-' }}
                                                    </h6>
                                                    <span
                                                        class="text-secondary-light dark:text-neutral-500 text-xs">{{ __('Department') }}</span>
                                                </div>
                                                <div class="text-center w-1/2">
                                                    <h6
                                                        class="text-base mb-0 font-medium text-neutral-700 dark:text-neutral-200">
                                                        {{ $user->designation ?? '-' }}
                                                    </h6>
                                                    <span
                                                        class="text-secondary-light dark:text-neutral-500 text-xs">{{ __('Designation') }}</span>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                @if ($user->status == 'Active')
                                                    <span
                                                        class="badge bg-success-subtle text-success-600 px-3 py-1 rounded-full text-sm font-medium border border-success-200 dark:border-success-800/30">{{ __('Active') }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger-subtle text-danger-600 px-3 py-1 rounded-full text-sm font-medium border border-danger-200 dark:border-danger-800/30">{{ __('Inactive') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-12 text-center py-10 text-neutral-500">
                                    {{ __('No users found.') }}
                                </div>
                            @endforelse
                        </div>
                    @endif

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas (Drawer) -->
    <div x-data="{ open: @entangle('isOffcanvasOpen') }" x-show="open"
        class="fixed inset-0 z-50 flex justify-end bg-black/50" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;">

        <div class="w-[90vw] sm:w-96 bg-white dark:bg-neutral-800 h-full shadow-xl overflow-y-auto"
            @click.away="open = false; $wire.closeOffcanvas()" x-show="open"
            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

            <div class="p-6 border-b border-neutral-200 dark:border-neutral-600 flex justify-between items-center">
                <h5 class="text-lg font-semibold">{{ $userId ? __('Edit User') : __('Add New User') }}</h5>
                <button @click="open = false; $wire.closeOffcanvas()" type="button"
                    class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-300 dark:hover:text-white">
                    <iconify-icon icon="radix-icons:cross-2" class="text-xl"></iconify-icon>
                </button>
            </div>

            <div class="p-6">
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">{{ __('Name') }}</label>
                        <input type="text" wire:model="name"
                            class="form-control w-full rounded-lg border-neutral-200 dark:bg-neutral-700 dark:border-neutral-600">
                        @error('name') <span class="text-danger-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">{{ __('Email') }}</label>
                        <input type="email" wire:model="email"
                            class="form-control w-full rounded-lg border-neutral-200 dark:bg-neutral-700 dark:border-neutral-600">
                        @error('email') <span class="text-danger-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if(!$userId)
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Password') }}</label>
                            <input type="password" wire:model="password"
                                class="form-control w-full rounded-lg border-neutral-200 dark:bg-neutral-700 dark:border-neutral-600">
                            @error('password') <span class="text-danger-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">{{ __('Department') }}</label>
                        <select wire:model.live="department"
                            class="form-select w-full rounded-lg border-neutral-200 dark:bg-neutral-700 dark:border-neutral-600">
                            <option value="">{{ __('Select Department') }}</option>
                            @foreach($departmentsList as $dept)
                                <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department') <span class="text-danger-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">{{ __('Designation') }}</label>
                        <select wire:model="designation"
                            class="form-select w-full rounded-lg border-neutral-200 dark:bg-neutral-700 dark:border-neutral-600">
                            <option value="">{{ __('Select Designation') }}</option>
                            @foreach($designationsList as $desig)
                                <option value="{{ $desig->name }}">{{ $desig->name }}</option>
                            @endforeach
                        </select>
                        @error('designation') <span class="text-danger-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">{{ __('Role') }}</label>
                        <select wire:model="role"
                            class="form-select w-full rounded-lg border-neutral-200 dark:bg-neutral-700 dark:border-neutral-600">
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                        @error('role') <span class="text-danger-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">{{ __('Status') }}</label>
                        <select wire:model="status"
                            class="form-select w-full rounded-lg border-neutral-200 dark:bg-neutral-700 dark:border-neutral-600">
                            <option value="Active">{{ __('Active') }}</option>
                            <option value="Inactive">{{ __('Inactive') }}</option>
                        </select>
                        @error('status') <span class="text-danger-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" @click="open = false; $wire.closeOffcanvas()"
                            class="btn btn-secondary-500 px-4 py-2 rounded-lg">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-lg">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-data="{ open: @entangle('isDeleteModalOpen') }" x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">

        <div class="relative p-4 w-full max-w-2xl max-h-full" @click.away="open = false; $wire.closeDeleteModal()">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between px-6 py-3 border-b rounded-t dark:border-gray-600">
                    <h5 class="modal-title text-xl font-semibold">{{ __('Confirm Delete') }}</h5>
                    <button @click="open = false; $wire.closeDeleteModal()" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex flex-col gap-2 p-6 text-center">
                    <iconify-icon icon="fluent:delete-24-regular"
                        class="text-5xl text-danger-600 mb-4 mx-auto"></iconify-icon>
                    <h3 class="text-lg font-semibold mb-2">{{ __('Are you sure?') }}</h3>
                    <p class="text-neutral-500 mb-6">{{ __("You won't be able to revert this!") }}</p>

                    <div class="flex justify-center gap-3">
                        <button @click="open = false; $wire.closeDeleteModal()"
                            class="btn btn-secondary-500 px-4 py-2 rounded-lg">{{ __('Cancel') }}</button>
                        <button wire:click="delete"
                            class="btn btn-danger-600 px-4 py-2 rounded-lg">{{ __('Yes, delete it!') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>