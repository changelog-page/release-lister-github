<?php

declare(strict_types=1);

namespace Changelog\ReleaseLister\GitHub;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

final class Release extends DataTransferObject
{
    public array $data;

    #[MapFrom('id')]
    public string $uuid;

    #[MapFrom('tag_name')]
    public string $name;

    #[MapFrom('body')]
    public string $body;

    #[MapFrom('published_at')]
    public string $date;
}
