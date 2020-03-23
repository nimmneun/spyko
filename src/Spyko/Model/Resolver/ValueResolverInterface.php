<?php

namespace Spyko\Model\Resolver;

interface ValueResolverInterface
{
    /**
     * @param array $attribute
     * @param string $attributeCode
     * @param mixed $value
     * @return mixed
     */
    public function get(array $attribute, string $attributeCode, $value);
}