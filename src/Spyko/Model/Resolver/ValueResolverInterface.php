<?php

namespace Spyko\Model\Resolver;

interface ValueResolverInterface
{
    /**
     * @param array $attribute
     * @param array $value
     * @return mixed
     */
    public function resolve(array $attribute, array $value);
}