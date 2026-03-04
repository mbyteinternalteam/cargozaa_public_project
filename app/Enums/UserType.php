<?php

namespace App\Enums;

enum UserType: string
{
    case CUSTOMER = 'customer';
    case OWNER = 'owner';
    case STAFF = 'staff';

    public function label(): string
    {
        return match ($this) {
            self::CUSTOMER => 'Customer',
            self::OWNER => 'Owner',
            self::STAFF => 'Staff',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::CUSTOMER => 'Leases containers for shipping/storage',
            self::OWNER => 'Lists containers on the platform',
            self::STAFF => 'Internal staff member with admin access',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CUSTOMER => 'info',
            self::OWNER => 'success',
            self::STAFF => 'purple',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::CUSTOMER => 'heroicon-o-user',
            self::OWNER => 'heroicon-o-building-storefront',
            self::STAFF => 'heroicon-o-shield-check',
        };
    }

    public function isPublic(): bool
    {
        return in_array($this, [self::CUSTOMER, self::OWNER]);
    }

    public function requiresApproval(): bool
    {
        return $this === self::OWNER;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }

    public static function publicOptions(): array
    {
        return collect(self::cases())
            ->filter(fn ($case) => $case->isPublic())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }

    public static function tryFromValue(?string $value): ?self
    {
        return self::tryFrom($value);
    }

    public function defaultRedirectRoute(): string
    {
        return match ($this) {
            self::CUSTOMER => 'customer.dashboard',
            self::OWNER => 'owner.dashboard',
        };
    }
}
