<?php
declare(strict_types=1);
namespace Tests\Health;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\DataProviders\ModelDataProvider;
use Tests\TestCase;

/**
 * Проверяет коректность созданных моделей
 */
class ModelTest extends TestCase
{
    #[DataProviderExternal(ModelDataProvider::class, 'getModels')]
    public function testModelFactory(Model $element): void
    {
        $model = $element::factory()->create();
        $this->assertInstanceOf($element::class, $model);
    }
}
