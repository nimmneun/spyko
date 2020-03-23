<?php

namespace Spyko\Model\Resolver;

use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use Spyko\Model\Attribute;
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

    public function get(array $attribute, string $attributeCode, $value): array
    {
        $allLabels = [];
        foreach ($value as $item) {
            $option = $this->getValueCodeOption($attributeCode, $item[Key::DATA]);
            if ($item[Key::LOCALE]) {
                $allLabels[$item[Key::LOCALE]] = new Attribute($option[Key::LABELS][$item[Key::LOCALE]]);
            } else {
                foreach ($option[Key::LABELS] as $locale => $label) {
                    $allLabels[$locale] = new Attribute($label);
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