<?php

namespace App\Http\Livewire;

use App\Services\DiscogsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class Pagination extends Component
{
    public array $pagination;
    public int $start;
    public int $offset;

    /**
     * @param array $pagination
     */
    public function mount(array $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $this->start = ($this->currentPage() * $this->perPage()) - $this->perPage() + 1;
        $this->offset = $this->currentPage() * $this->perPage();

        return view('livewire.pagination');
    }

    public function getPage($next = false)
    {
        $page = $next ? $this->currentPage() + 1 : $this->currentPage() - 1;
        $username = auth()->user()->discogs_username;

        $collection = (new DiscogsService())->getCollection($username, $page);

        $this->pagination = $collection['pagination'];

        $this->emitTo('releases', 'itemsUpdated', $collection['releases']);
    }

    /**
     * @return float|int|mixed
     */
    public function getStartProperty()
    {
        return ($this->currentPage() * $this->perPage()) - $this->perPage();
    }

    /**
     * @return float|int
     */
    public function getOffsetProperty()
    {
        return ($this->currentPage() - 1) * $this->perPage();
    }

    /**
     * @return mixed
     */
    public function currentPage()
    {
        return $this->pagination['page'];
    }

    /**
     * @return mixed
     */
    public function pageCount()
    {
        return $this->pagination['pages'];
    }

    /**
     * @return mixed
     */
    public function totalItems()
    {
        return $this->pagination['items'];
    }

    /**
     * @return mixed
     */
    public function perPage()
    {
        return $this->pagination['per_page'];
    }
}
