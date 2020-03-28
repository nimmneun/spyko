<?php

namespace Spyko\Model\Resolver;

use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use Spyko\Model\AttributeValue;
use Spyko\Model\ArrayKey as Key;

class SimpleSelectValueResolver implements ValueResolverInterface
{
    /**
     * @var AttributeOptionApiInterface
     */
    private $attributeOptionApi;

    /**
     * @var array [attributeCode][valueCode][locale]
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
            $labels = $this->getValueCodeLabels($attribute[Key::CODE], $item[Key::DATA]);
            $valueCode = $item[Key::DATA];
            if ($item[Key::LOCALE]) {
                $attributeValue = $labels[$item[Key::LOCALE]];
                $results[$item[Key::LOCALE]] = new AttributeValue($attributeValue, $valueCode);
            } else {
                foreach ($labels as $locale => $label) {
                    $results[$locale] = new AttributeValue($label, $valueCode);
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