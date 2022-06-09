<?php

namespace App\Domain\Schedule\Repository;

use App\Factory\QueryFactory;
use App\Domain\Schedule\Data\ScheduleData;

/**
 * Repository.
 */
final class ScheduleFinderRepository
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
     * Find users.
     *
     * @return UserData[] A list of users
     */
    public function findSchedules(): array
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

        $query2 = $this->queryFactory->newSelect('maintenance_target');
        $query2->select(
            [
                'target_id',
                'schedule_id',
                'apt_id',
            ]
        );


        // Add more "use case specific" conditions to the query
        // ...

        $rows = $query->execute()->fetchAll('assoc') ?: [];
        $secondRows = $query2->execute()->fetchAll('assoc') ?: [];;
        // Convert to list of objects
        $result = [];
        foreach ($rows as $row) {
            $value = $row;
            foreach($secondRows as $secondRow){
                if($secondRow['schedule_id'] == ($value['schedule_id'])){
                    $value['apt_id'][] = $secondRow['apt_id'];
                }
            }
            $result[] = new ScheduleData($value);
        }
        return $result;
    }
}
