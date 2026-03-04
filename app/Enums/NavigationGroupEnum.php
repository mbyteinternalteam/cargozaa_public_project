<?php

namespace App\Enums;

class NavigationGroupEnum
{
    public const USER_MANAGEMENT = 'User Management';

    public const FINANCE = 'Finance';

    public const ADMINISTRATION = 'Administration';

    public const CONFIGS = 'Configs';

    public const OTHERS = 'Others';

    public const ROLES = 'Filament Shield';

    public static function getValues(): array
    {
        return [
            self::USER_MANAGEMENT => 'User Management',
            self::ADMINISTRATION => 'Administration',
            self::FINANCE => 'Finance',
            self::OTHERS => 'Others',
            self::CONFIGS => 'Configs',
            self::ROLES => 'Filament Shield',
        ];
    }

    public static function getLabel(string $value): string
    {
        return self::getValues()[$value] ?? $value;
    }

    public static function getValue(string $label): string
    {
        return array_search($label, self::getValues()) ?? $label;
    }

    public static function getColor(string $value): string
    {
        return match ($value) {
            self::USER_MANAGEMENT => 'primary',
            self::ADMINISTRATION => 'primary',
            self::FINANCE => 'secondary',
            self::OTHERS => 'gray',
            self::ROLES => 'primary',
        };
    }

    public static function getIcon(string $value): string
    {
        return match ($value) {
            self::USER_MANAGEMENT => 'heroicon-o-user-group',
            self::ADMINISTRATION => 'fluentui-people-16-o',
            self::FINANCE => 'heroicon-o-banknotes',
            self::OTHERS => 'heroicon-o-question-mark-circle',
            self::CONFIGS => 'heroicon-o-question-mark-circle',
            self::ROLES => 'heroicon-o-shield-check',
        };
    }
}
