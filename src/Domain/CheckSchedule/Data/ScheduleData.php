<?php

namespace App\Domain\User\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class ScheduleData
{
    public ?int $schSeq = null;

    public ?string $schTitle = null;


    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [])
    {
        $reader = new ArrayReader($data);

        $this->schSeq = $reader->findInt('schSeq');
        $this->schTitle = $reader->findInt('schTitle');

    }

}
