<?php

namespace Spyko\Model;

use Spyko\Model\Resolver\Resolver;
use Spyko\Model\Resolver\BoolValueResolver;
use Spyko\Model\Resolver\MetricValueResolver;
use Spyko\Model\Resolver\MultiSelectValueResolver;
use Spyko\Model\Resolver\NumberValueResolver;
use Spyko\Model\Resolver\PriceCollectionValueResolver;
use Spyko\Model\Resolver\SimpleSelectValueResolver;
use Spyko\Model\Resolver\TextValueResolver;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class AkeneoImporter
{
    /**
     * @var AkeneoPimClientInterface
     */
    private $client;

    /**
     * @var array
     */
    private $cache;

    public function __construct(AkeneoPimClientInterface $client)
    {
        $this->client = $client;
    }

    public function getProductImporter(): AkeneoProductImporter
    {
        return $this->cache[AkeneoProductImporter::class]
            ?? $this->cache[AkeneoProductImporter::class] = new AkeneoProductImporter(
                $this->client,
                $this->getAttributeResolver()
            );
    }

    public function getModelImporter(): AkeneoModelImporter
    {
        return $this->cache[AkeneoModelImporter::class]
            ?? $this->cache[AkeneoModelImporter::class] = new AkeneoModelImporter(
                $this->client,
                $this->getAttributeResolver()
            );
    }

    public function getAttributeResolver(): Resolver
    {
        return $this->cache[Resolver::class]
            ?? $this->cache[Resolver::class] = new Resolver(
                $this->client->getAttributeApi(),
                new TextValueResolver(),
                new BoolValueResolver(),
                new PriceCollectionValueResolver(),
                new MetricValueResolver(),
                new NumberValueResolver(),
                new MultiSelectValueResolver($this->client->getAttributeOptionApi()),
                new SimpleSelectValueResolver($this->client->getAttributeOptionApi())
            );
    }
}