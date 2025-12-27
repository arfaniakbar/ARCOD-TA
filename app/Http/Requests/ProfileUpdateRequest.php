<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // Rule untuk Nama: Wajib diisi, string, maksimal 255 karakter
            'name' => ['required', 'string', 'max:255'],
            
            // Rule untuk Username:
            // 1. Wajib diisi (required), 
            // 2. String, 
            // 3. Maksimal 255 karakter, 
            // 4. Harus Unik di tabel users, tapi ABAIKAN ID pengguna yang sedang login.
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            
            // Rule untuk Email:
            // 1. Wajib diisi (required), 
            // 2. Format email, 
            // 3. Maksimal 255 karakter, 
            // 4. Harus Unik di tabel users, tapi ABAIKAN ID pengguna yang sedang login.
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}