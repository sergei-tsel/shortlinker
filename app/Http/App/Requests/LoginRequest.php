<?php
declare(strict_types=1);
namespace App\Http\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login'    => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }
}
