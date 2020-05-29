<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class Releases extends Component
{
    public array $releases;

    protected $listeners = ['itemsUpdated'];

    /**
     * @param array $releases
     */
    public function mount(array $releases)
    {
        $this->releases = $releases;
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.releases');
    }

    /**
     * @param array $items
     * @return array
     */
    public function itemsUpdated(array $items): array
    {
        return $this->releases = $items;
    }
}
