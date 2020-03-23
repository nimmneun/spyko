<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\Attribute;
use Spyko\Model\ArrayKey as Key;

class PriceCollectionValueResolver implements ValueResolverInterface
{
    public function get(array $attribute, string $attributeCode, $value)
    {
        return new Attribute((string)(float)$value[0][Key::DATA][0][Key::AMOUNT]);
    }
}