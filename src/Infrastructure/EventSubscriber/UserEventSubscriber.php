<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

class UserEventSubscriber implements EventSubscriber
{
    private array $changes = [];

    public function __construct(
        private readonly ?object $logService = null
    ) {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::preUpdate,
            Events::postUpdate,
        ];
    }

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $user = $event->getObject();

        if (!$user instanceof User) {
            return;
        }

        $this->changes = $event->getEntityChangeSet();
    }

    public function postUpdate(PostUpdateEventArgs $event): void
    {
        $user = $event->getObject();

        if (!$user instanceof User) {
            return;
        }

        $this->logChanges();
    }

    /**
     * Here is the logging service stub
     */
    private function logChanges(): void
    {
        if (!$this->logService) {
            return;
        }

        $this->logService->log($this->changes);
    }
}
