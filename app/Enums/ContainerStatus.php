<?php

namespace App\Enums;

enum ContainerStatus: string
{
    case Pending = 'pending';
    case UnderReview = 'under_review';
    case Active = 'active';
    case Inactive = 'inactive';
    case Rejected = 'rejected';

    case Appeal = 'appeal';
    case Deleted = 'deleted';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::UnderReview => 'Under Review',
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Rejected => 'Rejected',
            self::Appeal => 'Appeal',
            self::Deleted => 'Deleted',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::UnderReview => 'Under Review',
            self::Active => 'Active container is available for lease',
            self::Inactive => 'Inactive container is not available for lease',
            self::Rejected => 'Rejected container is not available for lease',
            self::Appeal => 'Appeal container is under appeal',
            self::Deleted => 'Deleted container is deleted from the platform',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::UnderReview => 'primary',
            self::Active => 'success',
            self::Inactive => 'warning',
            self::Rejected => 'danger',
            self::Appeal => 'warning',
            self::Deleted => 'danger',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Pending => 'heroicon-o-clock',
            self::UnderReview => 'heroicon-o-clock',
            self::Active => 'heroicon-o-check-circle',
            self::Inactive => 'heroicon-o-x-circle',
            self::Rejected => 'heroicon-o-x-circle',
            self::Appeal => 'heroicon-o-clock',
            self::Deleted => 'heroicon-o-trash',
        };
    }

   
}
