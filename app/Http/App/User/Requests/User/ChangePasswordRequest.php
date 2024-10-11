<?php
declare(strict_types=1);
namespace App\Http\App\User\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->request->get('newpassword') !== $this->request->get('newpassword2')) {
            $this->failed('Пароли не совпадают');
        }

        return [
            'password'     => 'required|string|min:6',
            'newpassword'  => 'required|string|min:6',
            'newpassword2' => 'required|string|min:6',
        ];
    }
}
