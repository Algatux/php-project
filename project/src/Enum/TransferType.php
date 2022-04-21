<?php declare(strict_types=1);

namespace App\Enum;

enum TransferType: string {
    case IN = 'IN';
    case OUT = 'OUT';
}