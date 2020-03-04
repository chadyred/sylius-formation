<?php
declare(strict_types=1);

namespace App\Fixture;

use App\Entity\Supplier;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class SupplierFixture extends AbstractFixture
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getName(): string
    {
        return 'supplier';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->arrayPrototype()
                ->children()
                    ->scalarNode('name')->cannotBeEmpty()->end()
                    ->scalarNode('email')->cannotBeEmpty()->end()
                ->end()
            ->end()
        ;
    }

    public function load(array $options): void
    {
        /** @var Supplier $product */
        $supplier = new Supplier();

        $supplier->setEmail($options[0]['email']);
        $supplier->setName($options[0]['name']);
        $this->objectManager->persist($supplier);

        $this->objectManager->flush();
    }

}
