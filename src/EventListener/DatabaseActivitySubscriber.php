<?php

namespace App\EventListener;

use App\Entity\JournalEntry;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

class DatabaseActivitySubscriber implements EventSubscriber
{
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $class_metadata = $args->getClassMetadata();

        switch ($class_metadata->name) {
            case JournalEntry::class:

                // CASE 1: A database column was deleted.
                unset(
                    $class_metadata->fieldMappings['title'],
                    $class_metadata->fieldNames['title'],
                    $class_metadata->columnsNames['title']
                );

                // CASE 2: A database column was renamed.
                $class_metadata->fieldMappings['body']['columnName'] = 'content';

                break;

            default:
                break;
        }
    }
}
