<?php
declare(strict_types=1);
namespace App\Http\App\User\Requests\Link;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'shortLink' => 'required|string|max:16',
            'longLink'  => 'required|string|max:4096',
        ];
    }
}
