<?php

declare(strict_types=1);

namespace Zoglo\ContaoUserInterfaceBackport\EventListener;


use Contao\BackendUser;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsHook('loadDataContainer')]
class LoadDataContainerListener
{
    public function __construct(
        protected TokenStorageInterface $tokenStorage,
    ) {
    }

    public function __invoke(string $table): void
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        if (!$user instanceof BackendUser || !str_starts_with($user->backendTheme, 'contao_ui_'))
        {
            return;
        }

        if (
            isset($GLOBALS['TL_DCA'][$table]['list']['operations']['editheader'])
            && isset($GLOBALS['TL_DCA'][$table]['list']['operations']['edit'])
        ) {
            // Update icons
            $GLOBALS['TL_DCA'][$table]['list']['operations']['editheader']['icon'] = 'edit.svg';
            $GLOBALS['TL_DCA'][$table]['list']['operations']['edit']['icon'] = 'children.svg';

            $operations = &$GLOBALS['TL_DCA'][$table]['list']['operations'];

            if (array_key_exists('edit', $operations) && 'edit' === key($operations))
            {
                // Swap positions
                $operations = array_merge(
                    ['editHeader' => $operations['editheader']],
                    ['edit' => $operations['edit']],
                    array_diff_key($operations, ['editheader' => '', 'edit' => ''])
                );
            }
        }
    }
}
