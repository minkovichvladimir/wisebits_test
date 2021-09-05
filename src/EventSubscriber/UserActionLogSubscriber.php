<?php

namespace App\EventSubscriber;

use App\Entity\ActionLog;
use App\Event\UserCreatedEvent;
use App\Event\UserDeletedEvent;
use App\Event\UserUpdatedEvent;
use App\Repository\ActionLogRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserActionLogSubscriber implements EventSubscriberInterface
{
    /**
     * @var ActionLogRepository
     */
    private $actionLogRepository;

    /**
     * @param ActionLogRepository $actionLogRepository
     */
    public function __construct(ActionLogRepository $actionLogRepository)
    {
        $this->actionLogRepository = $actionLogRepository;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedEvent::class => 'userCreated',
            UserUpdatedEvent::class => 'userUpdated',
            UserDeletedEvent::class => 'userDeleted',
        ];
    }

    /**
     * @param UserCreatedEvent $event
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function userCreated(UserCreatedEvent $event): void
    {
        $actionLog = $this->buildActionLog(ActionLog::ACTION_CREATE, null, $event->getNewUser());
        if ($actionLog) {
            $this->actionLogRepository->save($actionLog);
        }
    }

    /**
     * @param UserUpdatedEvent $event
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function userUpdated(UserUpdatedEvent $event): void
    {
        $actionLog = $this->buildActionLog(ActionLog::ACTION_UPDATE, $event->getOldUser(), $event->getNewUser());
        if ($actionLog) {
            $this->actionLogRepository->save($actionLog);
        }
    }

    /**
     * @param UserDeletedEvent $event
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function userDeleted(UserDeletedEvent $event): void
    {
        $actionLog = $this->buildActionLog(ActionLog::ACTION_DELETE, $event->getOldUser(), $event->getNewUser());
        if ($actionLog) {
            $this->actionLogRepository->save($actionLog);
        }
    }

    /**
     * @param string $action
     * @param string|null $before
     * @param string|null $after
     * @return ActionLog|null
     */
    private function buildActionLog(string $action, ?string $before, ?string $after): ?ActionLog
    {
        if (!$before && !$after) {
            return null;
        }
        return new ActionLog('user', $action, $before, $after);
    }
}