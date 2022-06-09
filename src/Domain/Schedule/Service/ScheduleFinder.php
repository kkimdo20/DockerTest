<?php

namespace App\Domain\Schedule\Service;

use App\Domain\Schedule\Data\ScheduleData;
use App\Domain\Schedule\Repository\ScheduleFinderRepository;

/**
 * Service.
 */
final class ScheduleFinder
{
    private ScheduleFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param ScheduleFinderRepository $repository The repository
     */
    public function __construct(ScheduleFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find Schedules.
     *
     * @return ScheduleData[] A list of Schedules
     */
    public function findSchedules(): array
    {
        // Input validation
        // ...

        return $this->repository->findSchedules();
    }
}
