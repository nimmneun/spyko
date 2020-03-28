<?php

namespace Spyko\Model\Resolver;

use Spyko\Model\ArrayKey as Key;
use Akeneo\Pim\ApiClient\Api\AttributeApiInterface;

class Resolver
{
    /**
     * @var array
     */
    private $cache = [];

    /**
     * @var AttributeApiInterface
     */
    private $attributeApi;

    /**
     * @var TextValueResolver
     */
    private $textResolver;

    /**
     * @var BoolValueResolver
     */
    private $boolResolver;

    /**
     * @var PriceCollectionValueResolver
     */
    private $priceResolver;

    /**
     * @var MetricValueResolver
     */
    private $metricResolver;

    /**
     * @var NumberValueResolver
     */
    private $numberResolver;

    /**
     * @var MultiSelectValueResolver
     */
    private $multiSelectResolver;

    /**
     * @var SimpleSelectValueResolver
     */
    private $simpleSelectResolver;

    public function __construct(
        AttributeApiInterface $attributeApi,
        TextValueResolver $textResolver,
        BoolValueResolver $boolResolver,
        PriceCollectionValueResolver $priceResolver,
        MetricValueResolver $metricResolver,
        NumberValueResolver $numberResolver,
        MultiSelectValueResolver $multiSelectResolver,
        SimpleSelectValueResolver $simpleSelectResolver
    ) {
        $this->attributeApi = $attributeApi;
        $this->textResolver = $textResolver;
        $this->boolResolver = $boolResolver;
        $this->priceResolver = $priceResolver;
        $this->metricResolver = $metricResolver;
        $this->numberResolver = $numberResolver;
        $this->multiSelectResolver = $multiSelectResolver;
        $this->simpleSelectResolver = $simpleSelectResolver;
    }

    public function resolve(array $attributes): array
    {
        foreach ($attributes as $code => $value) {
            $attribute = $this->getAttribute($code);
            $valueResolver = $this->getResolver($attribute[Key::TYPE]);
            $attributes[$code] = $valueResolver->resolve($attribute, $value);
        }

        ksort($attributes);

//        file_put_contents('output/attributes-' . date('Ymd-His') . '.json', json_encode($attributes, JSON_PRETTY_PRINT));

        return $attributes;
    }

    private function getResolver(string $attributeType): ValueResolverInterface
    {
        switch ($attributeType) {
            case 'pim_catalog_multiselect':
                return $this->multiSelectResolver;
            case 'pim_catalog_simpleselect':
                return $this->simpleSelectResolver;
            case 'pim_catalog_metric':
                return $this->metricResolver;
            case 'pim_catalog_number':
                return $this->numberResolver;
            case 'pim_catalog_price_collection':
                return $this->priceResolver;
            case 'pim_catalog_text':
            case 'pim_catalog_textarea':
                return $this->textResolver;
            case 'pim_catalog_boolean':
                return $this->boolResolver;
            default:
                throw new \Exception(sprintf("Attribute type [%s] not supported", $attributeType));
        }
    }

    private function getAttribute(string $code): array
    {
        return $this->cache[$code]
            ?? $this->cache[$code] = $this->attributeApi->get($code);
    }
}