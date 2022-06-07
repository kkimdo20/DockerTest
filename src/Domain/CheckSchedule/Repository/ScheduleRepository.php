<?php

namespace App\Domain\CheckSchedule\Repository;

use DomainException;
use App\Factory\QueryFactory;
use App\Domain\User\Data\ScheduleData;

/**
 * Repository.
 */
final class ScheduleRepository
{
    private QueryFactory $queryFactory;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    /**
     * Insert user row.
     *
     * @param ScheduleData $user The user data
     *
     * @return int The new ID
     */
    public function insertSchedule(ScheduleData $user): int
    {
        return (int)$this->queryFactory->newInsert('users', $this->toRow($user))
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get user by id.
     *
     * @param int $userId The user id
     *
     * @throws DomainException
     *
     * @return ScheduleData The user
     */
    public function getScheduleById(int $userId): ScheduleData
    {
        $query = $this->queryFactory->newSelect('users');
        $query->select(
            [
                'id',
                'username',
                'first_name',
                'last_name',
                'email',
                'user_role_id',
                'locale',
                'enabled',
            ]
        );

        $query->andWhere(['id' => $userId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('User not found: %s', $userId));
        }

        return new ScheduleData($row);
    }

    /**
     * Update user row.
     *
     * @param ScheduleData $user The user
     *
     * @return void
     */
    public function updateUser(ScheduleData $user): void
    {
        $row = $this->toRow($user);

        // Updating the password is another use case
        unset($row['password']);

        $this->queryFactory->newUpdate('users', $row)
            ->andWhere(['id' => $user->id])
            ->execute();
    }

    /**
     * Check user id.
     *
     * @param int $userId The user id
     *
     * @return bool True if exists
     */
    public function existsUserId(int $userId): bool
    {
        $query = $this->queryFactory->newSelect('users');
        $query->select('id')->andWhere(['id' => $userId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete user row.
     *
     * @param int $userId The user id
     *
     * @return void
     */
    public function deleteUserById(int $userId): void
    {
        $this->queryFactory->newDelete('users')
            ->andWhere(['id' => $userId])
            ->execute();
    }

    /**
     * Convert to array.
     *
     * @param ScheduleData $user The user data
     *
     * @return array The array
     */
    private function toRow(ScheduleData $user): array
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'password' => $user->password,
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'email' => $user->email,
            'user_role_id' => $user->userRoleId,
            'locale' => $user->locale,
            'enabled' => (int)$user->enabled,
        ];
    }
}
