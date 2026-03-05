<?php

namespace App\Enums;

enum KYCStatus: string
{
    case Pending = 'pending';
    case UnderReview = 'under_review';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Suspended = 'suspended';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::UnderReview => 'Under Review',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Suspended => 'Suspended',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::UnderReview => 'primary',
            self::Approved => 'success',
            self::Rejected => 'danger',
            self::Suspended => 'danger',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }

    public function message(): string
    {
        return match ($this) {
            self::Pending => 'Your KYC is pending.',
            self::UnderReview => 'Your KYC is under review.',
            self::Approved => 'Your KYC is approved.',
            self::Rejected => 'Your KYC is rejected.',
            self::Suspended => 'Your KYC is suspended.',
        };
    }
}
