<?php

namespace App\Enums;

enum StyleTrip:string
{
    case Hiking = 'hiking';
    case Camp = 'camp';
    case TrailRun = 'trail_run';

    public function label(): string
    {
        return match($this) {
            self::Hiking => 'Hiking',
            self::Camp => 'Camp',
            self::TrailRun => 'Trail Run',
        };
    }
}
