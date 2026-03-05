<?php

namespace App\Enums;

enum UserStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Pending = 'pending';

    case TemporarySuspended = 'temporary_suspended';
    case Suspended = 'suspended';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Pending => 'Pending',
            self::Suspended => 'Permanently Suspended',
            self::TemporarySuspended => 'Temporary Suspended',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }

    public function message(): string
    {
        return match ($this) {
            self::Active => 'Your account is active.',
            self::Inactive => 'Your account is inactive.',
            self::Pending => 'Your account is pending.',
            self::Suspended => 'Your account is permanently suspended.',
            self::TemporarySuspended => 'Your account is temporarily suspended. Please contact support.',
        };
    }
}
