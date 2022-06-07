<?php

namespace App\Domain\checkSchedule\Service;

use App\Support\Validation;
use Cake\Validation\Validator;
use App\Domain\checkSchedule\Type\UserRoleType;
use App\Domain\checkSchedule\Repository\UserRepository;
use Selective\Validation\Exception\ValidationException;
use App\Domain\CheckSchedule\Repository\ScheduleRepository;

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
     * @param UserRepository $repository The repository
     * @param Validation $validation The validation
     */
    public function __construct(scheduleRepository $repository, Validation $validation)
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
    public function validateUserUpdate(int $userId, array $data): void
    {
        if (!$this->repository->existsUserId($userId)) {
            throw new ValidationException(sprintf('User not found: %s', $userId));
        }

        $this->validateUser($data);
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
    public function validateUser(array $data): void
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

        return $validator
            ->notEmptyString('username', 'Input required');
    }
}
