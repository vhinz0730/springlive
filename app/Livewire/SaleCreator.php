<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Sale;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;

class SaleCreator extends Component
{
    public $page="5";
    public $search='';
    public $sale_id;
    public $edit = false;
    public $project_name,$name,$payment_type,$paid_amount,$project_id,$webdev_renewaldate,$smm_renewaldate,$seo_renewaldate;
    use WithPagination;
    use Notifiable;

    public function render()
    {    
        $projects = Project::all();
        $payment_types = Payment::all();
        $users = User::all();
        $payments = Sale::join('projects', 'sales.project_id', '=', 'projects.id')
                        ->join('users','projects.agent_id', '=', 'users.id')
                        ->select('sales.id as sale_id', 'projects.project_name as project_name','sales.paid_amount as paid_amount')
                        ->where('projects.project_name', 'like', '%'.$this->search.'%')
                        ->orWhere('sales.id', 'like', '%'.$this->search.'%')
                        ->orderBy('sales.created_at', 'DESC')
                        ->paginate($this->page);
        return view('livewire.sale-creator', compact('payments','users','payment_types','projects'));
        
    }

    public function editsale($id)
    {
        $this->edit = true;
        $this->sale_id = $id;

        $payment = Sale::findOrFail($id);
        
        $this->sale_id = $id;
        $this->project_name = $payment-> project -> project_name;
        $this->name = $payment-> project -> agent -> name;
        $this ->payment_type =  $payment-> payment_type; 
        $this->paid_amount = $payment->paid_amount;
        
        $project = Project::findOrFail($payment->project_id);
        $this->webdev_renewaldate = $project->webdev_renewaldate;
        $this->seo_renewaldate = $project->seo_renewaldate;
        $this->smm_renewaldate = $project->smm_renewaldate;
       
    }

    public function deletesale($id)
    {
        
    $sale = Sale::findOrFail($id);

    $projectId = $sale->project_id;
    $paid_amount = $sale->paid_amount;

    $sale->delete();

    session()->flash('message', 'Sale deleted successfully!');

    $project = Project::findOrFail($projectId);
  
    $total_paid = $project->total_paid - $paid_amount;
    $balance = $project->balance + $paid_amount;

    Project::where('id', $projectId)->update([
        'total_paid' => $total_paid,
        'balance' => $balance
    ]);

    $body = 'Project Name: ' . ($sale->project->project_name ?? '') . 
            "\n" . 'Agent: ' . ($project->agent->name ?? '').
            "\n". 'Amount:' .($sale->paid_amount);
        $notification = new \MBarlow\Megaphone\Types\Important(
            'Delete Payment',
            $body, 
            '',
            ''
            );
                $users = User::where('role_id', 1)->get();
                foreach ($users as $user) {
                    $user->notify($notification);
                }
    }

    public function updateSale()
    {
        //update sale
        Sale::where('id', $this->sale_id)->update([
            'payment_type' => $this->payment_type,
            'paid_amount' => $this->paid_amount,
        ]);
       
        //find sale
        $sale = Sale::findOrFail($this->sale_id);
        $paid = DB::table('sales')
            ->where('project_id', $sale->project_id)
                ->whereNull('deleted_at')
                    ->get(); 
                        $total_paid = $paid->pluck('paid_amount')->sum();
        //total cost
        $total_cost = DB::table('projects')
            ->where('id', $sale->project_id)
                ->value('total_cost');
                
        //balance
        $balance = $total_cost - $total_paid;

        //update project
        Project::where('id', $sale->project_id)->update([
            'total_paid' => $total_paid,
            'balance' => $balance,
            'webdev_renewaldate' => $this->webdev_renewaldate,
            'seo_renewaldate' => $this->seo_renewaldate,
            'smm_renewaldate' => $this->smm_renewaldate,
        ]);
        $project = Project::where('id', $sale->project_id)->first();
        $body = 'Project Name: ' . ($project->project_name ?? '') . 
                "\n" . 'Agent: ' . ($project->agent->name ?? '').
                "\n". 'Amount:' .($this->paid_amount);
        if($this->payment_type == 'Renewal')
        {
        $notification = new \MBarlow\Megaphone\Types\Important(
            'Edit Renewal',
            $body, 
            '',
            ''
        );
        }
        else
        {
            $notification = new \MBarlow\Megaphone\Types\Important(
                'Edit Payment',
                $body, 
                '',
                ''
            );
        }
        $users = User::where('role_id', 1)->get();
        foreach ($users as $user) {
            $user->notify($notification);
        }
        session()->flash('message', 'Sale updated successfully!');
        $this->reset();
    }
    public function createPayment()
    {
        // Create a new payment record
        $sale = new Sale();
        $sale->project_id = $this->project_id;
        $sale->paid_amount = $this->paid_amount;
        $sale->payment_type = $this->payment_type;
        $sale->save();

        //total paid
        $paid = DB::table('sales')
            ->where('project_id', $this->project_id)
                ->whereNull('deleted_at')
                    ->get(); 
                        $total_paid = $paid->pluck('paid_amount')->sum();
        //total cost
        $total_cost = DB::table('projects')
            ->where('id', $this->project_id)
                ->value('total_cost');
                        
        //balance
        $balance = $total_cost - $total_paid;

        //update project
            $project = Project::where('id', $this->project_id)->update([
            'total_paid' => $total_paid,
            'balance' => $balance,
            'webdev_renewaldate' => $this->webdev_renewaldate,
            'seo_renewaldate' => $this->seo_renewaldate,
            'smm_renewaldate' => $this->smm_renewaldate,
        ]);
        $project = Project::where('id', $this->project_id)->first();
        $body = 'Project Name: ' . ($project->project_name ?? '') . 
                "\n" . 'Agent: ' . ($project->agent->name ?? '').
                "\n". 'Amount:' .($this->paid_amount);
        if($this->payment_type == 'Renewal')
        {
        $notification = new \MBarlow\Megaphone\Types\Important(
            'Renewal Update',
            $body, 
            '',
            ''
        );
        }
        else
        {
            $notification = new \MBarlow\Megaphone\Types\Important(
                'New Payment',
                $body, 
                '',
                ''
            );
        }
        $users = User::where('role_id', 1)->get();
        foreach ($users as $user) {
            $user->notify($notification);
        }
        $this->reset();
        session()->flash('message', 'Payment added successfully.');
        
    }

    public function showagent()
    {
        $project = Project::findOrFail($this->project_id);
        $this->name = $project -> agent -> name;
        $this -> payment_type = 'payment_type' ;
        $this -> paid_amount = 'paid_amount';
    }

    public function showdate()
    {
        $project = Project::findOrFail($this->project_id);
        $this->webdev_renewaldate = $project->webdev_renewaldate;
        $this->seo_renewaldate = $project->seo_renewaldate;
        $this->smm_renewaldate = $project->smm_renewaldate;  
    }
   
    public function resetpage()
    {
        $this->reset();
        session()->flash('message1', 'Form Reset!');
    }
    
}
