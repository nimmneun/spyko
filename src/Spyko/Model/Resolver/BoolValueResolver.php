<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\Attribute;
use Spyko\Model\ArrayKey as Key;

class BoolValueResolver implements ValueResolverInterface
{
    public function get(array $attribute, string $attributeCode, $value)
    {
        return new Attribute($value[0][Key::DATA] ? 'true' : 'false');
    }
}