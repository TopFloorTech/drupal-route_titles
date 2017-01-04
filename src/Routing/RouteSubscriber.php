<?php

namespace Drupal\route_titles\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\RouteCollection;

/**
 * Override titles for configured routes.
 */
class RouteSubscriber extends RouteSubscriberBase {

  public static function getSubscribedEvents() {
    $events = [];

    $events[RoutingEvents::ALTER] = array('onAlterRoutes', 100);

    return $events;
  }

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    $config = \Drupal::config('route_titles.settings');
    $newLines = '/(\r\n|\r|\n)/';
    $titles = preg_split($newLines, $config->get('titles'));

    foreach ((array) $titles as $pattern) {
      $pattern = trim($pattern);
      if (empty($pattern)) {
        continue;
      }

      list($route, $title) = explode("|", $pattern);

      if ($route = $collection->get($route)) {
        $route->setDefault('_title', $title);
      }
    }
  }
}
