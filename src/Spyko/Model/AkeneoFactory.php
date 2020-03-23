<?php

namespace Spyko\Model;

use Akeneo\Pim\ApiClient\AkeneoPimClientBuilder;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class AkeneoFactory
{
    private $cache = [];

    public function createAkeneoImporter(): AkeneoImporter
    {
        return new AkeneoImporter($this->createAkeneoClient());
    }

    public function createAkeneoClient(): AkeneoPimClientInterface
    {
        $host = getenv('AKENEO_HOST');
        $clientId = getenv('AKENEO_CLIENT_ID');
        $secret = getenv('AKENEO_SECRET');
        $user = getenv('AKENEO_USERNAME');
        $pass = getenv('AKENEO_PASSWORD');

        return $this->cache[AkeneoPimClientInterface::class]
            ?? $this->cache[AkeneoPimClientInterface::class] = (new AkeneoPimClientBuilder($host))
                ->buildAuthenticatedByPassword($clientId, $secret, $user, $pass);
    }
}