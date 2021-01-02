<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Класс пользователей
 *
 * @property int $id
 * @property string $name               - Имя
 * @property string $surname            - Фамилия
 * @property string $email
 * @property string $password
 * @property Carbon $last_activity_at   - Метка последней активности
 * @property boolean $active            - Статус
 * @property Article[] $articles        - Статьи пользователя
 *
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'role_id',
        'email',
        'photo_path',
        'phone',
        'organization',
        'summary'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute() : string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Путь до фото профиля
     *
     * @return string
     */
    public function getPhotoAttribute() : string
    {
        return 'storage/' . $this->photo_path;
    }

    /**
     * Статьи пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Роль пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
