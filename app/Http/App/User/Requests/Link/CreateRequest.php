<?php
declare(strict_types=1);
namespace App\Http\App\User\Requests\Link;

use App\Enums\LinkResourceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'shortLink'    => 'required|string|max:16',
            'longLink'     => 'required|string|max:4096',
            'resourceType' => [
                'required',
                'int',
                new In(LinkResourceType::values()),
            ],
        ];
    }
}
