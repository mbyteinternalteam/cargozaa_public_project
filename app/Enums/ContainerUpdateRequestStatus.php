<?php

namespace App\Enums;

enum ContainerUpdateRequestStatus: string
{
    case Pending = 'pending';
    case UnderReview = 'under_review';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::UnderReview => 'Under Review',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'bg-warning',
            self::UnderReview => 'bg-info',
            self::Approved => 'bg-success',
            self::Rejected => 'bg-danger',
        };
    }
}
