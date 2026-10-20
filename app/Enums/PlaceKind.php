<?php

namespace App\Enums;

enum PlaceKind: string
{
    case Hall = 'hall';
    case Platform = 'platform';
    case Train = 'train';

    public function label(): string
    {
        return match ($this) {
            self::Hall => __('Hall'),
            self::Platform => __('Quai'),
            self::Train => __('Train'),
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Hall => 'bg-sky-50 text-sky-800 border border-sky-200',
            self::Platform => 'bg-amber-50 text-amber-900 border border-amber-200',
            self::Train => 'bg-orange-50 text-orange-800 border border-orange-200',
        };
    }
}
