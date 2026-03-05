<?php

namespace App\Enums;

enum KYCAction: string
{
    case Create = 'create';
    case Update = 'update';

    public function label(): string
    {
        return match ($this) {
            self::Create => 'Create',
            self::Update => 'Update',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Create => 'success',
            self::Update => 'info',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }
}
