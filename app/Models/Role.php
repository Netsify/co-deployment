<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс ролей
 *
 * @property int $id
 * @property string $name           - Роль
 * @property string $slug           - Уникальный строковый идентификатор
 *
 * Class Role
 * @package App\Models
 */
class Role extends Model
{
    use HasFactory;

    /*
     * Роли
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_INFRASTRUCTURE_OWNER = 'owner';
    const ROLE_ICT_OPERATOR_OR_PROVIDER = 'ict';
    const ROLE_CONTRIBUTOR = 'contributor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];
}
