<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AdminRepository
{
    public function findByLogin(string $login): ?Model {
        $admin = Admin::query()->where('login', $login)->first();

        if (!$admin) {
            Log::info('Попытка войти в несуществующий аккаунт', [
                'login' => $login,
            ]);
        }

        return $admin;
    }
}
