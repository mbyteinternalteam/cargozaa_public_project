<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ContextOptions: string implements HasColor, HasIcon, HasLabel
{
    case ACCOUNT = 'account';
    case ORDER = 'order';
    case PAYMENT = 'payment';
    case SHIPPING = 'shipping';
    case PRODUCT = 'product';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::ACCOUNT => 'gray',
            self::ORDER => 'blue',
            self::PAYMENT => 'green',
            self::SHIPPING => 'yellow',
            self::PRODUCT => 'red',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::ACCOUNT => 'heroicon-o-user',
            self::ORDER => 'heroicon-o-shopping-cart',
            self::PAYMENT => 'heroicon-o-credit-card',
            self::SHIPPING => 'heroicon-o-truck',
            self::PRODUCT => 'heroicon-o-cube',
        };
    }
}
