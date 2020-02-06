<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync;

use Exception;
use OC;
use OC\HintException;
use OCA\NextcloudConnectorSync\Event\Files\PreCreate;
use OCP\EventDispatcher\GenericEvent;

class Hooks
{

    public static function preCreateFile(GenericEvent $event)
    {
        $node = $event->getSubject();
        $projectStorage = OC::$server->query(ProjectStorage::class);
        try {
            $event = PreCreate::create($node, $projectStorage);
            $connector = OC::$server->query(Connector::class);
            $connector->send($event);
        } catch (Exception $e) {
            throw new HintException($e);
        }
    }

}