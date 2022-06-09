<?php

namespace App\Action\Schedule;

use App\Domain\Schedule\Service\ScheduleFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ScheduleFindAction
{
    private ScheduleFinder $scheduleFinder;

    private JsonRenderer $jsonRenderer;

    /**
     * The constructor.
     *
     * @param ScheduleFinder $userIndex The user index list viewer
     * @param JsonRenderer $jsonRenderer The renderer
     */
    public function __construct(ScheduleFinder $scheduleIndex, JsonRenderer $jsonRenderer)
    {
        $this->scheduleFinder = $scheduleIndex;
        $this->jsonRenderer = $jsonRenderer;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findUsers method
        $schedules = $this->scheduleFinder->findSchedules();

        return $this->transform($response, $schedules);
    }

    /**
     * Transform to json response.
     * This could also be done within a specific Responder class.
     *
     * @param ResponseInterface $response The response
     * @param array $users The users
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, array $schedules): ResponseInterface
    {
        $scheduleList = [];

        foreach ($schedules as $schedule) {
            $scheduleList[] = [
                'schedule_id' => $schedule -> scheduleId,
                'apt_id' => $schedule -> aptId,
                'pageType' => $schedule -> pageType,
                'pageName' => $schedule -> pageName,
                'title' => $schedule -> title,
                'message' => $schedule -> message,
                'tr_status' => $schedule -> trStatus,
                'time_from' => $schedule -> timeFrom,
                'time_to' => $schedule -> timeTo,
                'creator' => $schedule -> creator,
                'created' => $schedule -> created,
            ];
        }

        return $this->jsonRenderer->json(
            $response,
            [
                'schedules' => $scheduleList,
            ]
        );
    }
}
