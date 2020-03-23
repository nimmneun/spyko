<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\AttributeValue;
use Spyko\Model\ArrayKey as Key;

class BoolValueResolver implements ValueResolverInterface
{
    public function resolve(array $attribute, array $value)
    {
        return new AttributeValue($value[0][Key::DATA] ? 'true' : 'false');
    }
}