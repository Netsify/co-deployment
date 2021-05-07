<?php

namespace App\Storage;

/**
 * Класс для хранения информации по изображениям на портале
 *
 * Class UIStore
 * @package App\Models
 */
class UIStore
{
    /**
     * Операторы и провайдеры ИКТ
     */
    const ICT_START_PAGE_IMAGE = 'assets/ict.jpg';

    /**
     * Владельцы инфраструктуры
     */
    const ROAD_START_PAGE_IMAGE = 'assets/road.jpg';

    /**
     * Серый фон (для надписи)
     */
    const BACKGROUND_GREY = 'assets/grey.svg';

    /**
     * Путь до фото профиля по умолчанию
     */
    const DEFAULT_PHOTO = 'photo/default.svg';

    /**
     * Путь до иконки подтверждено
     */
    const ICON_VERIFIED = 'icons/verified.jpg';

    /**
     * Путь до иконки пользователя в профиле
     */
    const ICON_PROFILE_USER = 'assets/icons/profile/user.jpg';

    /**
     * Путь до иконки почты в профиле
     */
    const ICON_PROFILE_MAIL = 'assets/icons/profile/mail.jpg';

    /**
     * Путь до иконки телефона в профиле
     */
    const ICON_PROFILE_PHONE = 'assets/icons/profile/phone.jpg';

    /**
     * Путь до иконки адреса в профиле
     */
    const ICON_PROFILE_ADDRESS = 'assets/icons/profile/address.jpg';

    /**
     * Путь до иконки лого в навбаре
     */
    const UNESCAP_LOGO = 'assets/unescap.png';

    /**
     * Путь до иконки лого в футере
     */
    const UNESCAP_LOGO_WHITE = 'assets/footer/ESCAP-logo-master-white.png';
}
