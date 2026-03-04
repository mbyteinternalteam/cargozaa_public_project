<?php

namespace App\Enums;

enum BusinessType: string
{
    // sole_proprietor/sdn_bhd/bhd/llp
    case SOLE_PROPRIETOR = 'sole_proprietor';
    case SENDIRIAN_BERHAD = 'sdn_bhd';
    case BERHAD = 'berhad';
    case LIMITED_LIABILITY_PARTNERSHIP = 'limited_liability_partnership';

    public function label(): string
    {
        return match ($this) {
            self::SOLE_PROPRIETOR => 'Sole Proprietor',
            self::SENDIRIAN_BERHAD => 'Sendirian Berhad',
            self::BERHAD => 'Berhad',
            self::LIMITED_LIABILITY_PARTNERSHIP => 'Limited Liability Partnership',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::SOLE_PROPRIETOR => 'A sole proprietorship is a business owned and operated by a single individual.',
            self::SENDIRIAN_BERHAD => 'A sendirian berhad is a business owned and operated by a single individual.',
            self::BERHAD => 'A berhad is a business owned and operated by a group of individuals.',
            self::LIMITED_LIABILITY_PARTNERSHIP => 'A limited liability partnership is a business owned and operated by a group of individuals.',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SOLE_PROPRIETOR => 'info',
            self::SENDIRIAN_BERHAD => 'success',
            self::BERHAD => 'warning',
            self::LIMITED_LIABILITY_PARTNERSHIP => 'danger',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }
}
