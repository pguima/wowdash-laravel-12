<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => $this->isMethod('POST') 
                ? ['required', 'string', 'min:8', 'confirmed'] 
                : ['nullable', 'string', 'min:8', 'confirmed'],
            'image' => [
                'nullable',
                File::image()
                    ->max(2 * 1024) // 2MB max
                    ->types(['jpeg', 'png', 'jpg', 'gif', 'webp'])
            ],
            'department_id' => ['nullable', 'exists:departments,id'],
            'designation_id' => ['nullable', 'exists:designations,id'],
            'status' => ['required', Rule::enum(\App\Enums\UserStatus::class)],
            'role' => ['required', Rule::enum(\App\Enums\UserRole::class)],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'The image may not be greater than 2MB.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
            'department_id.exists' => 'The selected department is invalid.',
            'designation_id.exists' => 'The selected designation is invalid.',
            'status.required' => 'The status field is required.',
            'status.enum' => 'The selected status is invalid.',
            'role.required' => 'The role field is required.',
            'role.enum' => 'The selected role is invalid.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'department_id' => 'department',
            'designation_id' => 'designation',
        ];
    }
}
