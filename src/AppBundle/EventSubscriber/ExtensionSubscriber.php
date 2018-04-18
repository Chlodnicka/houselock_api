<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 27.03.2018
 * Time: 19:30
 */

namespace AppBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ExtensionSubscriber implements EventSubscriberInterface
{

    protected $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        $path = $event->getRequest()->getRequestUri();

        if (!is_array($controller)) {
            return;
        }

        if(strpos($path, 'api') && !$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse('/register');
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
        );
    }

}