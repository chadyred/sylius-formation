<?php
declare(strict_types=1);

namespace App\Fixture;

use App\Entity\Supplier;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Factory\FactoryInterface;

class SupplierExampleFactory extends AbstractExampleFactory
{
    private $faker;

    private $optionsResolver;
    private $supplierFactory;

    public function __construct(
        FactoryInterface $supplierFactory
    )
    {
        $this->faker = \Faker\Factory::create();
        $this->optionsResolver = new OptionsResolver();
        $this->supplierFactory = $supplierFactory;

        $this->configureOptions($this->optionsResolver);

    }

    public function create(array $options = [])
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var Supplier $supplier */
        $supplier = $this->supplierFactory->createNew();
        $supplier->setName($options['name']);
        $supplier->setEmail($options['email']);

        return $supplier;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('name', function (OptionsResolver $options) :string {
                return $this->faker->company;
           })
            ->setDefault('email', function (OptionsResolver $options) : string {
                return $this->faker->email;
            })
        ;
    }
}
