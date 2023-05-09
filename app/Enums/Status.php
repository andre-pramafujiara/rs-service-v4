<?php

namespace App\Enums;

enum Status: string {
    case JANDA = 'Janda';
    case DUDA = 'Duda';
    case JANDADUDA = 'Janda/Duda';
    case MENIKAH = 'Menikah';
    case SINGLE = 'Single';
}
