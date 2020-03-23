<?php

namespace Spyko\Model;

use Spyko\Model\Resolver\Resolver;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class AkeneoProductImporter
{
    /**
     * @var AkeneoPimClientInterface
     */
    private $client;

    /**
     * @var Resolver
     */
    private $resolver;

    public function __construct(
        AkeneoPimClientInterface $client,
        Resolver $resolver
    ) {
        $this->client = $client;
        $this->resolver = $resolver;
    }

    public function importOne(array $payload): void
    {
        // most annoying part, so lets try to get this done first
        $akeneoAttributes = $this->resolver->resolve($payload['values']);
        $attributes = array_filter($akeneoAttributes, 'is_object');
        $localizedAttributes = array_filter($akeneoAttributes, 'is_array');
    }

    public function importOneBySku(string $sku): void
    {
        $this->importOne($this->client->getProductApi()->get($sku));
    }

    public function importManyBySku(array $skus): void
    {
        foreach ($skus as $sku) {
            $this->importOneBySku($sku);
        }
    }

    public function importAll(): void
    {
        foreach ($this->client->getProductApi()->all() as $product) {
            $this->importOne($product);
        }
    }
}