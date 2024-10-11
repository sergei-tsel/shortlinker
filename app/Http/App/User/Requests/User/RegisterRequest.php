<?php
declare(strict_types=1);
namespace App\Http\App\User\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => 'required|string',
            'nickname' => 'required|unique|string',
            'password' => 'required|string|min:6',
            'remember' => 'sometimes|string',
        ];
    }
}
