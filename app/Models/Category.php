<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс категорий базы знаний
 *
 * @property int $id
 * @property string $title          - Категория
 * @property string $slug           - Уникальный строковый идентификатор
 * @property int $parent_id      - Идентификатор подкатегории
 *
 * Class Category
 * @package App\Models
 */
class Category extends Model
{
    use HasFactory;
}
