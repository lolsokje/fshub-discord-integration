<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Discord\Embed\EmbedField;

interface HasDetailsEmbedField
{
    public function detailsEmbedField(): EmbedField;
}
