<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function brand(): array
    {
        $brand = config('app.brand', []);
        $name = $brand['name'] ?? 'Nexus';
        $accent = $brand['accent'] ?? 'Market';
        $full = trim($name . $accent);

        return [
            'name' => $name,
            'accent' => $accent,
            'full' => $full,
            'tagline' => $brand['tagline'] ?? 'Level Up Your Inventory',
            'logo_icon' => $brand['logo_icon'] ?? 'sports_esports',
        ];
    }
}
