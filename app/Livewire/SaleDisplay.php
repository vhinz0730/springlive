<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Project;
use App\Models\Sale;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleDisplay extends Component
{
    public $page = '5';
    public $search='';
    use WithPagination;

        public function updatingSearch()
        {
            $this->resetPage();
        }

       
        public function render()
        {
            $sales = Sale::join('projects', 'sales.project_id', '=', 'projects.id')
                        ->join('users','projects.agent_id', '=', 'users.id')
                        ->where('projects.project_name', 'like', '%'.$this->search.'%')
                        ->orWhere('projects.industry', 'like', '%'.$this->search.'%')
                        ->orWhere('projects.id', 'like', '%'.$this->search.'%')
                        ->orWhere('users.name', 'like', '%'.$this->search.'%')
                        ->select('sales.project_id', 'users.name as name')
                        ->distinct('sales.project_id')
                        ->orderBy('sales.created_at', 'DESC')
                        ->paginate($this->page);
            $dups = Sale::select('*')
                            ->whereIn('project_id', function ($query) {$query->select('project_id')->from('sales')->groupBy('project_id');})->orderBy('created_at', 'DESC')->get();
       
            return view('livewire.sale-display', compact('sales','dups'));
        }
   

}
