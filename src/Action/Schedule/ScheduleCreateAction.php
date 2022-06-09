<?php

namespace App\Action\Schedule;

use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\Schedule\Service\ScheduleCreator;

/**
 * Action.
 */
final class ScheduleCreateAction
{
    private JsonRenderer $jsonRenderer;

    private ScheduleCreator $scheduleCreator;

    /**
     * The constructor.
     *
     * @param JsonRenderer $renderer The responder
     * @param ScheduleCreator $userCreator The service
     */
    public function __construct(JsonRenderer $renderer, ScheduleCreator $scheduleCreator)
    {
        $this->jsonRenderer = $renderer;
        $this->scheduleCreator = $scheduleCreator;
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
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $scheduleId = $this->scheduleCreator->createSchedule($data);
        var_dump($scheduleId);

        // Build the HTTP response
        return $this->jsonRenderer
            ->json($response, ['user_id' => $scheduleId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
