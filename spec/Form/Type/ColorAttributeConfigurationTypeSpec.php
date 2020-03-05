<?php

namespace spec\App\Form\Type;

use App\Form\Type\ColorAttributeType;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Attribute\AttributeType\AttributeTypeInterface;
use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ColorAttributeConfigurationTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AttributeTypeInterface::class);
    }

    function it_is_implemnts_initializable()
    {
        $this->shouldImplement(AttributeTypeInterface::class);
    }

    function it_should_return_color_type()
    {
        $this->getType()->shouldReturn('color');
    }

    function it_should_return_storage_text_type()
    {
        $this->getStorageType()->shouldReturn(AttributeValueInterface::STORAGE_TEXT);
    }

    function it_should_unvalidate_color_type_as_value_is_empty(
        AttributeValueInterface $attributeValue,
        ExecutionContextInterface $contextObject
    ){
        // Given
        $attributeValue->getWrappedObject();
        $contextObject->getWrappedObject();
        $attributeValue->getValue()->willReturn(null);

        // If
        $this->validate($attributeValue, $contextObject, []);

        // Then assertion
        $contextObject->buildViolation('Color could not be empty')->shouldBeCalledOnce();
    }

    function it_should_not_unvalidate_color_type_as_value_is_empty(
        AttributeValueInterface $attributeValue,
        ExecutionContextInterface $contextObject
    ){
        // Given
        $attributeValue->getWrappedObject();
        $contextObject->getWrappedObject();
        $attributeValue->getValue()->willReturn('qsd');

        // If
        $this->validate($attributeValue, $contextObject, []);

        // Then assertion
        $contextObject->buildViolation('Color could not be empty')->shouldNotBeCalled();
    }
}
