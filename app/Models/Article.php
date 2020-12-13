<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс статей базы знаний
 *
 * @property int $id
 * @property int $user_id        - Автор
 * @property string $title          - Заголовок
 * @property string $content        - Содержание
 * @property string $status
 *
 * Class Article
 * @package App\Models
 */
class Article extends Model
{
    use HasFactory;
}
