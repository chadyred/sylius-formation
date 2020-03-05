<?php

declare(strict_types=1);

namespace App\Form\Type;

use Sylius\Component\Attribute\AttributeType\AttributeTypeInterface;
use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ColorAttributeConfigurationType implements AttributeTypeInterface
{
    public function getStorageType(): string
    {
        return AttributeValueInterface::STORAGE_TEXT;
    }

    public function getType(): string
    {
        return 'color';
    }

    public function validate(
        AttributeValueInterface $attributeValue,
        ExecutionContextInterface $context,
        array $configuration
    ): void
    {
        if ($attributeValue->getValue() === null) {
            $context->buildViolation('Color could not be empty');
        }
    }
}
