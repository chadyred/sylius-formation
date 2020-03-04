<?php

declare(strict_types=1);

namespace App\Entity\Product;

use App\Entity\Supplier;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct
{
    /**
     * @var Supplier|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplier")
     * @ORM\JoinColumn(name="supplier_id", onDelete="SET NULL")
     */
    private $supplier;

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }

    /**
     * @return Supplier|null
     */
    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    /**
     * @param Supplier|null $supplier
     * @return Product
     */
    public function setSupplier(?Supplier $supplier): Product
    {
        $this->supplier = $supplier;

        return $this;
    }
}
