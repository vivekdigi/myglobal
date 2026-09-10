<?php

namespace App\Traits;

use App\Models\Theme;

trait TemplateTrait
{
    public function theme(): string
    {
        $theme = Theme::where('active', true)->select(['name'])->first();
        return $theme->name;
    }
}
