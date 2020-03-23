<?php

namespace Spyko\Model\Resolver;

use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use Spyko\Model\AttributeValue;
use Spyko\Model\ArrayKey as Key;

class MultiSelectValueResolver implements ValueResolverInterface
{
    /**
     * @var AttributeOptionApiInterface
     */
    private $attributeOptionApi;

    /**
     * @var array ['attributeCode']['valueCode']
     */
    private $cache = [];

    public function __construct(AttributeOptionApiInterface $attributeOptionApi)
    {
        $this->attributeOptionApi = $attributeOptionApi;
    }

    public function resolve(array $attribute, array $value)
    {
        $allLabels = [];
        foreach ($value as $item) {
            foreach ($item[Key::DATA] as $valueCode) {
                $option = $this->getValueCodeOption($attribute[Key::CODE], $valueCode);
                foreach ($option[Key::LABELS] as $locale => $label) {
                    if (isset($allLabels[$locale])) {
                        $allLabels[$locale] = new AttributeValue($allLabels[$locale] . ",$label");
                    } else {
                        $allLabels[$locale] = new AttributeValue($label);
                    }
                }
            }
        }

        return $allLabels;
    }

    private function getValueCodeOption(string $attributeCode, $valueCode): array
    {
        if (!isset($this->cache[$attributeCode][$valueCode])) {
            $option = $this->attributeOptionApi->get($attributeCode, $valueCode);
            $this->cache[$attributeCode][$valueCode] = $option;
        }

        return $this->cache[$attributeCode][$valueCode];
    }
}