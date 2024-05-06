<div>
    <style>
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }
          input[type=number] {
            -moz-appearance: textfield;
            }
    </style>
        <div class="w-full bg-transparent flex items-center justify-between">
            <div class="flex items-center mt-10">
                <x-input type="search" autofocus wire:model.live.debounce.1000ms="search" class="text-black bg-blue-300 border-3 border-blue-400 ml-20 mr-2 focus:animate-pulse" placeholder="Search here ..." />
                    <span class="text-black text-sm">Item Per Page</span>
                        <select wire:model.live="page" class="text-black ml-2">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
            </div>
            <div>
                <x-nav-link href="{{ route('editor-project') }}" wire:navigate>
                    <div class="mr-20 font-xl text-xl">
                        <i class="fas fa-edit mt-10"></i>{{('Project') }}
                    </div>
                </x-nav-link>
            </div>
        </div>
            <div class="py-5 bg-transparent">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <table class="w-full text-left bg-indigo-400 text-black rounded-lg">
                        <thead class="text-center">
                            <th class="whitespace-nowrap px-4 py-3 font-semibold uppercase text-slate-800 lg:px-5">
                              ID
                            </th>
                            <th class="whitespace-nowrap  px-4 py-3 font-semibold uppercase text-slate-800 lg:px-5">
                              Name
                            </th>
                            <th class="whitespace-nowrap px-4 py-3 font-semibold uppercase text-slate-800 lg:px-5">
                              Industry
                            </th>                                 
                            <th class="whitespace-nowrap px-4 py-3 font-semibold uppercase text-slate-800 lg:px-5">
                              Agent
                            </th>
                            <th class="whitespace-nowrap px-4 py-3 font-semibold uppercase text-slate-800 lg:px-5">
                              more
                            </th>
                        </thead>
                        <td colspan="100"><hr class="border border-black"></td>
                        @forelse($projects as $key => $project)
                        <tbody x-data="{expanded:false}" >
                            <tr class="border-y border-transparent text-center">
                                <td class="whitespace-nowrap px-4 py-3 font-medium sm:px-5">
                                    {{ $project -> id ?? ''}}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> 
                                    {{ $project->project_name ?? '' }}    
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $project->industry ?? '' }}   
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ ucwords($project->name ?? '' )}}   
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <button @click="expanded = !expanded" class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25">
                                        <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
                                    </button>
                                </td>
                            </tr>
                                    <td colspan="100" class="p-0">
                                        <div x-show="expanded" x-collapse class="bg-indigo-500 border-2 border-indigo-600 mb-5 ml-3 mr-3 rounded-lg">
                                            <div class="w-full rounded-lg mt-5 ">
                                                <div class="grid grid-cols-9 gap-3 px-4 py-4 sm:px-5">
                                                    <div class="card px-4 py-4 sm:px-5 col-span-2 border-4 border-blue-300 hover:bg-blue-400 p-10 rounded">
                                                        <h2 class="text-l font-medium tracking-wide line-clamp-1 text-center">
                                                            PAYMENT INFORMATION
                                                        </h2>
                                                        <hr>
                                                            <table class="mt-5">
                                                                <thead class="p-5">
                                                                    <tr>
                                                                        <th class="pl-5 pr-8">Total Paid:</th>
                                                                        <td>{{ number_format($project -> total_paid ?? 0,0)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="pl-5 pr-8">Balance:   </th>
                                                                        <td>{{ number_format($project -> balance ?? 0,0)}}</td>
                                                                    </tr>
                                                                </thead>
                                                            </table>   
                                                    </div>
                                                    <div class="card px-4 py-4 sm:px-5 col-span-5 border-4 hover:bg-blue-400 border-blue-300 rounded">
                                                        <div>
                                                            <h2 class="text-l font-medium tracking-wide line-clamp-1 text-center">
                                                                STAGING
                                                            </h2>
                                                            <hr>
                                                        </div>
                                                        <div class="pt-2 ">
                                                            <div class="mt-1 flex justify-between space-x-2 rounded-2xl bg-slate-150 p-1.5">
                                                                <label class="h-8 rounded-2xl border border-transparent px-4 py-1 pr-9 ">
                                                                Staging
                                                                </label>
                                                                <input class="form-input w-full bg-transparent text-left placeholder:text-slate-900/70" value="{{ $project -> staging ?? ''}}" placeholder="No info. . ." type="text" disabled>
                                                            </div>
                                                            <div class="mt-1 flex justify-between space-x-2 rounded-2xl bg-slate-150 p-1.5">
                                                                <label class="h-8 rounded-2xl border border-transparent  px-4 py-1 pr-9">
                                                                    Username
                                                                </label>
                                                                <input class="form-input w-full bg-transparent px-2 text-left placeholder:text-slate-900/70" value="{{ $project -> wp_login ?? ''}}" placeholder="No info. . ." type="text" disabled>
                                                            </div>
                                                            <div class="mt-1 flex justify-between space-x-2 rounded-2xl bg-slate-150 p-1.5">
                                                                <label class="h-8 rounded-2xl border border-transparent  px-4 py-1 pr-9">
                                                                    Password
                                                                </label>
                                                                <input class="form-input w-full bg-transparent px-2 text-left placeholder:text-slate-900/70" value="{{ $project -> password ?? ''}}" placeholder="No info. . ." type="text" disabled>
                                                            </div>                                                                                                                        
                                                        </div>
                                                    </div>
                                                    <div class="card px-4 py-4 sm:px-5 col-span-2 hover:bg-blue-400 border-4 border-blue-300 rounded">
                                                        <p class="text-l uppercase font-medium text-center">Costing</p>
                                                        <hr class="mb-3">
                                                            <table>
                                                                <thead class="p-5">
                                                                    <tr>
                                                                        <th class="pl-5 pr-8">Project:</th>
                                                                        <td>{{ number_format($project -> project_cost ?? 0,0)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th  class="pl-5 pr-8">Web:</th> 
                                                                        <td>{{ number_format($project -> webdev_cost ?? 0,0)}}</td> 
                                                                    </tr>
                                                                    <tr> 
                                                                        <th  class="pl-5 pr-8">SEO:</th> 
                                                                        <td>{{ number_format($project -> seo_cost ?? 0,0)}}</td> 
                                                                    </tr>
                                                                    <tr>    
                                                                        <th  class="pl-5 pr-8">SMM:</th> 
                                                                        <td>{{ number_format($project -> smm_cost ?? 0,0)}}</td>
                                                                    </tr>
                                                                    <tr>    
                                                                        <th  class="pl-5 pr-8">Video:</th> 
                                                                        <td>{{ number_format($project -> vid_cost ?? 0,0)}}</td> 
                                                                    </tr>
                                                                    <tr>   
                                                                        <th  class="pl-5 pr-8">Graphics:  </th>
                                                                        <td>{{ number_format($project -> graphic_cost ?? 0,0)}}</td> 
                                                                    </tr>
                                                                    <tr> 
                                                                        <th  class="pl-5 pr-8">Total:</th>
                                                                        <td>{{ number_format($project -> total_cost ?? 0,0)}}</td>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                    </div>
                                                </div>
                                                            <div class="px-4 pb-4 sm:px-5">
                                                                @if($project->webdev || $project->seo || $project->smm || $project->vid || $project->graphic)
                                                                    <div class="grid grid-rows-2 bg-blue-300 p-3 rounded-lg mt-5">
                                                                        <h class="font-3xl text-3xl font-bold flex justify-center">SERVICES</h>
                                                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-5 -mt-16">
                                                                                @if($project->webdev)   
                                                                                <div class="relative flex flex-col overflow-hidden rounded-lg border mb-2 border-blue-400 p-3">
                                                                                        <p class="text-l uppercase font-xl text-black flex justify-center font-bold ">Web Design</p><hr class="border-black mb-2">
                                                                                        <p class="text-l uppercase font-medium text-black">Status | {{ $project -> webdev_status ?? '' }}</p>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Deadline: {{ $project -> webdev_deadline ?? '' }} </p>
                                                                                    </div>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Launch: {{ $project -> webdev_launchdate ?? '' }}</p>
                                                                                    </div>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Renewal: {{ $project -> webdev_renewaldate ?? '' }}</p>
                                                                                    </div>
                                                                                </div> 
                                                                                @endif                        
                                                                                @if($project->seo)        
                                                                                <div class="relative flex flex-col overflow-hidden rounded-lg border mb-2 border-blue-400 p-3">
                                                                                        <p class="text-l uppercase font-xl text-black flex justify-center font-bold ">SEO</p><hr class="border-black mb-2">
                                                                                        <p class="text-l uppercase font-medium text-black">Status | {{ $project -> seo_status ?? '' }}</p>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Deadline: {{ $project -> seo_deadline ?? '' }} </p>
                                                                                    </div>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Launch: {{ $project -> seo_launch_date ?? '' }}</p>
                                                                                    </div>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Renewal: {{ $project -> seo_renewaldate ?? '' }}</p>
                                                                                    </div> 
                                                                                </div>
                                                                                @endif   
                                                                                @if($project->smm)   
                                                                                <div class="relative flex flex-col overflow-hidden rounded-lg border mb-2 border-blue-400 p-3">
                                                                                        <p class="text-l uppercase font-xl text-black flex justify-center font-bold ">smm</p><hr class="border-black mb-2">
                                                                                        <p class="text-l uppercase font-medium text-black">Status | {{ $project -> smm_status ?? '' }}</p>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Deadline: {{ $project -> smm_deadline ?? '' }} </p>
                                                                                    </div>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Launch: {{ $project -> smm_launchdate ?? '' }}</p>
                                                                                    </div>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Report: {{ $project -> smm_report ?? '' }}</p>
                                                                                    </div> 
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Renewal: {{ $project -> smm_renewaldate ?? '' }}</p>
                                                                                    </div> 
                                                                                </div>
                                                                                @endif
                                                                                @if($project->vid)       
                                                                                <div class="relative flex flex-col overflow-hidden rounded-lg border mb-2 border-blue-400 p-3">
                                                                                        <p class="text-l uppercase font-xl text-black flex justify-center font-bold ">vid</p><hr class="border-black mb-2">
                                                                                        <p class="text-l uppercase font-medium text-black">Status | {{ $project -> vid_status ?? '' }}</p>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Deadline: {{ $project -> vid_deadline ?? '' }} </p>
                                                                                    </div>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Launch: {{ $project -> vid_launchdate ?? '' }}</p>
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                                @if($project->graphic)        
                                                                                <div class="relative flex flex-col overflow-hidden rounded-lg border mb-2 border-blue-400 p-3">
                                                                                        <p class="text-l uppercase font-xl text-black flex justify-center font-bold ">graphics</p><hr class="border-black mb-2">
                                                                                        <p class="text-l uppercase font-medium text-black">Status | {{ $project -> graphics_status ?? '' }}</p>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Deadline: {{ $project -> graphics_deadline ?? '' }} </p>
                                                                                    </div>
                                                                                    <div class="flex items-end justify-between">
                                                                                        <p class="text-medium text-black">Launch: {{ $project -> graphics_launchdate ?? '' }}</p>
                                                                                    </div>
                                                                                </div>
                                                                                @endif       
                                                                            </div>                                         
                                                                    </div>           
                                                                @endif                                                                                  
                                                                    <div class="text-right">
                                                                        <button @click="expanded = false" class="btn mt-2 mr-8 h-8 rounded px-3 text-xs+ font-medium text-primary hover:text-red-600 focus:bg-red-600 active:bg-primary/25">
                                                                            Hide
                                                                        </button>
                                                                    </div>
                                                                    <div class="grid grid-cols-9">
                                                                      <div class="col-span-4">
                                                                        <hr class="border-red-800 border-2 ml-10">
                                                                      </div>
                                                                      <div class="col-span-1 flex justify-center">
                                                                        <span class="font-sm text-center -mt-5 font-bold">END OF RECORDS</span>
                                                                      </div>
                                                                      <div class="col-span-4">
                                                                        <hr class="border-red-800 border-2 mr-10">
                                                                      </div>
                                                                    </div>
                                        </div>
                                      </div>
                                    </td>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="flex justify-center item-center mt-20 mb-20">
                                    <i class="fa-solid fa-face-frown text-2xl text-red-800"> No Record</i>
                                </div>
                            </td>
                        </tr>  
                        @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="bg-indigo-300">
                                    <div class="relative overflow-x-auto">
                                        {{ $projects ->links() }}
                                    <div>
                                </td>
                            </tr>
                        </tfoot>  
                    </table>
                              
            </div>
</div>

