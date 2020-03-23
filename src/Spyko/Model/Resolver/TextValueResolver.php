<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\Attribute;
use Spyko\Model\ArrayKey as Key;

class TextValueResolver implements ValueResolverInterface
{
    public function get(array $attribute, string $attributeCode, $value)
    {
        $allValues = [];
        foreach ($value as $item) {
            if (isset($item[Key::LOCALE])) {
                $allValues[$item[Key::LOCALE]] = new Attribute($item[Key::DATA]);
            } else {
                return new Attribute($item[Key::DATA]);
            }

        }

        return $allValues;
    }
}