<?php

namespace Drupal\monmodule\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class monmoduleSubscriber.
 */
class monmoduleSubscriber implements EventSubscriberInterface {


  /**
   * Constructs a new monmoduleSubscriber object.
   */
  public function __construct() {

  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['kernel.request'] = ['request'];

    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */
  public function request(Event $event) {
    drupal_set_message('Event kernel.request thrown by Subscriber in module monmodule.', 'status', TRUE);
  }

}
