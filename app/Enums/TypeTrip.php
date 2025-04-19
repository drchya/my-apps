<?php

namespace App\Enums;

enum TypeTrip: string
{
    case SoloHiking = 'solo_hiking';
    case OpenTrip = 'open_trip';
    case Friends = 'friends';

    public function label(): string
    {
        return match($this) {
            self::SoloHiking => 'Solo Hiking',
            self::OpenTrip => 'Open Trip',
            self::Friends => 'Friends',
        };
    }
}
