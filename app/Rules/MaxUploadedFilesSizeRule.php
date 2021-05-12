<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class MaxUploadedFilesSizeRule implements Rule
{
    /**
     * 1 килобайт = 1000000 байт
     */
    const MB = 1000000;

    /**
     * Максимальная сумма размеров файлов
     *
     * @var float
     */
    private $mb;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(float $mb)
    {
        $this->mb = $mb;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $sum = 0;
        foreach ($value as $uploaded_file) {
            /**
             * @var UploadedFile $uploaded_file
             */
            $sum += $this->getMB($uploaded_file->getSize());
        }

        return $sum <= $this->mb;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Сумма размеров загружаемых файлов не должна превышать ' . $this->mb  . ' мб.';
    }

    /**
     * Получаем размер файла в мегабайте
     *
     * @param int $byte
     * @return float
     */
    private function getMB(int $byte): float
    {
        return $byte / self::MB;
    }
}
