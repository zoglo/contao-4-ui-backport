<?php

/*
 * This file is part of Contao ThemeManager Core.
 *
 * (c) https://www.oveleon.de/
 */

namespace Zoglo\ContaoUserInterfaceBackport\EventSubscriber;

use Contao\ArrayUtil;
use Contao\BackendUser;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected ScopeMatcher $scopeMatcher,
        protected TokenStorageInterface $tokenStorage,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onKernelRequest'];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->scopeMatcher->isBackendRequest($event->getRequest()))
        {
            /** @var BackendUser $user */
            $user = $this->tokenStorage->getToken()?->getUser();

            if (!$user instanceof BackendUser)
            {
                return;
            }

            switch ($user->backendTheme)
            {
                case 'contao_ui_53':
                    $GLOBALS['TL_CSS'][] = 'bundles/contaouserinterfacebackport/chosen/css/chosen.css|static';
                    $GLOBALS['TL_CSS'][] = 'bundles/contaouserinterfacebackport/simplemodal/css/simplemodal.css|static';

                    $GLOBALS['TL_JAVASCRIPT'][] = 'system/themes/contao_ui_53/ui-backport.min.js|static';
                    $GLOBALS['TL_JAVASCRIPT'][] = 'system/themes/contao_ui_53/stimulus.min.js|static';

                    break;

                case 'contao_ui_54':
                    $GLOBALS['TL_CSS'][] = 'bundles/contaouserinterfacebackport/chosen/css/chosen.css|static';
                    $GLOBALS['TL_CSS'][] = 'bundles/contaouserinterfacebackport/simplemodal/css/simplemodal.css|static';

                    $GLOBALS['TL_JAVASCRIPT'][] = 'system/themes/contao_ui_54/ui-backport.min.js|static';
                    $GLOBALS['TL_JAVASCRIPT'][] = 'system/themes/contao_ui_54/stimulus.min.js|static';

                    break;

                default:
                    return;
            }
        }
    }
}
