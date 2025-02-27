<?php

declare(strict_types=1);

namespace App\Models\Discord\Embed;

use App\Models\Color;

final class Embed
{
    private string $author;

    private string $authorIconUrl;

    private string $title;

    private string $description;

    private Color $color;

    /** @var array<EmbedField> */
    private array $fields = [];

    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function setAuthorIconUrl(string $authorIconUrl): self
    {
        $this->authorIconUrl = $authorIconUrl;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setColor(Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function addField(EmbedField $field): self
    {
        $this->fields[] = $field;

        return $this;
    }

    public function format(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'color' => $this->color->toDecimal(),
            'author' => [
                'name' => $this->author,
                'icon_url' => $this->authorIconUrl,
            ],
            'fields' => array_map(fn (EmbedField $field) => $field->format(), $this->fields),
        ];
    }
}
