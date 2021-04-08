<?php

declare(strict_types=1);

namespace App\App\Shared\UI\Controller;

use App\App\Shared\Domain\Exception\DomainExceptionInterface;
use App\App\Shared\Infrastructure\Symfony\MessageBus\Contract\MessageBusInterface;
use App\App\Shared\Infrastructure\Symfony\Validator\ValidationConstraintsInterface;
use App\App\Shared\Infrastructure\Symfony\Validator\ValidationManager;
use App\App\Shared\UI\Response\SerializedEntityResponse;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class DocklerAbstractController extends AbstractController
{
    protected $payload;

    protected bool $processed = false;

    protected MessageBusInterface $queryBus;

    protected MessageBusInterface $eventBus;

    protected MessageBusInterface $commandBus;

    protected TranslatorInterface $translator;

    protected LoggerInterface $httpRequestLogger;

    protected ValidationManager $validationManager;

    protected SerializedEntityResponse $serializedEntityResponse;

    public function __construct(
        MessageBusInterface $queryBus,
        MessageBusInterface $eventBus,
        MessageBusInterface $commandBus,
        TranslatorInterface $translator,
        LoggerInterface $httpRequestLogger,
        ValidationManager $validationManager,
        SerializedEntityResponse $serializedEntityResponse
    ) {
        $this->queryBus = $queryBus;
        $this->eventBus = $eventBus;
        $this->commandBus = $commandBus;
        $this->translator = $translator;
        $this->httpRequestLogger = $httpRequestLogger;
        $this->validationManager = $validationManager;
        $this->serializedEntityResponse = $serializedEntityResponse;
    }

    public function processQuery($dispatchable, array $responseGroups = [])
    {
        try {
            $envelope = $this->queryBus->dispatch($dispatchable);

            /** @var HandledStamp $handled */
            $handled = $envelope->last(HandledStamp::class);

            $entity = $handled->getResult();
        } catch (HandlerFailedException $exceptions) {
            foreach ($exceptions->getNestedExceptions() as $exception) {
                if ($exception instanceof DomainExceptionInterface) {
                    $exceptionMessage = $this->formatExceptionMessage($exception->errorFormat());

                    return new JsonResponse(
                        $exceptionMessage,
                        Response::HTTP_BAD_REQUEST
                    );
                }
            }

            $this->logError($exceptions);

            return new JsonResponse(
                $this->translator->trans('shared.error.unexpected'),
                Response::HTTP_BAD_REQUEST
            );
        }
        $this->processed = true;

        $entity = $this->formatResponse($entity);

        return new JsonResponse($this->serializedEntityResponse->fromEntity($entity, $responseGroups));
    }

    public function processCommand($dispatchable, $stamps = []): ?Response
    {
        try {
            $this->commandBus->dispatch($dispatchable, $stamps);
        } catch (HandlerFailedException $exceptions) {
            foreach ($exceptions->getNestedExceptions() as $exception) {
                if ($exception instanceof DomainExceptionInterface) {
                    $exceptionMessage = $this->formatExceptionMessage($exception->errorFormat());

                    return new JsonResponse(
                        $exceptionMessage,
                        Response::HTTP_BAD_REQUEST
                    );
                }
            }
            $this->logError($exceptions);

            return new JsonResponse(
                $this->translator->trans('shared.error.unexpected'),
                Response::HTTP_BAD_REQUEST
            );
        }
        return null;
    }

    public function dispatchEvent($dispatchable, $stamps = []): void
    {
        $this->eventBus->dispatch($dispatchable);
    }

    public function validateArray(array $payload, ValidationConstraintsInterface $constraints): ?Response
    {
        $this->validationManager->validate(
            $constraints->getConstraints(),
            $payload
        );

        if ($this->validationManager->isValid() === false && ! empty($this->validationManager->getViolations())) {
            return new JsonResponse($this->validationManager->getViolations(), Response::HTTP_BAD_REQUEST);
        }

        return null;
    }

    protected function validate(Request $request, ValidationConstraintsInterface $constraints): ?Response
    {
        $this->payload = json_decode($request->getContent(), true);
        $this->validationManager->validate(
            $constraints->getConstraints(),
            $this->payload
        );

        if ($this->validationManager->isValid() === false && ! empty($this->validationManager->getViolations())) {
            return new JsonResponse($this->validationManager->getViolations(), Response::HTTP_BAD_REQUEST);
        }

        return null;
    }

    protected function formatResponse($entity)
    {
        return $entity;
    }

    protected function formatExceptionMessage($exceptionMessage)
    {
        return $exceptionMessage;
    }

    protected function payload()
    {
        return $this->payload;
    }

    protected function isRequestProcessed()
    {
        return $this->processed;
    }

    private function logError($exceptions): void
    {
        $this->httpRequestLogger->error(
            '',
            [
                'payload' => $this->payload(),
                'when' => date('c'),
                'error' => $exceptions,
            ]
        );
    }
}
