<?php

namespace App\Domain\Schedule\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class ScheduleData
{
    public ?int $scheduleId = null;

    public ?array $aptId = null;

    public ?int $pageType = null;

    public ?string $pageName = null;

    public ?string $title = null;

    public ?string $message = null;

    public ?int $trStatus = null;

    public ?string $timeFrom = null;

    public ?string $creator = null;

    public ?string $created = null;

    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [])
    {
        $reader = new ArrayReader($data);

        $this->scheduleId = $reader->findInt('schedule_id');
        $this->aptId = $reader->findArray('apt_id');
        $this->pageType = $reader->findString('pageType');
        $this->pageName = $reader->findString('pageName');
        $this->title = $reader->findString('title');
        $this->message = $reader->findString('message');
        $this->trStatus = $reader->findString('tr_status');
        $this->timeFrom = $reader->findInt('time_from');
        $this->timeTo = $reader->findString('time_to');
        $this->creator = $reader->findString('creator');
        $this->created = $reader->findint('created');
    }
}
