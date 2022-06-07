<?php

namespace App\Domain\CheckSchedule\Service;

use Psr\Log\LoggerInterface;
use App\Factory\LoggerFactory;
use App\Domain\User\Data\ScheduleData;
use App\Domain\CheckSchedule\Repository\UserRepository;
use App\Domain\CheckSchedule\Repository\ScheduleRepository;

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
     * @param ScheduleValidator $ScheduleValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        ScheduleRepository $repository,
        ScheduleValidator $scheduleValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->ScheduleValidator = $scheduleValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('user_creator.log')
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
        $this->userValidator->validateUser($data);

        // Map form data to user DTO (model)
        $schedule = new ScheduleData($data);

        // Insert user and get new user ID
        $scheduleId = $this->repository->insertSchedule($schedule);

        // Logging
        $this->logger->info(sprintf('Schedule created successfully: %s', $scheduleId));

        return $scheduleId;
    }
}
