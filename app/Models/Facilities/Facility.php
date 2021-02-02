<?php

namespace App\Models\Facilities;

use App\Models\File;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Объекты инфраструктуры
 *
 * @property int $id
 * @property int $user_id                   - ИД пользователя
 * @property int $type_id                   - ИД типа объекта
 * @property int $visibility_id             - ИД видимости объекта
 * @property string $title                  - Название
 * @property string $location               - Местоположение
 * @property string $description            - Описание
 * @property-read string $identificator     - Уникальный идентификатор объекта
 * @property-read string $locale            - В какой локали создавался объект
 * @property Carbon $created_at             - Дата создания
 * @property Carbon $updated_at             - Дата редактирования
 * @property User $user                     - Пользователь
 * @property FacilityType $type             - Тип
 * @property FacilityVisibility $visibility - Кому виден объект
 * @property File[] $files                  - Файлы приклеплённые к объекту
 * @property CompatibilityParam[] $compatibilityParams - Параметры своместимости
 *
 * Class Facility
 * @package App\Models\Facilities
 */
class Facility extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'location', 'description'];

    /**
     * файлы
     *
     * @return MorphMany
     */
    public function files() : MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Тип
     *
     * @return BelongsTo
     */
    public function type() : BelongsTo
    {
        return $this->belongsTo(FacilityType::class);
    }

    /**
     * Кому виден объект
     *
     * @return BelongsTo
     */
    public function visibility() : BelongsTo
    {
        return $this->belongsTo(FacilityVisibility::class);
    }

    /**
     * Праметры совместимости
     *
     * @return BelongsToMany
     */
    public function compatibilityParams() : BelongsToMany
    {
        return $this->belongsToMany(CompatibilityParam::class)->withPivot('value')->withTimestamps();
    }

    /**
     * @param string $identificator
     */
    public function setIdentificator($identificator)
    {
        $this->identificator = $identificator;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Превью статьи
     * @return string
     */
    public function getPreviewAttribute()
    {
        return mb_substr(strip_tags($this->description), 0, 200, 'UTF-8');
    }
}
