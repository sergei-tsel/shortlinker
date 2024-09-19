<?php
declare(strict_types=1);
namespace App\Http\Resources;

use App\Enums\LinkResourceType;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @see Link
 */
class LinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'userId'     => $this->userId,
            $this->mergeWhen($this->resourceType === LinkResourceType::TO_URL, [
                'folder' => $this->resource['folder'],
                'groups' => $this->resource['groups'],
            ]),
            $this->mergeWhen($this->resourceType === LinkResourceType::TO_FOLDER, [
                'folder' => $this->resource['folder'],
                'urls'   => $this->resource['urls'],
            ]),
            'urls'       => $this->when($this->resourceType === LinkResourceType::TO_GROUP, $this->resource['urls']),
            'shortUrl'   => $this->shorturl,
            'longUrl'    => $this->longUrl,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
