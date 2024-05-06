<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Payment;
use App\Models\Status;
use App\Models\Type;
use App\Models\Industry;
use App\Models\Project;
use App\Models\Sale;
use App\Models\Announcement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ProjectEditor extends Component
{   
    use WithPagination;
    public $search='';
    public $page='5';
    public $edit = false;
    public $project_id;
    public $project_name,$agent_id,$industry,$project_cost,$payment_type,$paid_amount,$status,$signup_date,$url,$webdev_type, $webdev_status, $staging,$wp_login,$password,$webdev_deadline,$webdev_launchdate,$webdev_renewaldate,$webdev_cost,$design_checklist,$staging_checklist,$host_domain_information,$seo_status,$seo_cost,$seo_deadline,$seo_launch_date,$seo_renewaldate,$smm_status,$smm_report,$social_media_email,$sim_card_number,$smm_deadline,$smm_launchdate,$smm_renewaldate,$smm_cost,$social_media_links,$vid_status,$vid_cost,$vid_launchdate,$vid_deadline,$graphics_status,$graphic_cost,$graphics_launchdate,$graphics_deadline,$clients_info,$webdev = '0',$seo ='0',$smm='0',$vid='0',$graphic='0',$team_id;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $payments= Payment::all();
        $users= User::all();
        $types= Type::all();
        $industries = Industry::all();
        $sales = Sale::all();
        $statuses = Status::all();

        //search and pagination
        $projects = Project::join('users', 'projects.agent_id', '=', 'users.id')
                    ->where('projects.project_name', 'like', '%'.$this->search.'%')
                    ->orWhere('projects.industry', 'like', '%'.$this->search.'%')
                    ->orWhere('users.name', 'like', '%'.$this->search.'%')
                    ->orWhere('projects.id', 'like', '%'.$this->search.'%')
                    ->select('projects.*', 'users.name as name')->orderBy('projects.id', 'DESC')->paginate($this->page);
        return view('livewire.project-editor', compact('users', 'payments', 'projects', 'statuses', 'types', 'sales', 'industries'));
    }
    public function updateProject()
    {
        //total cost
        $total_cost = $this->project_cost + 
                        $this->webdev_cost + 
                        $this->seo_cost + 
                        $this->smm_cost + 
                        $this->vid_cost + 
                        $this->graphic_cost;
        //total paid
        $paid = DB::table('sales')
            ->where('project_id', $this->project_id)
                ->whereNull('deleted_at')
                    ->get(); 
                        $total_paid = $paid->pluck('paid_amount')->sum();
        //balance
        $balance = $total_cost - $total_paid;

        //update project
        Project::where('id', $this->project_id)->update([
            'project_name' => $this->project_name,
            'project_cost' => $this->project_cost,
            'agent_id' => $this->agent_id,
            'industry' => $this->industry,
            'status' => $this->status,
            'signup_date' => $this->signup_date,
            'url' => $this->url,
            'webdev_type' => $this->webdev_type,
            'webdev_status' => $this->webdev_status,
            'staging' => $this->staging,
            'wp_login' => $this->wp_login,
            'password' => $this->password,
            'webdev_deadline' => $this->webdev_deadline,
            'webdev_launchdate' => $this->webdev_launchdate,
            'webdev_renewaldate' => $this->webdev_renewaldate,
            'webdev_cost' => $this->webdev_cost,
            'design_checklist' => $this->design_checklist,
            'staging_checklist' => $this->staging_checklist,
            'host_domain_information' => $this->host_domain_information,
            'seo_status' => $this->seo_status,
            'seo_cost' => $this->seo_cost,
            'seo_deadline' => $this->seo_deadline,
            'seo_launch_date' => $this->seo_launch_date,
            'seo_renewaldate' => $this->seo_renewaldate,
            'smm_status' => $this->smm_status,
            'smm_report' => $this->smm_report,
            'smm_deadline' => $this->smm_deadline,
            'smm_launchdate' => $this->smm_launchdate,
            'smm_renewaldate' => $this->smm_renewaldate,
            'smm_cost' => $this->smm_cost,
            'social_media_links' => $this->social_media_links,
            'vid_status' => $this->vid_status,
            'vid_cost' => $this->vid_cost,
            'vid_launchdate' => $this->vid_launchdate,
            'vid_deadline' => $this->vid_deadline,
            'graphics_status' => $this->graphics_status,
            'graphic_cost' => $this->graphic_cost,
            'graphics_launchdate' => $this->graphics_launchdate,
            'graphics_deadline' => $this->graphics_deadline,
            'clients_info' => $this->clients_info,
            'webdev' => $this->webdev,
            'seo' => $this->seo,
            'smm' => $this->smm,
            'vid' => $this->vid,
            'graphic' => $this->graphic,
            'team_id' => $this->team_id,
            'total_cost' => $total_cost,
            'balance' => $balance,
        ]);
        $project = Project::where('id', $this->project_id)->first();

        $body = 'Project Name: ' . ($project->project_name ?? '') . 
                "\n" . 'Agent: ' . ($project->agent->name ?? '') .
                "\n" . 'Industry: ' . ($project->industry ?? '');
        
        $notification = new \MBarlow\Megaphone\Types\Important(
            'Edit Project',
            $body, 
            '',
            ''
            );
                $users = User::where('role_id', 1)->get();
                foreach ($users as $user) {
                    $user->notify($notification);
                }
        
            session()->flash('message', 'Project updated successfully!');
            $this->reset();
    }


    public function editpro($id)
    {
       
        $this->edit = true;
        $this->project_id = $id;

        // Find the project by its ID
        $project = Project::findOrFail($id);

        // display info
        $this->project_id = $id;
        $this->project_name = $project->project_name;
        $this->project_cost = $project->project_cost;
        $this -> agent_id = $project->agent_id; 
        $this->industry = $project->industry;
        $this->status = $project->status;
        $this->signup_date = $project->signup_date;
        $this->url = $project->url;
        $this->webdev_type = $project->webdev_type;
        $this->webdev_status = $project->webdev_status;
        $this->staging = $project->staging;
        $this->wp_login = $project->wp_login;
        $this->password = $project->password;
        $this->webdev_deadline = $project->webdev_deadline;
        $this->webdev_launchdate = $project->webdev_launchdate;
        $this->webdev_renewaldate = $project->webdev_renewaldate;
        $this->webdev_cost = $project->webdev_cost;
        $this->design_checklist = $project->design_checklist;
        $this->staging_checklist = $project->staging_checklist;
        $this->host_domain_information = $project->host_domain_information;
        $this->seo_status = $project->seo_status;
        $this->seo_cost = $project->seo_cost;
        $this->seo_deadline = $project->seo_deadline ;
        $this->seo_launch_date = $project->seo_launch_date;
        $this->seo_renewaldate = $project->seo_renewaldate;
        $this->smm_status = $project->smm_status;
        $this->smm_report = $project->smm_report;
        $this->smm_deadline = $project->smm_deadline;
        $this->smm_launchdate = $project->smm_launchdate;
        $this->smm_renewaldate = $project->smm_renewaldate;
        $this->smm_cost = $project->smm_cost;
        $this->social_media_links = $project->social_media_links;
        $this->vid_status = $project->vid_status;
        $this->vid_cost = $project->vid_cost;
        $this->vid_launchdate = $project->vid_launchdate;
        $this->vid_deadline = $project->vid_deadline;
        $this->graphics_status = $project->graphics_status;
        $this->graphic_cost = $project->graphic_cost;
        $this->graphics_launchdate = $project->graphics_launchdate;
        $this->graphics_deadline = $project->graphics_deadline;
        $this->clients_info = $project->clients_info;
        $this->webdev = $project->webdev;
        $this->seo = $project->seo;
        $this->smm = $project->smm;
        $this->vid = $project->vid;
        $this->graphic = $project->graphic;
        $this->team_id = $project->team_id;
    }
    public function deletepro($id)
    {
        $this -> project_id = $id;
        
           
        $project = Project::where('id', $this->project_id)->first();

        $body = 'Project Name: ' . ($project->project_name ?? '') . 
                "\n" . 'Agent: ' . ($project->agent->name ?? '') .
                "\n" . 'Industry: ' . ($project->industry ?? '');
        
        $notification = new \MBarlow\Megaphone\Types\Important(
            'Delete Project',
            $body, 
            '',
            ''
            );
                $users = User::where('role_id', 1)->get();
                foreach ($users as $user) {
                    $user->notify($notification);
                }

        $project = Project::where('id', $this->project_id)->delete();
        session()->flash('message', 'Project deleted successfully!');
        $this->reset();
    
    }
    
    public function createProject()
    {
   
        $total_cost = $this->project_cost + 
                        $this->webdev_cost + 
                        $this->seo_cost + 
                        $this->smm_cost + 
                        $this->vid_cost + 
                        $this->graphic_cost;

        $balance = $total_cost - $this->paid_amount;

        
                $validatedData = Validator::make($this->all(), [
                    'project_name'  => 'required|string|max:255',
                    'agent_id'      => 'required|exists:users,id',
                    'project_cost'  => 'required',      
                    'payment_type'  => 'required'  
                
                ])->validate();
        


                    $project = new Project();
                    $project->project_name = ucwords($validatedData['project_name']);
                    $project->project_cost = $this->project_cost;
                    $project->agent_id = $validatedData['agent_id'];
                    $project->industry = $this->industry;
                    $project->status = $this->status;
                    $project->signup_date = $this->signup_date;
                    $project->url = $this->url;
                    $project->webdev_type = $this->webdev_type;
                    $project->webdev_status = $this->webdev_status;
                    $project->staging = $this->staging;
                    $project->wp_login = $this->wp_login;
                    $project->password = $this->password;
                    $project->webdev_deadline = $this->webdev_deadline;
                    $project->webdev_launchdate = $this->webdev_launchdate;
                    $project->webdev_launchdate = $this->webdev_launchdate;
                    $project->webdev_renewaldate = $this->webdev_renewaldate;
                    $project->webdev_cost = $this->webdev_cost;
                    $project->design_checklist = $this->design_checklist;
                    $project->staging_checklist = $this->staging_checklist;
                    $project->host_domain_information = $this->host_domain_information;
                    $project->seo_status = $this->seo_status;
                    $project->seo_cost = $this->seo_cost;
                    $project->seo_deadline = $this->seo_deadline;
                    $project->seo_launch_date = $this->seo_launch_date;
                    $project->seo_renewaldate = $this->seo_renewaldate;
                    $project->smm_status = $this->smm_status;
                    $project->smm_report = $this->smm_report;
                    $project->smm_deadline = $this->smm_deadline;
                    $project->smm_launchdate = $this->smm_launchdate;
                    $project->smm_renewaldate = $this->smm_renewaldate;
                    $project->smm_cost = $this->smm_cost;
                    $project->social_media_links = $this->social_media_links;
                    $project->vid_status = $this->vid_status;
                    $project->vid_cost = $this->vid_cost;
                    $project->vid_launchdate = $this->vid_launchdate;
                    $project->vid_deadline = $this->vid_deadline;
                    $project->graphics_status = $this->graphics_status;
                    $project->graphic_cost = $this->graphic_cost;
                    $project->graphics_launchdate = $this->graphics_launchdate;
                    $project->graphics_deadline = $this->graphics_deadline;
                    $project->clients_info = $this->clients_info;
                    $project->webdev = $this->webdev;
                    $project->seo = $this->seo;
                    $project->smm = $this->smm;
                    $project->vid = $this->vid;
                    $project->graphic = $this->graphic;
                    $project->team_id = $this->team_id;
                    $project->total_cost = $total_cost;
                    $project->balance = $balance;
                    $project->total_paid = $this->paid_amount;
                    $project->save();

                            if($this->paid_amount){
                                $sale = new Sale();
                                $sale->payment_type = $this->payment_type;
                                $sale->paid_amount = $this->paid_amount;
                                $sale->project_id = $project->id;
                                $sale->save();   
                            }
                            
        $project = Project::where('id', $project->id)->first();

        $body = 'Project Name: ' . ($project->project_name ?? '') . 
                "\n" . 'Agent: ' . ($project->agent->name ?? '') .
                "\n" . 'Industry: ' . ($project->industry ?? '');
        
        $notification = new \MBarlow\Megaphone\Types\Important(
            'Create Project',
            $body, 
            '',
            ''
            );
                $users = User::all();
                foreach ($users as $user) {
                    $user->notify($notification);
                }

                $announcement = new Announcement();
                        $announcement -> title = "New Project";
                        $announcement -> body = ucwords($validatedData['project_name']);
                        $announcement -> agent = $project->agent->name;
                        $announcement->save();
       
        session()->flash('message', 'Project created successfully!');
        $this->reset();
    }
    public function repage()
    {
        session()->flash('message1', 'Page Reset!');
        $this->reset();
    }
}


