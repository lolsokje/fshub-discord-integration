<?php

declare(strict_types=1);

namespace App\Models\Discord\Embed;

final class EmbedField
{
    private string $title;

    private string $content;

    private bool $inline = false;

    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setInline(): self
    {
        $this->inline = true;

        return $this;
    }

    public function format(): array
    {
        $field = [
            'name' => $this->title,
            'value' => $this->content,
        ];

        if ($this->inline) {
            $field['inline'] = true;
        }

        return $field;
    }
}
