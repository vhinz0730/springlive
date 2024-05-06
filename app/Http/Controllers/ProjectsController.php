<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Industry;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\User;
use App\Models\Sale;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Livewire\Component;

class ProjectsController extends Controller
{
    use MediaUploadingTrait;
    public $search;
    public function index()
    {
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $industries = Industry::pluck('industry', 'id');
        $agents = User::pluck('name', 'id');
        $payments = Payment::pluck('paid', 'id');
      if(!$this->search){
        $projects = Project::with(['industry', 'agent', 'team'])->orderBy('id', 'DESC')->paginate(10);
      }
        else{
        $projects = Project::where('project_name','like','%'.$this->search.'%')
                          ->orWhere('industry','like','%'.$this->search.'%')
                          ->paginate(10);
        }
        
        return view('projects.index', compact('projects', 'agents', 'industries','payments'));
    }

    public function all()
    {
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $projects = Project::with(['industry', 'agent', 'team'])->orderBy('id', 'DESC')->paginate(20);

        return view('projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('project_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $industries = Industry::pluck('industry', 'id');
        $agents = User::pluck('name', 'id');
        $payments = Payment::pluck('paid', 'id');
     
        
        return view('projects.create', compact('agents', 'industries','payments'));
    }

    public function store(Request $request)
    {  
        $industries = Industry::pluck('industry', 'id');
        $agents = User::pluck('name', 'id');
        $payments = Payment::pluck('paid', 'id');
        $total_cost = $request->webdev_cost + $request->seo_cost + $request->smm_cost + $request->vid_cost + $request->graphic_cost + $request->project_cost;
        $balance = $total_cost - $request->input('paid');
        
        $project = Project::create([
          //general
            'agent_id' => $request->input('agent_id'),
            'project_name' =>$request->input('project_name'),
            'project_cost' => $request->input('project_cost'),
            'industry_id' => $request->input('industry_id'),
            'payment' => $request->input('payment'),
            'signup_date' =>$request->input('signup_date'),
            'status' => $request->input('status'),
          //webdev
            'url' => $request->input('url'),
            'webdev_type' => $request->input('webdev_type'),
            'webdev_status' => $request->input('webdev_status'),
            'staging' => $request->input('staging'),
            'wp_login' => $request->input('wp_login'),
            'password' => $request->input('password'),
            'webdev_deadline' => $request->input('webdev_deadline'),
            'webdev_launchdate' => $request->input('webdev_launchdate'),
            'webdev_renewaldate' => $request->input('webdev_renewaldate'),
            'design_checklist'    =>$request->input('design_checklist'),
            'staging_checklist'   =>$request->input('staging_checklist'),
            'host_domain_information'   =>$request->input('host_domain_information'),
          //seo
            'seo_status' => $request->input('seo_status'),
            'seo_deadline' => $request->input('seo_deadline'),
            'seo_launch_date' => $request->input('seo_launch_date'),
            'seo_renewaldate' => $request->input('seo_renewaldate'),
          //smm
            'smm_status' => $request->input('smm_status'),
            'smm_report' => $request->input('smm_report'),
            'social_media_email' => $request->input('social_media_email'),
            'sim_card_number' => $request->input('sim_card_number'),
            'smm_deadline' => $request->input('smm_deadline'),
            'smm_launchdate' => $request->input('smm_launchdate'),
            'smm_renewaldate' => $request->input('smm_renewaldate'),
            'social_media_links' => $request->input('social_media_links'),
          //video
            'vid_status' => $request->input('vid_status'),
            'vid_launchdate' => $request->input('vid_launchdate'),
            'vid_deadline' => $request->input('vid_deadline'),
          //graphics
            'graphics_status' => $request->input('graphics_status'),
            'graphics_launchdate' => $request->input('graphics_launchdate'),
            'graphics_deadline' => $request->input('graphics_deadline'),
          //client
            'clients_info' => $request->input('clients_info'),
          //services
            'webdev' => $request->input('webdev'),
            'seo' => $request->input('seo'),
            'smm' => $request->input('smm'),
            'vid' => $request->input('vid'),
            'graphic' => $request->input('graphic'),
          //cost and balance
            'webdev_cost' => $request->input('webdev_cost'),
            'seo_cost' => $request->input('seo_cost'),
            'smm_cost' => $request->input('smm_cost'),
            'vid_cost' => $request->input('vid_cost'),
            'graphic_cost' => $request->input('graphic_cost'),
            'total_cost' => $total_cost,
            'balance' => $balance

         ]);
        if($project->payment == "No Pay"){
         $payment = Payment::create([
            'project_id' => $project->id,
            'payment' => $project->payment
          ]);
         }
          if($project->payment != "No Pay"){
            $payment = Payment::create([
              'project_id' => $project->id,
              'payment' => $project->payment,
              'paid' => $request->input('paid'),
              
            ]);
            $sale = Sale::create([
            'project_id' => $project->id,
            'payment_id' => $payment->id
          ]);
        }
        session()->flash('message', 'Project successfully created.');
          return redirect()->route('projects.create', compact('agents', 'industries','payments')); 
    }
  
    public function edit(Project $project)
    {
        abort_if(Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $industries = Industry::pluck('industry', 'id');

        $agents = User::pluck('name', 'id');

        $payments = Payment::pluck('paid', 'id');

        $project->load('industry', 'agent', 'team','payment');

        return view('admin.projects.edit', compact('agents', 'industries', 'project','payments'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        return redirect()->route('admin.projects.index');
    }

    public function webdev(){
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::with(['industry', 'agent', 'team'])->where('webdev', "1")->orderBy('id', 'DESC')->paginate(20);

        return view('projects.index', compact('projects'));
        
    }

    public function seo(){
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::with(['industry', 'agent', 'team'])->where('seo', "1")->orderBy('id', 'DESC')->paginate(20);

        return view('projects.index', compact('projects'));
        
    }
    
    public function smm(){
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::with(['industry', 'agent', 'team'])->where('smm', "1")->orderBy('id', 'DESC')->paginate(20);

        return view('projects.index', compact('projects'));
        
    }

    public function vid(){
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::with(['industry', 'agent', 'team'])->where('vid', "1")->orderBy('id', 'DESC')->paginate(20);

        return view('projects.index', compact('projects'));
        
    }

    public function graphic(){
        abort_if(Gate::denies('project_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::with(['industry', 'agent', 'team'])->where('graphic', "1")->orderBy('id', 'DESC')->paginate(20);

        return view('projects.index', compact('projects'));
        
    }

  

    public function show(Project $project)
    {
        abort_if(Gate::denies('project_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->load('industry', 'agent', 'team', 'projectLayouts');

        return view('projects.show', compact('project'));
    }

    public function destroy(Project $project)
    {
        abort_if(Gate::denies('project_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->delete();

        return back();
    }

    public function massDestroy(MassDestroyProjectRequest $request)
    {
        $projects = Project::find(request('ids'));

        foreach ($projects as $project) {
            $project->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('project_create') && Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Project();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
   


}
