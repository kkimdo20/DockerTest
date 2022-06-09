<?php

namespace App\Domain\Schedule\Service;

use App\Support\Validation;
use Cake\Validation\Validator;
use App\Domain\Schedule\Repository\ScheduleRepository;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class ScheduleValidator
{
    private ScheduleRepository $repository;

    private Validation $validation;

    /**
     * The constructor.
     *
     * @param ScheduleRepository $repository The repository
     * @param Validation $validation The validation
     */
    public function __construct(ScheduleRepository $repository, Validation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    /**
     * Validate update.
     *
     * @param int $userId The user id
     * @param array $data The data
     *
     * @return void
     */
    public function validateScheduleUpdate(int $scheduleId, array $data): void
    {
        if (!$this->repository->existsScheduleId($scheduleId)) {
            throw new ValidationException(sprintf('Schedule not found: %s', $scheduleId));
        }

        $this->validateSchedule($data);
    }

    /**
     * Validate new user.
     *
     * @param array $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateSchedule(array $data): void
    {
        $validator = $this->createValidator();
        $validationResult = $this->validation->validate($validator, $data);

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    /**
     * Create validator.
     *
     * @return Validator The validator
     */
    private function createValidator(): Validator
    {
        $validator = $this->validation->createValidator();

        return $validator;

    }
}
