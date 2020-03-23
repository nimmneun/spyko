<?php

namespace Spyko\Model;

use Spyko\Model\Resolver\Resolver;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class AkeneoModelImporter
{
    /**
     * @var AkeneoPimClientInterface
     */
    private $client;

    /**
     * @var Resolver
     */
    private $translator;

    public function __construct(
        AkeneoPimClientInterface $client,
        Resolver $translator
    ) {
        $this->client = $client;
        $this->translator = $translator;
    }

    public function importOne(string $sku): void
    {
        $product = $this->client->getProductModelApi()->get($sku);
        $filteredValues = $product['values']; // can we even filter b4?
        $attributes = $this->translator->resolve($filteredValues);
    }

    public function importMany(array $skus): void
    {
        foreach ($skus as $sku) {
            $this->importOne($sku);
        }
    }
}