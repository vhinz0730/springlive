<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;
use App\Models\Project;

class NextPage extends Component
{
    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $startOfMonth = now()->addMonth()->startOfMonth();
        $endOfMonth = now()->addMonth()->endOfMonth();


        $projects = Project::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('webdev_renewaldate', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('seo_renewaldate', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('smm_renewaldate', [$startOfMonth, $endOfMonth]);
        })->paginate(5);
      
        return view('livewire.next-page',compact('projects'));
    }
}
