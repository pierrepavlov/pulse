<?php

namespace Laravel\Pulse\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Laravel\Pulse\Livewire\Concerns\ShouldNotReportUsage;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Queues extends Component
{
    use ShouldNotReportUsage;

    /**
     * The number of columns to span.
     */
    public int|string $cols = 3;

    /**
     * Render the component.
     */
    public function render(callable $query): Renderable
    {
        return View::make('pulse::livewire.queues', [
            'queues' => $queues = Cache::remember('laravel:pulse:queues:live', 5, fn () => $query()),
            'showConnection' => $queues->pluck('connection')->unique()->count() > 1,
        ]);
    }

    /**
     * Render the placeholder.
     */
    public function placeholder(): Renderable
    {
        return View::make('pulse::components.placeholder', ['cols' => $this->cols]);
    }
}
