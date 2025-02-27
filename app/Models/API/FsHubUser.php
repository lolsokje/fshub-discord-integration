<?php

declare(strict_types=1);

namespace App\Models\API;

final readonly class FsHubUser
{
    public function __construct(
        public int $id,
        public string $name,
        public string $avatarUrl,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            id: $content['id'],
            name: $content['name'],
            avatarUrl: $content['profile']['avatar_url'],
        );
    }
}
