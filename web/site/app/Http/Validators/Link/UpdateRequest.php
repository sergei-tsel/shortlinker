<?php
declare(strict_types=1);
namespace App\Http\Validators\Link;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'shortUrl' => 'required|string|max:16',
            'longUrl'  => 'required|string|url|max:4096',
        ];
    }
}
