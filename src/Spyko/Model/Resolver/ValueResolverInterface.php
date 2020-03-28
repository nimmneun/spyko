<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\AttributeValue;

interface ValueResolverInterface
{
    /**
     * @param array $attribute
     * @param array $value
     * @return AttributeValue|AttributeValue[]
     */
    public function resolve(array $attribute, array $value);
}