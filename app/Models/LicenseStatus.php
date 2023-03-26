<?php

namespace App\Models;

enum LicenseStatus: int {
    case FREE = 0b00000001; // Свободная лицензия
    case USING = 0b00000010; // Используется (в настоящий момент)
    case USED = 0b00000100; // Использована (тестирование завершено)
    case BROKEN = 0b00001000; // Повреждена (тест прерван)

    public static function getName(int $ls): string {
        return match ($ls) {
            self::FREE->value => 'Свободная',
            self::USING->value => 'Используется',
            self::USED->value => 'Использована',
            self::BROKEN->value => 'Повреждена',
            default => 'Неизвестный статус лицензии'
        };
    }
}