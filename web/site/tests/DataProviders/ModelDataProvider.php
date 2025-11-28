<?php
declare(strict_types=1);
namespace Tests\DataProviders;

use App\Models\Admin;
use App\Models\Link;
use App\Models\User;
use Tests\Health\ModelTest;

/**
 * Провайдер данных для теста @see ModelTest
 */
final class ModelDataProvider
{
    /**
     * Возвращает модели для метода @see ModelTest::testModelFactory()
     */
    public static function getModels(): array
    {
        return [
            [new User()],
            [new Link()],
            [new Admin()],
        ];
    }
}
