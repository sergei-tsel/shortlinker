<?php
declare(strict_types=1);
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Сущность "Админ"
 *
 * @property integer    $id
 * @property string     $login
 * @property string     $password
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 */
class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'login',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password'   => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
