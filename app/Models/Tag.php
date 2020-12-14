<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс тегов статей базы знаний
 *
 * @property int $id
 * @property string $name        - Тег
 *
 * Class Tag
 * @package App\Models
 */
class Tag extends Model
{
    use HasFactory;
}
