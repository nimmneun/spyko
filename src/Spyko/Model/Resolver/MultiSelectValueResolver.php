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
        $results = [];
        foreach ($value as $item) {
            foreach ($item[Key::DATA] as $valueCode) {
                $labels = $this->getValueCodeLabels($attribute[Key::CODE], $valueCode);
                foreach ($labels as $locale => $label) {
                    // todo: not yet sure how to handle multiple multiSelect values
                    if (isset($results[$locale])) {
                        $results[$locale] = new AttributeValue($results[$locale] . ',' . $label, $valueCode);
                    } else {
                        $results[$locale] = new AttributeValue($label, $valueCode);
                    }
                }
            }
        }

        return $results;
    }

    private function getValueCodeLabels(string $attributeCode, $valueCode): array
    {
        if (!isset($this->cache[$attributeCode][$valueCode])) {
            $option = $this->attributeOptionApi->get($attributeCode, $valueCode);
            $this->cache[$attributeCode][$valueCode] = $option[Key::LABELS];
        }

        return $this->cache[$attributeCode][$valueCode];
    }
}