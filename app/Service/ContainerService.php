<?php

namespace App\Service;

use App\Enums\ContainerStatus;
use App\Models\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ContainerService
{
    /**
     * Get containers by owner ID with pagination
     */
    public function getOwnerContainers(int $ownerId, int $perPage = 12): LengthAwarePaginator;

    /**
     * Get container statistics for an owner
     */
    public function getOwnerContainerStats(int $ownerId): array;

    /**
     * Get current month's active containers count for an owner
     */
    public function getCurrentMonthActiveContainersCount(int $ownerId): int;

    /**
     * Get previous month's active containers count for an owner
     */
    public function getPreviousMonthActiveContainersCount(int $ownerId): int;

}