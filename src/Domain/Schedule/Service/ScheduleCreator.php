<?php

namespace App\Domain\Schedule\Service;

use Cake\Chronos\Chronos;
use Psr\Log\LoggerInterface;
use App\Factory\LoggerFactory;
use App\Domain\Schedule\Data\ScheduleData;
use App\Domain\Schedule\Service\ScheduleValidator;
use App\Domain\Schedule\Repository\ScheduleRepository;

/**
 * Service.
 */
final class ScheduleCreator
{
    private ScheduleRepository $repository;

    private ScheduleValidator $scheduleValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param ScheduleRepository $repository The repository
     * @param ScheduleValidator $userValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        ScheduleRepository $repository,
        ScheduleValidator $scheduleValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->scheduleValidator = $scheduleValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('schedule_creator.log')
            ->createLogger();
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function createSchedule(array $data): int
    {
        // Input validation
        $this->scheduleValidator->validateSchedule($data);

        // Map form data to user DTO (model)
        $schedule = new ScheduleData($data);
        $schedule->created = Chronos::now();

        // Insert user and get new user ID
        $scheduleId = $this->repository->insertSchedule($schedule);

        // Logging
        $this->logger->info(sprintf('User created successfully: %s', $scheduleId));

        return $scheduleId;
    }
}
