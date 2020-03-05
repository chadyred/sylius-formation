<?php

namespace spec\App\Form\Type;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;

class ColorAttributeTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractType::class);
    }

    function it_is_implemnts_initializable()
    {
        $this->shouldImplement(FormTypeInterface::class);
    }
}
