<?php

namespace App\Enums;

enum Color: string
{
    case Black = 'black';
    case White = 'white';
    case Grey = 'grey';
    case Red = 'red';
    case Blue = 'blue';
    case Green = 'green';
    case Yellow = 'yellow';
    case Orange = 'orange';
    case Brown = 'brown';
    case Pink = 'pink';
    case Purple = 'purple';
    case Multicolor = 'multicolor';

    public function label(): string
    {
        return match ($this) {
            self::Black => __('Noir'),
            self::White => __('Blanc'),
            self::Grey => __('Gris'),
            self::Red => __('Rouge'),
            self::Blue => __('Bleu'),
            self::Green => __('Vert'),
            self::Yellow => __('Jaune'),
            self::Orange => __('Orange'),
            self::Brown => __('Brun'),
            self::Pink => __('Rose'),
            self::Purple => __('Mauve'),
            self::Multicolor => __('Multicolore'),
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Black => 'bg-gray-900 text-white',
            self::White => 'bg-gray-100 text-gray-800 border border-gray-300',
            self::Grey => 'bg-gray-500 text-white',
            self::Red => 'bg-red-600 text-white',
            self::Blue => 'bg-blue-600 text-white',
            self::Green => 'bg-green-600 text-white',
            self::Yellow => 'bg-yellow-300 text-gray-900',
            self::Orange => 'bg-orange-500 text-white',
            self::Brown => 'bg-amber-800 text-white',
            self::Pink => 'bg-pink-500 text-white',
            self::Purple => 'bg-purple-600 text-white',
            self::Multicolor => 'bg-gradient-to-r from-red-500 via-green-500 to-blue-500 text-white',
        };
    }
}
