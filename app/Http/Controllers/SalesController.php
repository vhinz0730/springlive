<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySaleRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Sale;
use App\Models\User;
use App\Models\Payment;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    use MediaUploadingTrait;

  
    public function index(Request $request)
    {
        abort_if(Gate::denies('sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sales = Sale::with(['project', 'user', 'team', 'payment'])->select('project_id')->orderBy('id', 'DESC')->distinct('project_id')->paginate(5);
        $dups = Sale::with(['project', 'user', 'team', 'payment'])->select('*')->whereIn('project_id', function ($query) {$query->select('project_id')->from('sales')->groupBy('project_id');})->orderBy('id', 'DESC')->paginate(5);
       
        
        return view('sales.index', compact('sales','dups'));
    }

    public function create()
    {
        abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('project_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $payments = Payment::pluck('paid', 'id')->prepend(trans('global.pleaseSelect'), '');


        return view('sales.create', compact('projects', 'users','payments'));
    }
    //payment && sale
    public function store(Request $request)
    {
        $projects = Project::pluck('project_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $payments = Payment::pluck('paid', 'id')->prepend(trans('global.pleaseSelect'), '');
        

                $latestBalance = Project::where('id', $request->input('id'))->first()->balance;
           
                $payment = Payment::create([
                    'project_id' => $request->input('id'),
                    'paid' => $request->input('paid'),
                    'payment' => $request->input('payment')
                ]);
                        if($request->input('paid') > 0){
                            $sale = Sale::create([
                                'project_id' => $request->input('id'),
                                'payment_id' => $payment->id,
                                'paid' => $request->input('paid')
                                        ]);


                            DB::table('projects')
                                ->where('id', $request->input('id'))
                                    ->update
                                        ([
                                            'balance' =>  $latestBalance - $request->input('paid')
                                        ]);
                        }
                        session()->flash('message', 'Payment successfully updated.');
        return redirect()->route('projects.index');
    }

    public function edit(Sale $sale)
    {
        abort_if(Gate::denies('sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('project_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sale->load('project', 'user', 'team');

        return view('sales.edit', compact('projects', 'sale', 'users'));
    }

    public function update(Request $request)
    {
        $projects = Project::pluck('project_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $payments = Payment::pluck('paid', 'id')->prepend(trans('global.pleaseSelect'), '');

       
        //save && delete btn
        switch($request->input('action')){
            // save btn
            case 'save':  
                DB::table('payments')
                    ->where('id', $request->input('id'))
                        ->update
                            ([
                                'paid' => $request->input('paid')
                            ]);
                            
            break;
           // delete btn
            case 'delete':    
                DB::table('sales')
                    ->where('payment_id', $request->input('id'))
                        ->delete();
                DB::table('payments')
                    ->where('id', $request->input('id'))
                        ->delete();
                        
                break;        
            }
             //compute total paid
            $paid = DB::table('payments')
                    ->where('project_id', $request
                        ->input('project_id'))
                            ->get(); 
                            $total_paid = $paid->pluck('paid')->sum();
            //render total cost
            $total_cost = DB::table('projects')
                    ->where('id', $request->input('project_id'))
                        ->value('total_cost');
            //update balance        
                DB::table('projects')
                    ->where('id', $request->input('project_id'))
                        ->update
                            ([
                                'balance' => $total_cost - $total_paid
                            ]);
                            session()->flash('message', 'Payment updated.');

        return redirect()->route('sales.index');      
    }

    public function show(Sale $sale)
    {
        abort_if(Gate::denies('sale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale->load('project', 'user', 'team');

        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        abort_if(Gate::denies('sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale->delete();

        return back();
    }

    public function massDestroy(MassDestroySaleRequest $request)
    {
        $sales = Sale::find(request('ids'));

        foreach ($sales as $sale) {
            $sale->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('sale_create') && Gate::denies('sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Sale();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
