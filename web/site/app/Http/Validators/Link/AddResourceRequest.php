<?php
declare(strict_types=1);
namespace App\Http\Validators\Link;

use Illuminate\Foundation\Http\FormRequest;

class AddResourceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'toId' => 'required|integer',
        ];
    }
}
