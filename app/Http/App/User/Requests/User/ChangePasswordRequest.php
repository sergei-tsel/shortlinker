<?php
declare(strict_types=1);
namespace App\Http\App\User\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|string|min:6',
        ];
    }
}
