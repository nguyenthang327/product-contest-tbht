<?php
namespace App\Enums;

enum SpecificationGroupEnum:int {
    case CPU = 1;
    case RAM = 2;
    case HARD_DRIVE = 3;
    case COLOR = 4;
    case BATTERY = 5;
}