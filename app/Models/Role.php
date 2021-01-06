<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
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
class Role extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /*
     * Роли
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_ADMIN_ID = 1;
    const ROLE_ROADS_OWNER = 'roads';
    const ROLE_ICT_OWNER = 'ict';
    const ROLE_CONTRIBUTOR = 'contributor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug'
    ];

    /**
     * Поле, которое должно быть переведено
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * Все роли на выбор кроме администратора
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithoutAdmin(Builder $query) : Builder
    {
        return $query->where('slug', '!=', Role::ROLE_ADMIN)->oldest('id');
    }
}
