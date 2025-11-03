<?php

namespace App\View\Components;

use App\Services\AdDisplayService;
use Illuminate\View\Component;

class AdSlot extends Component
{
    public $ad;
    public $position;
    public $rotation;
    public $interval;

    public function __construct(
        string $position,
        array $context = [],
        bool $rotation = false,
        int $interval = 15000
    ) {
        $this->position = $position;
        $this->rotation = $rotation;
        $this->interval = $interval;

        $service = app(AdDisplayService::class);
        $this->ad = $service->getAdForPlacement($position, $context);

        if ($this->ad) {
            $service->recordImpression($this->ad);
        }
    }

    public function render()
    {
        return view('components.ad-slot');
    }
}
