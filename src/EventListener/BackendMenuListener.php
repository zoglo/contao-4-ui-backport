<?php

declare(strict_types=1);

namespace Zoglo\ContaoUserInterfaceBackport\EventListener;

use Contao\BackendUser;
use Contao\CoreBundle\Event\ContaoCoreEvents;
use Contao\CoreBundle\Event\MenuEvent;
use Knp\Menu\ItemInterface;
use Knp\Menu\Util\MenuManipulator;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsEventListener(ContaoCoreEvents::BACKEND_MENU_BUILD, priority: -255)]
class BackendMenuListener
{
    private MenuEvent $event;
    private ItemInterface $tree;

    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly TranslatorInterface $translator,
        private ?MenuManipulator $menuManipulator = null
    ) {
    }

    /**
     * @throws \JsonException
     */
    public function __invoke(MenuEvent $event): void
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        if (
            !$user instanceof BackendUser
            || !str_starts_with($user->backendTheme, 'contao_ui_')
        ) {
            return;
        }

        $this->event = $event;
        $this->tree = $event->getTree();

        if ('headerMenu' !== $this->tree->getName())
        {
            return;
        }

        $this->addDarkModeToggle();
        $this->addLogoutCssClass();
    }

    /**
     * @throws \JsonException
     */
    private function addDarkModeToggle(): void
    {
        $colorScheme = $this->event
            ->getFactory()
            ->createItem('color-scheme')
            ->setUri('#')
            ->setLinkAttribute('class', 'icon-color-scheme')
            ->setLinkAttribute('title', '') // Required for the tips.js script
            ->setLinkAttribute('data-controller', 'contao--color-scheme')
            ->setLinkAttribute('data-contao--color-scheme-target', 'label')
            ->setLinkAttribute(
                'data-contao--color-scheme-i18n-value',
                json_encode(
                    [
                        'dark' => $this->translator->trans('MSC.darkMode', [], 'contao_default'),
                        'light' => $this->translator->trans('MSC.lightMode', [], 'contao_default'),
                    ],
                    JSON_THROW_ON_ERROR,
                ),
            )
            ->setExtra('safe_label', true)
            ->setExtra('translation_domain', false)
        ;

        $this->tree->addChild($colorScheme);

        $this->menuManipulator?->moveChildToPosition($this->tree, $colorScheme, 2);
    }

    /**
     * Adding the logout class that was introduced in Contao 5
     */
    private function addLogoutCssClass(): void
    {
        $logout = $this->tree->getChild('submenu')?->getChild('logout');

        if (!$logout instanceof ItemInterface)
        {
            return;
        }

        $logout->setAttribute('class', 'logout');
    }
}
