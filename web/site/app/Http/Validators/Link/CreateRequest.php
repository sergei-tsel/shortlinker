<?php
declare(strict_types=1);
namespace App\Http\Validators\Link;

use App\Enums\LinkResourceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'shortUrl'     => 'required|string|max:16',
            'longUrl'      => 'required|string|url|max:4096',
            'resourceType' => [
                'required',
                'int',
                new In(LinkResourceType::values()),
            ],
        ];
    }
}
