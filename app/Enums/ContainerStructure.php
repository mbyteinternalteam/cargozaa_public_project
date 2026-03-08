<?php

namespace App\Enums;

enum ContainerStructure: string
{
    case FEATURE = 'feature';
    case SIZE = 'size';
    case TYPE = 'type';
    case CONDITION = 'condition';

    public function label(): string
    {
        return match ($this) {
            self::FEATURE => 'Feature',
            self::SIZE => 'Size',
            self::TYPE => 'Type',
            self::CONDITION => 'Condition',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::FEATURE => 'info',
            self::SIZE => 'success',
            self::TYPE => 'warning',
            self::CONDITION => 'danger',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }
}
