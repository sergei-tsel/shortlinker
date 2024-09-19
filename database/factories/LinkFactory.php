<?php
declare(strict_types=1);
namespace Database\Factories;

use App\Enums\LinkResourceType;
use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method Link create($attributes = [], ?Model $parent = null)
 */
class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition(): array
    {
        return [
            'userId'        => function () {
                return User::factory()->create()->id;
            },
            'resourceType'  => fake()->randomElement(LinkResourceType::cases()),
            'shortUrl'      => Str::random(10),
            'longUrl'       => fake()->url,
        ];
    }
}
