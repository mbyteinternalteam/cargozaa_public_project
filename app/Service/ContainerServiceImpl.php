<?php

namespace App\Service;

use App\Enums\ContainerStatus;
use App\Enums\ContainerStructure as ContainerStructureEnum;
use App\Models\Config\ContainerStructure;
use App\Models\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContainerServiceImpl implements ContainerService
{
    public function getOwnerContainers(int $ownerId, int $perPage = 12): LengthAwarePaginator
    {
        return Container::query()
            ->where('owner_id', $ownerId)
            ->latest()
            ->paginate($perPage);
    }

    public function getOwnerContainerStats(int $ownerId): array
    {
        $baseQuery = Container::query()->where('owner_id', $ownerId);

        return [
            'total' => (clone $baseQuery)->count(),
            'active' => (clone $baseQuery)->where('status', ContainerStatus::Active)->count(),
            'pending' => (clone $baseQuery)->where('status', ContainerStatus::Pending)->count(),
            'inactive' => (clone $baseQuery)->where('status', ContainerStatus::Inactive)->count(),
            'under_review' => (clone $baseQuery)->where('status', ContainerStatus::UnderReview)->count(),
        ];
    }

    public function getCurrentMonthActiveContainersCount(int $ownerId): int
    {
        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();

        return Container::query()
            ->where('owner_id', $ownerId)
            ->where('status', ContainerStatus::Active)
            ->where(function ($query) use ($currentMonthStart, $currentMonthEnd) {
                $query->whereDate('created_at', '<=', $currentMonthEnd)
                      ->orWhere(function ($subQuery) use ($currentMonthStart, $currentMonthEnd) {
                          $subQuery->whereDate('updated_at', '>=', $currentMonthStart)
                                   ->whereDate('updated_at', '<=', $currentMonthEnd);
                      });
            })
            ->count();
    }

    public function getPreviousMonthActiveContainersCount(int $ownerId): int
    {
        $previousMonth = now()->subMonth();
        $previousMonthStart = $previousMonth->copy()->startOfMonth();
        $previousMonthEnd = $previousMonth->copy()->endOfMonth();

        return Container::query()
            ->where('owner_id', $ownerId)
            ->where('status', ContainerStatus::Active)
            ->where(function ($query) use ($previousMonthStart, $previousMonthEnd) {
                $query->whereDate('created_at', '<=', $previousMonthEnd)
                      ->orWhere(function ($subQuery) use ($previousMonthStart, $previousMonthEnd) {
                          $subQuery->whereDate('updated_at', '>=', $previousMonthStart)
                                   ->whereDate('updated_at', '<=', $previousMonthEnd);
                      });
            })
            ->count();
    }

}