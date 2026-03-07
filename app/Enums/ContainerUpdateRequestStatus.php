<?php

namespace App\Enums;

enum ContainerUpdateRequestStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
