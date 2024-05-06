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
        
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-6 ml-5">
            <div class="col-span-2">
                
                <table class="w-full text-center bg-indigo-400 text-black rounded-lg">
                <x-input type="search" autofocus wire:model.live.debounce.1000ms="search" class="text-black bg-blue-300 border-3 border-blue-400 mb-5 mt-5 focus:animate-pulse" placeholder="Search here ..." />
                    <thead class="mb-3">        
                        <tr class="text-center">
                            <th>ID</th>
                            <th>PROJECT NAME</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>  
                    <tbody> 
                        @forelse ($projects as $project)       
                        <tr>
                            <td>{{ $project -> id ?? ''}}</td>
                            <td>{{ $project -> project_name ?? '' }}</td>
                            <td> 
                            <div x-data="{ hover: false }" class="mt-2">
                                <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="editpro({{ $project -> id }})"
                                  class="btn min-w-[7rem] bg-blue-600 font-medium text-black hover:bg-green-600 focus:bg-green-600 active:bg-primary-focus/90 rounded-full"
                                  type="submit"
                                 >
                                  <i class="fas fa-edit" ></i>
                                  <span x-show="hover">Edit</span>
                                </button>
                            </div>
                            <div x-data="{ hover: false }" class="mb-5 mt-1">
                                <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="deletepro({{ $project -> id }})" wire:confirm="Are you sure you want delete this project?"
                                  class="btn min-w-[7rem] bg-blue-600 font-medium text-black hover:bg-red-600 focus:bg-red-600 active:bg-primary-focus/90 rounded-full"
                                  type="submit"
                                >
                                  <i class="fa fa-trash"></i>
                                  <span x-show="hover">Delete</span>
                                </button>
                            </div>    
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">
                                <div class="flex justify-center item-center mt-20 mb-20">
                                    <i class="fa-solid fa-bug text-2xl text-red-800">No projects found...</i><i class="fa-solid fa-bug text-2xl text-red-800"></i>
                                </div>
                            </td>
                        </tr>  
                        @endforelse
                    </tbody> 
                    <tfoot>
                        <tr>
                            <td colspan="3" class="bg-indigo-300">
                                <div class="relative overflow-x-auto">
                                    {{ $projects ->links() }}
                                <div>
                            </td>
                        </tr>
                    </tfoot>   
                </table>    
            </div>
            
    <div class="col-span-4 mr-5">
               
    <div class="main-content w-full pb-8 bg-transparent">
                        @if (session()->has('message'))
                            <x-modal>
                            <div class="w-full text-green-700 bg-green-500 rounded-lg text-xl flex justify-center mr-72 p-3">
                            {{ session('message') }} 
                            </div>
                            </x-modal>
                        @endif  
        <form @if($edit)wire:submit.prevent="updateProject" @else wire:submit.prevent="createProject" @endif class="flex justify-center">
            @csrf
   
        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-8">

            {{-- General --}}
                <div class="tab-content p-4 sm:p-5 mt-3 rounded-lg border-black border-4 bg-blue-500">
                    <div class="space-y-5">
                    @if (session()->has('message1'))
                            <div class="text-green-700 w-full bg-green-500 rounded-lg text-xl flex justify-center mr-72 p-3 mb-3">
                                {{ session('message1') }}
                            </div>
                        @endif  
                        <div
                            class="rounded-none border-b-2 border-white px-4 font-medium text-white">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>General</span>
                        </div> 
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="font-medium text-white">Project Name</span>
                                    <input type="text" placeholder="Name. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary" wire:model="project_name">
                                    <div>
                                    @error('project_name') <span class="text-red-400">Project Name cannot be empty.</span> @enderror
                                    </div>
                                </label>

                                <label  class="block">
                                    <span class="font-medium text-white">Project Cost</span>
                                    <input wire:model="project_cost" placeholder="Cost. . ."
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary"
                                    type="number"  value="{{ old('project_cost', '') }}" >
                                                <div>
                                                @error('project_cost') <span class="text-red-400">Project Cost cannot be empty.</span> @enderror
                                                </div>
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Agent</span>
                                    <select wire:model="agent_id" class="mt-1.5 w-full rounded-lg bg-blue-500 text-white border border-slate-300 hover:border-black" required>
                                        <option selected>Select Agent</option>
                                        @foreach( $users as $user)
                                        @if($user->role_id == '2')
                                        <option value="{{ $user -> id }}">{{ ucwords($user -> name) }}</option>
                                        @endif   
                                        @endforeach                                          
                                    </select>
                                    <div>
                                    @error('agent_id') <span class="text-red-400">Please select Agent</span> @enderror
                                    </div>
                                </label>
                                <label @if($edit) class="hidden" @else class="block" @endif>
                                    <span class="font-medium text-white">Payment Type</span>
                                    <select wire:model.live="payment_type" class="mt-1.5 w-full rounded-lg bg-blue-500 text-white border border-slate-300 hover:border-black" required>
                                        @foreach( $payments as $payment)
                                        <option value="{{ $payment -> Name }}">{{ ucwords($payment -> Name) }}</option>   
                                        @endforeach                                               
                                    </select>
                                                <div>
                                                @error('payment_type') <span class="text-red-400">Payment cannot be empty.</span> @enderror
                                                </div>
                                </label> 

                                <label class="block">
                                    <span class="font-medium text-white ">Industry</span>
                                    <select wire:model="industry" class="mt-1.5 w-full bg-blue-500 rounded-lg text-white border border-slate-300 hover:border-black">
                                        <option selected>Select Industry</option>
                                        @foreach( $industries as $industry)
                                        <option value="{{ $industry -> Name }}">{{ ucwords($industry -> Name) }}</option>   
                                        @endforeach     
                                    </select>                
                                </label>
                                <label @if($edit) class="hidden" @else class="block" @endif>
                                    <span class="font-medium text-white">Cash</span>
                                    <input wire:model="paid_amount" placeholder="Cash. . ."
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary" @if($payment_type) enabled  @else disabled @endif
                                    type="number" value="{{ old('paid_amount', '') }}" step="0.01" >
                                </label>
                                                                          
                                <label class="block">
                                    <span class="font-medium text-white">Status</span>
                                    <select wire:model="status" class="mt-1.5 w-full rounded-lg bg-blue-500 text-white border border-slate-300 hover:border-black">
                                        <option selected>Select Status</option>
                                        @foreach( $statuses as $status)
                                        <option value="{{ $status -> Name }}">{{ ucwords($status -> Name) }}</option>   
                                        @endforeach 
                                    </select>                                    
                                </label>   
                                                             
                                <label  class="block">
                                    <span class="font-medium text-white">Signup Date</span>
                                    <span class="relative mt-1.5 flex">
                                        <input wire:model="signup_date" x-init="$el._x_flatpickr = flatpickr($el)"
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                            placeholder="Choose date..." type="text"/>
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                    </span>
                                </label>    
                            </div>                           
                    </div>
                </div>        
              
                {{-- Web Development --}}
                <div class="tab-content p-4 sm:p-5 rounded-lg border-4 border-black bg-blue-500 mt-3" @if($webdev)style="display:block" @else style="display:none" @endif>
                    <div class="space-y-5">
                        <div class="rounded-none border-b-2 border-white px-4 font-medium text-white">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Web Development</span>
                        </div> 

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                    <label class="block">
                                        <span class="font-medium text-white">Website Url</span>
                                        <input wire:model="url" placeholder="Url. . ." class="form-input  mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2  placeholder:text-white hover:border-black focus:border-primary"
                                        type="text" value="{{ old('url', '') }}">                                    
                                    </label>

                                    <label  class="block">
                                        <span class="font-medium text-white">Project Cost</span>
                                            <input wire:model="webdev_cost" placeholder="Cost. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary"
                                                type="number" value="" step="0.01" >
                                    </label>  

                                    <label class="block">
                                        <span class="font-medium text-white ">Type</span>
                                            <select wire:model="webdev_type" class="mt-1.5 w-full text-white rounded-lg bg-blue-500 hover:border-black border-slate-300">
                                                <option selected>Web Type</option>
                                                @foreach( $types as $type)
                                                <option value="{{ $type-> Name }}">{{ ucwords($type-> Name) }}</option>   
                                                @endforeach 
                                            </select>                                    
                                    </label>

                                    <label class="block">
                                        <span class="font-medium text-white">Status</span>
                                            <select wire:model="webdev_status" class="mt-1.5 w-full text-white border-slate-300 rounded-lg bg-blue-500 hover:border-black">
                                                <option selected>Select Status</option>
                                                @foreach( $statuses as $status)
                                                <option value="{{ $status -> Name }}">{{ ucwords($status -> Name) }}</option>   
                                                @endforeach 
                                            </select>                                    
                                    </label>   
                                                 
                                    <label class="block">
                                        <span class="font-medium text-white">Staging</span>
                                            <input wire:model="staging" placeholder="Stage. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary"
                                                    type="text" value="{{ old('staging', '') }}">                                    
                                    </label>  

                                    <label class="block">
                                        <span class="font-medium text-white">Username</span>
                                            <input wire:model="wp_login" placeholder="User. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary "
                                                    type="text" value="{{ old('wp_login', '') }}">
                                    </label>

                                    <label class="block">
                                        <span class="font-medium text-white">Password</span>
                                            <input wire:model="password" placeholder="Pass. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary" 
                                                    type="text" value="{{ old('password', '') }}">
                                    </label>    
                            
                                    <label class="block">
                                        <span class="font-medium text-white">Deadline</span>
                                            <span class="relative mt-1.5 flex">
                                                <input wire:model="webdev_deadline" x-init="$el._x_flatpickr = flatpickr($el)"
                                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                        placeholder="Choose date..." type="text">
                                                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </span>
                                            </span>
                                    </label>    

                                    <label class="block">
                                        <span class="font-medium text-white">Date Launched</span>
                                            <span class="relative mt-1.5 flex">
                                                <input wire:model="webdev_launchdate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                        placeholder="Choose date..." type="text">
                                                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </span>
                                            </span>
                                    </label>  

                                    <label class="block">
                                        <span class="font-medium text-white">Renewal Date</span>
                                            <span class="relative mt-1.5 flex">
                                                <input wire:model="webdev_renewaldate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                        placeholder="Choose date..."  type="text">
                                                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </span>
                                            </span>
                                    </label> 
                                </div>                                
                            
                                <div>
                                    <label class="block">
                                        <span class="font-medium text-white">Design Checklist</span>
                                            <textarea wire:model="design_checklist"
                                                rows="4"
                                                placeholder=" Enter Text. . ."
                                                class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-white hover:border-black focus:border-primary"
                                                >{!! old('design_checklist') !!}</textarea>
                                    </label>     
                                </div>

                                <div>
                                    <label class="block">
                                        <span class="font-medium text-white">Staging Checklist</span>
                                            <textarea wire:model="staging_checklist"
                                                rows="4"
                                                placeholder=" Enter Text. . ."
                                                class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-white hover:border-black focus:border-primary"
                                                >{!! old('staging_checklist') !!}</textarea>
                                    </label>  
                                </div>        
                            
                                <div>
                                    <label class="block">
                                        <span class="font-medium text-white">Hosting Information</span>
                                            <textarea wire:model="host_domain_information"
                                                rows="4"
                                                placeholder=" Enter Text. . ."
                                                class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-white hover:border-black focus:border-primary"
                                                >{!! old('hosting_information') !!}</textarea>
                                    </label>   
                            </div>                                   
                    </div>
                </div>     

                {{-- SEO --}}
                <div class="tab-content p-4 sm:p-5 rounded-lg border-4 bg-blue-500 border-black mt-3" @if($seo)style="display:block" @else style="display:none" @endif>
                    <div class="space-y-5">
                        <div class="rounded-none border-b-2 border-white px-4 font-medium text-white">
                            <i class="fa-solid fa-layer-group"></i>
                                <span>Search Engine Optimization</span>
                        </div> 

                            <div class="grid grid-cols-1 mt-5 gap-4 sm:grid-cols-2">

                                <label class="block">
                                    <span class="font-medium text-white">Status</span>
                                        <select wire:model="seo_status" class="mt-1.5 w-full text-white border-slate-300 rounded-lg bg-blue-500 hover:border-black">
                                            <option selected>Select Status</option>
                                            @foreach( $statuses as $status)
                                            <option value="{{ $status -> Name }}">{{ ucwords($status -> Name) }}</option>   
                                            @endforeach 
                                        </select>                                    
                                </label>  

                                <label class="block">
                                    <span class="font-medium text-white">Project Cost</span>
                                        <input wire:model="seo_cost" placeholder="Cost. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary"
                                                type="number" value="" step="0.01" >
                                </label>  
                                
                                <label class="block">
                                    <span class="font-medium text-white">Setup Deadline</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="seo_deadline" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..." type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Lauched Date</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="seo_launch_date" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..."  type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Renewal Date</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="seo_renewaldate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..."  type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>                                  
                            </div>  
                    </div>
                </div>    
                
                {{-- SMM --}}
                <div class="tab-content p-4 sm:p-5 rounded-lg border-4 bg-blue-500 border-black mt-3" @if($smm) style="display:block" @else style="display:none" @endif>
                    <div class="space-y-5">
                        <div class="rounded-none border-b-2 border-white px-4 font-medium text-white">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Social Media Management</span>
                        </div> 

                            <div class="grid grid-cols-1 mt-5 gap-4 sm:grid-cols-2">

                                <label class="block">
                                    <span class="font-medium text-white">Status</span>
                                        <select wire:model="smm_status" class="mt-1.5 w-full text-white border-slate-300 rounded-lg bg-blue-500 hover:border-black">
                                            <option selected>Select Status</option>
                                            @foreach( $statuses as $status)
                                            <option value="{{ $status -> Name }}">{{ ucwords($status -> Name) }}</option>   
                                            @endforeach 
                                        </select>                                    
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Report Date</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="smm_report" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..." type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Deadline</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="smm_deadline" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..." type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Launched Date</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="smm_launchdate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..." type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Renewal</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="smm_renewaldate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..." type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Project Cost</span>
                                        <input wire:model="smm_cost" placeholder="Cost. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary {{ $errors->has('project_name') ? 'is-invalid' : '' }}"
                                                type="number" value="" step="0.01" >
                                </label> 

                            </div> 

                                <label class="block">
                                    <span class="font-medium text-white">Social Media Links</span>
                                        <textarea wire:model="social_media_links"
                                            rows="4"
                                            placeholder=" Enter Text. . ."
                                            class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-white hover:border-black focus:border-primary"
                                            >{!! old('smm_link') !!}</textarea>
                                </label>      
                        
                    </div>
                </div>      
                     
                {{-- Video --}}
                <div class="tab-content p-4 sm:p-5 rounded-lg border-4 bg-blue-500 border-black mt-3" id="video" @if($vid)style="display:block" @else style="display:none" @endif>
                    <div class="space-y-5">
                        <div class="rounded-none border-b-2 border-white px-4 font-medium text-white">
                            <i class="fa-solid fa-layer-group"></i>
                                <span>Video</span>
                        </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                <label class="block">
                                    <span class="font-medium text-white">Status</span>
                                    <select wire:model="vid_status" class="mt-1.5 w-full text-white border-slate-300 rounded-lg bg-blue-500 hover:border-black">
                                        <option selected>Select Status</option>
                                        @foreach( $statuses as $status)
                                        <option value="{{ $status -> Name }}">{{ ucwords($status -> Name) }}</option>   
                                        @endforeach 
                                    </select>                                    
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Project Cost</span>
                                        <input wire:model="vid_cost" placeholder="Cost. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary"
                                        type="number" value="" step="0.01" >
                                </label>
                           
  
                                <label class="block">
                                    <span class="font-medium text-white">Launched Date</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="vid_launchdate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..." type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>                                                                         
                                                  
                                <label class="block">
                                    <span class="font-medium text-white">Deadline</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="vid_deadline" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..." type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>
                            </div>   
                    </div>
                </div>    
 

                {{-- Graphics --}}
                <div class="tab-content p-4 sm:p-5 rounded-lg border-4 bg-blue-500 border-black mt-3" id="graphics" @if($graphic) style="display:block" @else style="display:none" @endif>
                    <div class="space-y-5">
                        <div class="rounded-none border-b-2 border-white px-4 font-medium text-white">
                            <i class="fa-solid fa-layer-group"></i>
                                <span>Graphics / Marketing Material</span>
                        </div> 

                            <div class="grid gap-4 grid-cols-2">

                                <label class="block">
                                    <span class="font-medium text-white">Status</span>
                                        <select wire:model="graphics_status" class="mt-1.5 w-full border-slate-300 rounded-lg bg-blue-500 hover:border-black {{ $errors->has('graphics_status') ? 'is-invalid' : '' }}" x-init="$el._tom = new Tom($el,{create: true})"  name="graphics_status" id="graphics_status">
                                            <option selected>Select Status</option>
                                            @foreach( $statuses as $status)
                                            <option value="{{ $status -> Name }}">{{ ucwords($status -> Name) }}</option>   
                                            @endforeach 
                                        </select>                                    
                                </label>

                                <label class="block">
                                    <span class="font-medium text-white">Project Cost</span>
                                        <input wire:model="graphic_cost" placeholder="Cost. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-white hover:border-black focus:border-primary {{ $errors->has('project_name') ? 'is-invalid' : '' }}"
                                            type="number" name="graphic_cost" id="graphic_cost" value="" step="0.01" >
                                </label>  
                            
                                <label class="block">
                                    <span class="font-medium text-white">Launched Date</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="graphics_launchdate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..." type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label>                                                                                                    
                                                
                                <label class="block">
                                    <span class="font-medium text-white">Deadline</span>
                                        <span class="relative mt-1.5 flex">
                                            <input wire:model="graphics_deadline" x-init="$el._x_flatpickr = flatpickr($el)"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                    placeholder="Choose date..." type="text">
                                                <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                        </span>
                                </label> 
                            </div>    
                    </div>  
                </div>
              
            
                {{-- client info --}}
                <div class="tab-content p-4 sm:p-5 rounded-lg border-4 bg-blue-500 border-black mt-3 ">
                    <div class="space-y-5">
                        <div class="rounded-none border-b-2 border-white px-4 font-medium text-white">
                            <i class="fa-solid fa-layer-group"></i>
                                <span>Project and Client Information</span>
                        </div> 

                            <label class="block">
                                <span class="font-medium text-white">Project and Client Information</span>
                                    <textarea wire:model="clients_info"
                                        rows="4"
                                        placeholder="Enter Text. . ."
                                        class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-white hover:border-black focus:border-primary"
                                        name="clients_info" id="clients_info">{!! old('project_client') !!}</textarea>
                            </label>        
                    </div>  
                </div>                
    
            </div>
         
            
            <div class="col-span-12 lg:col-span-4 ">
                <div class="p-4 sm:p-5 rounded-lg bg-blue-500 sticky top-24">
                    <label class="block mb-3">
                        <span class="font-medium text-white">Select Services</span>                        
                    </label>
                    <div @if($webdev) x-data="{active: true}" @else x-data="{active: false}" @endif>
                      <label class="block items-center space-x-2">  
                        <input x-model="active" wire:model.live="webdev"  name="webdev" value="1" wire:key="{{ old('webdev', '') }}" class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-success checked:before:bg-white"
                        type="checkbox"/>  
                        <span >Web Design </span> </label>
                      

                      <div @if($seo) x-data="{active: true}" @else x-data="{active: false}" @endif>
                      <label class="block items-center space-x-2">  
                        <input x-model="active" wire:model.live="seo"  name="seo" value="1" class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-success checked:before:bg-white"
                        type="checkbox"/>  
                        <span >Search Engine Opt </span> </label>
                       
                      
                      <div @if($smm) x-data="{active: true}" @else x-data="{active: false}" @endif>
                      <label class="block items-center space-x-2">  
                        <input x-model="active" wire:model.live="smm"  name="smm" value="1" class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-success checked:before:bg-white"
                        type="checkbox"/>  
                        <span >Social Media Marketing </span> </label>
                       
            
                      <div @if($vid) x-data="{active: true}" @else x-data="{active: false}" @endif>
                      <label class="block items-center space-x-2">  
                        <input x-model="active" wire:model.live="vid"   name="vid" value="1" class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-success checked:before:bg-white"
                        type="checkbox"/>  
                        <span >Promotional Video </span> </label>
                       

                      <div @if($graphic) x-data="{active: true}" @else x-data="{active: false}" @endif>
                      <label class="block items-center space-x-2">  
                        <input x-model="active" wire:model.live="graphic" name="graphic" value="1" class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-success checked:before:bg-white"
                        type="checkbox"/>  
                        <span >Graphic Design </span> </label>

                    <div class="flex flex-inline mt-10">
                        <div x-data="{ hover: false }" class="mb-5 mt-1 mr-2">
                                <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click=""  @if($edit) wire:confirm="Save changes?" @else wire:confirm="Create Project?" @endif
                                  class="btn min-w-[7rem] bg-green-600 font-medium text-black hover:bg-green-700 focus:bg-green-700 active:bg-primary-focus/90 rounded-full"
                                  type="submit">
                                  <i class="fa fa-save"></i>
                                  <span x-show="hover">@if($edit)Update @else Save @endif</span>
                                </button>
                        </div>
                        <div x-data="{ hover: false }" class="mb-5 mt-1" wire:ignore>
                                <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" type="button" wire:click="repage" wire:confirm="Clear all fields?"
                                  class="btn min-w-[7rem] bg-red-600 font-medium text-black hover:bg-red-700 focus:bg-red-700 active:bg-primary-focus/90 rounded-full">
                                  <i class="fa fa-refresh"></i>
                                  <span x-show="hover">Reset</span>
                                </button>
                        </div>  
                    </div>                     
                </div>
            </div>
        </div>
    </form>
    </div>
</div>