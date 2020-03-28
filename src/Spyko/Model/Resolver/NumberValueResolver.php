<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\AttributeValue;
use Spyko\Model\ArrayKey as Key;

class NumberValueResolver implements ValueResolverInterface
{
    public function resolve(array $attribute, array $value)
    {
        $results = [];
        foreach ($value as $item) {
            $realValue = (string)(float)$item[Key::DATA];
            if (isset($item[Key::LOCALE])) {
                $results[$item[Key::LOCALE]] = new AttributeValue($realValue);
            } else {
                $results = new AttributeValue($realValue);
            }
        }

        return $results;
    }
}