<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\AttributeValue;
use Spyko\Model\ArrayKey as Key;

class MetricValueResolver implements ValueResolverInterface
{
    public function resolve(array $attribute, array $value)
    {
        return new AttributeValue((string)(float)$value[0][Key::DATA][Key::AMOUNT]);
    }
}