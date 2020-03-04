<?php

declare(strict_types=1);

namespace App\Listener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class SupplierMenuBuilder
{
    public function __invoke(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();
        $catalog = $menu->getChild('catalog');

        $catalog
            ->addChild('supplier', ['route' => 'app_admin_supplier_index'])
            ->setLabel('Supplier')
            ->setLabelAttribute('icon', 'star')
        ;

    }
}
