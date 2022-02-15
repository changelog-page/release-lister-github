<?php

declare(strict_types=1);

namespace Changelog\ReleaseLister\GitHub;

use Changelog\Hydrator\HydratesResources;
use Changelog\ReleaseLister\Lister as Contract;
use Github\AuthMethod;
use Github\Client;
use Github\ResultPager;
use Illuminate\Support\Collection;

final class Lister implements Contract
{
    use HydratesResources;

    private Client $client;

    public function __construct(array $credentials)
    {
        $this->client = new Client();
        $this->client->authenticate($credentials['token'], null, AuthMethod::ACCESS_TOKEN);
    }

    public function byUser(string $uuid, ?array $options): Collection
    {
        return $this->by($uuid, $options);
    }

    public function byTeam(string $uuid, ?array $options): Collection
    {
        return $this->by($uuid, $options);
    }

    private function by(string $uuid, ?array $options): Collection
    {
        [$username, $repository] = explode('/', $uuid);

        return $this->hydrate(
            (new ResultPager($this->client))->fetchAll(
                $this->client->api('repo')->releases(),
                'all',
                [$username, $repository],
            ),
            Release::class,
        );
    }
}
