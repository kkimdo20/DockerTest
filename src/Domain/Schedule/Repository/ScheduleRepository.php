<?php

namespace App\Domain\Schedule\Repository;

use App\Domain\Schedule\Data\ScheduleData;
use App\Factory\QueryFactory;
use DomainException;

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
     * Insert schedule row.
     *
     * @param ScheduleData $schedule The schedule data
     *
     * @return int The new ID
     */
    public function insertSchedule(ScheduleData $schedule): int
    {
        return (int)$this->queryFactory->newInsert('maintenance_schedule', $this->toRow($schedule))
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get schedule by id.
     *
     * @param int $ScheduleId The Schedule id
     *
     * @throws DomainException
     *
     * @return ScheduleData The Schedule
     */
    public function getScheduleById(int $scheduleId): ScheduleData
    {
        $query = $this->queryFactory->newSelect('maintenance_schedule');
        $query->select(
            [
                'schedule_id',
                'pageType',
                'pageName',
                'title',
                'message',
                'tr_status',
                'time_from',
                'time_to',
                'creator',
                'created',
            ]
        );

        $query->andWhere(['schedule_id' => $scheduleId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Schedule not found: %s', $scheduleId));
        }

        return new ScheduleData($row);
    }

    /**
     * Update Schedule row.
     *
     * @param ScheduleData $schedule The Schedule
     *
     * @return void
     */
    public function updateSchedule(ScheduleData $schedule): void
    {
        $row = $this->toRow($schedule);


        $this->queryFactory->newUpdate('maintenance_schedule', $row)
            ->andWhere(['schedule_id' => $schedule->scheduleId])
            ->execute();
    }

    /**
     * Check Schedule id.
     *
     * @param int $ScheduleId The Schedule id
     *
     * @return bool True if exists
     */
    public function existsScheduleId(int $scheduleId): bool
    {
        $query = $this->queryFactory->newSelect('maintenance_schedule');
        $query->select('schedule_id')->andWhere(['schedule_id' => $scheduleId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete Schedule row.
     *
     * @param int $ScheduleId The Schedule id
     *
     * @return void
     */
    public function deleteScheduleById(int $ScheduleId): void
    {
        $this->queryFactory->newDelete('maintenance_schedule')
            ->andWhere(['schedule_id' => $ScheduleId])
            ->execute();
    }

    /**
     * Convert to array.
     *
     * @param ScheduleData $Schedule The Schedule data
     *
     * @return array The array
     */
    private function toRow(ScheduleData $schedule): array
    {
        return [
            'schedule_id' => $schedule->scheduleId,
            'apt_id' => $schedule->aptId,
            'pageType' => $schedule->pageType,
            'pageName' => $schedule->pageName,
            'title' => $schedule->title,
            'message' => $schedule->message,
            'tr_status' => $schedule->trStatus,
            'time_from' => $schedule->timeFrom,
            'time_to' => $schedule->time_to,
            'creator' => $schedule->creator,
            'created' => $schedule->created,
        ];
    }
}
