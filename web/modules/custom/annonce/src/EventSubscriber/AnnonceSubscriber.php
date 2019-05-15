<?php

namespace Drupal\annonce\EventSubscriber;

use Drupal\Component\Datetime\Time;
use Drupal\Core\Database\Connection;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class AnnonceSubscriber implements EventSubscriberInterface {

    protected $messenger;
    protected $currentUser;
    protected $current_route_match;
    protected $database;
    protected $time;

    public function __construct(MessengerInterface $messenger, AccountProxyInterface $currentUser,
                                RouteMatchInterface $current_route_match, Connection $database, Time $time) {

        $this->messenger = $messenger;
        $this->currentUser = $currentUser;
        $this->current_route_match = $current_route_match;
        $this->database = $database;
        $this->time = $time;
    }
    public static function getSubscribedEvents() {
        $events[KernelEvents::REQUEST][] = ['request'];
        return $events;
    }
    public function request() {
        if ($this->current_route_match->getRouteName()=='entity.annonce.canonical') {
            // $this->messenger->addMessage(t('Event for %username', array('%username' => $this->currentUser->getAccountName())));
            $this->database->insert('annonce_history')->fields(array(
                'aid' => $this->current_route_match->getParameter('annonce')->id(),
                'uid' => $this->currentUser->id(),
                'date' => $this->time->getCurrentTime(),
            ))->execute();
        }
    }
}