<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /*
     * Роли англ
     */
    const ROLE_ADMIN_EN = 'Administrator';
    const ROLE_INFRASTRUCTURE_OWNER_EN = 'Infrastructure owner';
    const ROLE_ICT_OPERATOR_OR_PROVIDER_EN = 'ICT operator or provider';
    const ROLE_CONTRIBUTOR_EN = 'Contributor';

    /*
     * Роли рус
     */
    const ROLE_ADMIN_RU = 'Администратор';
    const ROLE_INFRASTRUCTURE_OWNER_RU = 'Владелец дорожно-транспортной или энергетической инфраструктуры';
    const ROLE_ICT_OPERATOR_OR_PROVIDER_RU = 'Владелец инфраструктуры ИКТ';
    const ROLE_CONTRIBUTOR_RU = 'Участник';

    /*
     * Массив всех ролей англ
     */
    const ROLES_EN = [
        self::ROLE_ADMIN_EN,
        self::ROLE_INFRASTRUCTURE_OWNER_EN,
        self::ROLE_ICT_OPERATOR_OR_PROVIDER_EN,
        self::ROLE_CONTRIBUTOR_EN
    ];

    /*
     * Массив всех ролей рус
     */
    const ROLES_RU = [
        self::ROLE_ADMIN_RU,
        self::ROLE_INFRASTRUCTURE_OWNER_RU,
        self::ROLE_ICT_OPERATOR_OR_PROVIDER_RU,
        self::ROLE_CONTRIBUTOR_RU
    ];

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
