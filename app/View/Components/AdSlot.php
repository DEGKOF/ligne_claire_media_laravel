<?php

namespace App\View\Components;

use App\Services\AdDisplayService;
use Illuminate\View\Component;

class AdSlot extends Component
{
    public $ad;
    public $position;
    public $fallback;

    public function __construct(
        string $position,
        ?string $fallback = null,
        array $context = []
    ) {
        $this->position = $position;
        $this->fallback = $fallback;

        $service = app(AdDisplayService::class);
        $this->ad = $service->getAdForPlacement($position, $context);

        // Enregistrer l'impression si pub trouvée
        if ($this->ad) {
            $service->recordImpression($this->ad);
        }
    }

    public function render()
    {
        return view('components.ad-slot');
    }
}
