<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\Attribute;
use Spyko\Model\ArrayKey as Key;

class NumberValueResolver implements ValueResolverInterface
{
    public function get(array $attribute, string $attributeCode, $value)
    {
        $values = [];
        foreach ($value as $item) {
            $realValue = (string)(float)$item[Key::DATA];
            if (isset($item[Key::LOCALE])) {
                $values[$item[Key::LOCALE]] = new Attribute($realValue);
            } else {
                $values = new Attribute($realValue);
            }
        }

        return $values;
    }
}