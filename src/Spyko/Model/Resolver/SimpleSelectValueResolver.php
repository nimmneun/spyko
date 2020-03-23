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
            $option = $this->getValueCodeOption($attribute[Key::CODE], $item[Key::DATA]);
            $attributeValueCode = $item[Key::DATA];
            if ($item[Key::LOCALE]) {
                $attributeValue = $option[Key::LABELS][$item[Key::LOCALE]];
                $allLabels[$item[Key::LOCALE]] = new AttributeValue($attributeValue, $attributeValueCode);
            } else {
                foreach ($option[Key::LABELS] as $locale => $label) {
                    $allLabels[$locale] = new AttributeValue($label, $attributeValueCode);
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