<?php
declare(strict_types=1);
namespace App\Http\Validators;

use Illuminate\Foundation\Http\FormRequest;

class PaginateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'numeric|nullable|sometimes|min:1',
        ];
    }
}
