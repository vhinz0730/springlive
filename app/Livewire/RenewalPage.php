<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;

class RenewalPage extends Component
{
    
    use WithPagination;
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();


        $projects = Project::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('webdev_renewaldate', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('seo_renewaldate', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('smm_renewaldate', [$startOfMonth, $endOfMonth]);
        })->paginate(5);
        return view('livewire.renewal-page',compact('projects'));
    }
}
