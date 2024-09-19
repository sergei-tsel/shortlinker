<?php
declare(strict_types=1);
namespace App\Models;

use App\Enums\LinkResourceType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Сущность "Добавленная ссылка"
 *
 * @property integer          $id
 * @property integer          $userId
 * @property LinkResourceType $resourceType
 * @property array|null       $resources
 * @property string           $shortUrl
 * @property string           $longUrl
 * @property Carbon           $created_at
 * @property Carbon           $updated_at
 * @property Carbon           $deleted_at
 * @property User             $user
 */
class Link extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'links';

    protected $casts = [
        'resources'  => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getResourceTypeAttribute(int $value): LinkResourceType
    {
        return LinkResourceType::from($value);
    }

    public function setResourceTypeAttribute(LinkResourceType $resourceType): void
    {
        $this->attributes['resourceType'] = $resourceType->value;
    }

    public function scopeOfResourceType(Builder $builder, LinkResourceType $resourceType): Builder
    {
        return $builder->where('resourceType', $resourceType->value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
