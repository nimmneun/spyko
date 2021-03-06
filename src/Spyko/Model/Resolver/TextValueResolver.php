<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\AttributeValue;
use Spyko\Model\ArrayKey as Key;

class TextValueResolver implements ValueResolverInterface
{
    public function resolve(array $attribute, array $value)
    {
        $allValues = [];
        foreach ($value as $item) {
            if (isset($item[Key::LOCALE])) {
                $allValues[$item[Key::LOCALE]] = new AttributeValue($item[Key::DATA]);
            } else {
                return new AttributeValue($item[Key::DATA]);
            }

        }

        return $allValues;
    }
}