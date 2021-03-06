<?php

declare(strict_types=1);

namespace App\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_supplier")
 */
class Supplier implements ResourceInterface
{
    const STATE_UNVERIFIED = 'unverified';
    const STATE_VERIFIED = 'verified';

    /**
     * @var $id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string")
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string")
     */
    private $state;

    public function __construct()
    {
        $this->state = self::STATE_UNVERIFIED;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /** @internal */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
