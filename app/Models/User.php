<?php

namespace App\Models;

use App\Models\Facilities\Facility;
use App\Models\Facilities\Proposal;
use App\Models\Variables\Variable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Класс пользователей
 *
 * @property int $id
 * @property string $first_name         - Имя
 * @property string $last_name          - Фамилия
 * @property string $email              - Почта
 * @property Carbon $email_verified_at  - Дата подтверждения почты
 * @property string $phone              - Телефон пользователя
 * @property string $organization       - Организация пользователя
 * @property string $summary            - Дополнительная информация
 * @property string $photo_path         - Путь до фото профиля
 * @property string $password           - Пароль
 * @property Carbon $last_activity_at   - Метка последней активности
 * @property boolean $active            - Статус
 * @property boolean $verified          - Верификация
 * @property boolean $remember_token    - Токен запоминания при авторизации
 * @property Carbon $created_at         - Дата создания
 * @property Carbon $updated_at         - Дата обновления
 * @property Carbon $deleted_at         - Дата удаления
 * @property Article[] $articles        - Статьи пользователя
 * @property Role $role                 - Роль пользователя
 * @property Facility[] $facilities     - Объекты пользователя
 * @property File[] $facilitiesFiles    - Файлы всех объектов пользователя
 * @property Variable[] $variables      - Переменные которые вбил пользователь
 *
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Путь до фото профиля по умолчанию
     */
    const DEFAULT_PHOTO = 'photo/default.svg';

    /**
     * Путь до иконки подтверждено
     */
    const ICON_VERIFIED = 'icons/verified.jpg';

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
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Путь до иконки подтверждения
     *
     * @return string
     */
    public function getVerifiedUrlAttribute(): string
    {
        return Storage::url(self::ICON_VERIFIED);
    }

    /**
     * Хинт иконки подтверждения
     *
     * @return string
     */
    public function getVerifiedTitleAttribute(): string
    {
        return __('dictionary.verified_desc', ['fullName' => $this->full_name]);
    }

    /**
     * Путь до фото профиля
     *
     * @return string
     */
    public function getPhotoAttribute(): string
    {
        return $this->photo_path ? Storage::url($this->photo_path) : Storage::url(self::DEFAULT_PHOTO);
    }

    /**
     * Статьи пользователя
     *
     * @return HasMany
     */
    public function articles() : HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Роль пользователя
     *
     * @return BelongsTo
     */
    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Является ли пользователь админом
     *
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->role->slug == Role::ROLE_ADMIN;
    }

    /**
     * Является ли пользователь владельцем инфраструктуры или оператором ИКТ
     *
     * @return bool
     */
    public function isRoadOrICT(): bool
    {
        return in_array($this->role->slug, [Role::ROLE_ROADS_OWNER, Role::ROLE_ICT_OWNER]);
    }

    /**
     * Объекты пользователя
     *
     * @return HasMany
     */
    public function facilities() : HasMany
    {
        return $this->hasMany(Facility::class);
    }

    public function sendedProposals()
    {
        return $this->hasMany(Proposal::class, 'sender_id');
    }

    public function receivedProposals()
    {
        return $this->hasMany(Proposal::class, 'receiver_id');
    }

    /**
     * Существует ли предложение связанное с этими объектами вместе
     *
     * @param $facility_id
     * @param $facility_id2
     * @return bool
     */
    public function proposalIsNotExist($facility_id, $facility_id2)
    {
        return !$this->sendedProposals()->get()
            ->merge($this->receivedProposals()->get())
            ->contains(

                Proposal::query()->whereHas('facilities', function (Builder $builder) use ($facility_id) {

                    $builder->where('facilities.id', $facility_id);
                })->whereHas('facilities', function (Builder $builder) use ($facility_id2) {

                    $builder->where('facilities.id', $facility_id2);
                })->first()
            );
    }

    /**
     * Файлы всех объектов пользователя
     *
     * @return HasManyThrough
     */
    public function facilitiesFiles() : HasManyThrough
    {
        return $this->hasManyThrough(File::class, Facility::class, 'user_id', 'fileable_id', '');
    }

    /**
     * Переменные которые вбил пользователь
     *
     * @return BelongsToMany
     */
    public function variables() : BelongsToMany
    {
        return $this->belongsToMany(Variable::class)->withPivot('value');
    }
}
