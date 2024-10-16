<?php
declare(strict_types=1);
namespace App\Http\App\User\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nickname' => 'required|string',
            'password' => 'required|string|min:6',
            'remember' => 'sometimes|string',
        ];
    }
}
