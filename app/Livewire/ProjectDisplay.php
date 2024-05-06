<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Payment;
use App\Models\Status;
use App\Models\Type;
use App\Models\Industry;
use App\Models\Project;
use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProjectDisplay extends Component
{
    use WithPagination;
    
    public $payment_type, $paid_amount, $project_id;
    public $search='';
    public $page='5';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
       $payments= Payment::all();
       $projects = Project::join('users', 'projects.agent_id', '=', 'users.id')
                    ->where('projects.project_name', 'like', '%'.$this->search.'%')
                    ->orWhere('projects.industry', 'like', '%'.$this->search.'%')
                    ->orWhere('users.name', 'like', '%'.$this->search.'%')
                    ->orWhere('projects.id', 'like', '%'.$this->search.'%')
                    ->select('projects.*', 'users.name as name')->orderBy('projects.id', 'DESC')->paginate($this->page);
        return view('livewire.project-display',compact('payments', 'projects'));
    }

    public function payslip()
    { 
        $sale = new Sale();
        $sale->project_id = $this->project_id;
        $sale->payment_type = $this->payment_type;
        $sale->paid_amount = $this->paid_amount;
        $sale->save();

        //compute total paid
        $paid = DB::table('sales')
        ->where('project_id', $this->project_id)
            ->get(); 
                $total_paid = $paid->pluck('paid_amount')->sum();

        //render total cost
        $total_cost = DB::table('projects')
                ->where('id', $this->project_id)
                    ->value('total_cost');
            
        //update balance        
            DB::table('projects')
                ->where('id', $this->project_id)
                    ->update
                        ([
                            'total_paid' => $total_paid,
                            'balance' => $total_cost - $total_paid
                        ]);
            $this->reset();
    }
    public function pid($id)
    {
        $this-> project_id = $id;
    }
}