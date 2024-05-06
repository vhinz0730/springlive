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
                        @if (session()->has('message'))
                            <div class="text-green-700 w-full bg-green-500 rounded-lg text-xl flex justify-center mr-72 p-3 mb-3">
                                {{ session('message') }}
                            </div>
                        @endif  
                        <thead class="mb-3">        
                            <tr class="text-center">
                                <th>ID</th>
                                <th>PROJECT NAME</th>
                                <th>PAID</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>  
                        <tbody> 
                            @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment -> sale_id ?? ''}}</td>
                                <td>{{ $payment -> project_name ?? '' }}</td>
                                <td>{{ $payment -> paid_amount ?? '' }}</td>
                                <td> 
                                    <div x-data="{ hover: false }" class="mt-2">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="editsale({{ $payment -> sale_id }})"
                                          class="btn min-w-[7rem] bg-blue-600 font-medium text-black hover:bg-green-600 focus:bg-green-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          name="action"
                                          value="save">
                                          <i class="fas fa-edit" ></i>
                                          <span x-show="hover">Edit</span>
                                        </button>
                                    </div>
                                    <div x-data="{ hover: false }" class="mb-5 mt-1">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="deletesale({{ $payment -> sale_id }})" wire:confirm="Are you sure you want delete this project?"
                                          class="btn min-w-[7rem] bg-blue-600 font-medium text-black hover:bg-red-600 focus:bg-red-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          name="action"
                                          value="delete">
                                          <i class="fa fa-trash"></i>
                                          <span x-show="hover">Delete</span>
                                        </button>
                                    </div>    
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="flex justify-center item-center mt-20 mb-20">
                                            <i class="fa-solid fa-bug text-2xl text-red-800">No Records...</i><i class="fa-solid fa-bug text-2xl text-red-800"></i>
                                        </div>
                                    </td>
                                </tr>  
                            @endforelse
                        </tbody> 
                        <tfoot>
                            <tr>
                                <td colspan="4" class="bg-indigo-300">
                                    <div class="relative overflow-x-auto">
                                        {{ $payments ->links() }}
                                    <div>
                                </td>
                            </tr>
                        </tfoot>  
                </table>
            </div> 
            <div class="col-span-4 rounded-lg mt-20 mb-12 mr-10 ml-5">
            <form @if($edit) wire:submit.prevent="updateSale" @else wire:submit.prevent="createPayment" @endif class="flex justify-center flex-inline">
            @csrf
                <div class="tab-content p-4 sm:p-5 bg-indigo-400 text-black rounded-lg border-black border-4">
                    <div class="space-y-5">
                    @if (session()->has('message1'))
                            <div class="text-green-700 w-full bg-green-500 rounded-lg text-xl flex justify-center mr-72 p-3 mb-3">
                                {{ session('message1') }}
                            </div>
                        @endif  
                        <div class="rounded-none border-b-2 border-black px-4 font-medium text-black flex justify-between">
                            <div>    
                                <i class="fas fa-receipt"><span> Payment Slip</span></i>
                            </div>
                            <div class="flex flex-inline">
                            <div x-data="{ hover: false }" class="mb-5 mt-1 mr-2">
                                <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click=""  @if($edit) wire:confirm="Save changes?" @else wire:confirm="Add payment?" @endif
                                  class="btn min-w-[7rem] bg-green-600 font-medium text-black hover:bg-green-700 focus:bg-green-700 active:bg-primary-focus/90 rounded-full"
                                  type="submit">
                                  <i class="fa fa-save"></i>
                                  <span x-show="hover">Save</span>
                                </button>
                                </div>
                                <div x-data="{ hover: false }" class="mb-5 mt-1">
                                <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" type="button" wire:click="resetpage" wire:confirm="Clear all fields?"
                                  class="btn min-w-[7rem] bg-red-600 font-medium text-black hover:bg-red-700 focus:bg-red-700 active:bg-primary-focus/90 rounded-full">
                                  <i class="fa fa-refresh"></i>
                                  <span x-show="hover">Reset</span>
                                </button>
                            </div>  
                            </div>  
                        </div> 
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="font-medium">Project Name</span>
                                    @if($edit)<input type="text" placeholder="Name. . ." class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:hover:border-black focus:border-primary" wire:model.live="project_name">
                                    @else<select wire:model="project_id" wire:change="showagent" class="mt-1.5 w-full rounded-lg bg-transparent text-black border border-slate-300 hover:border-black" required>
                                        <option selected>Select Project</option>
                                        @foreach($projects as $project)
                                        <option  value="{{ $project -> id }}">{{ ucwords($project -> project_name) }}</option>   
                                        @endforeach                                               
                                    </select>
                                    @endif
                                   <div>
                                    @error('project_name') <span class="text-red-400">Project Name cannot be empty.</span> @enderror
                                    </div>
                                </label>

                                <label class="block">
                                    <span class="font-medium">Agent</span>
                                    <input type="text" placeholder="Agent. . ." class="form-input mt-1.5 w-full rounded-lg text-black border border-slate-300 bg-transparent px-3 py-2 placeholder:hover:border-black focus:border-primary" wire:model.live="name"  readonly>
                                </label>
                                <label class="block">
                                    <span class="font-medium">Payment Type</span>
                                    <select wire:model="payment_type" wire:change="showdate" class="mt-1.5 w-full rounded-lg bg-transparent text-black border border-slate-300 hover:border-black" required>
                                        @foreach( $payment_types as $payment)
                                        <option value="{{ $payment -> Name }}">{{ ucwords($payment -> Name) }}</option>   
                                        @endforeach                                               
                                    </select>
                                        <div>
                                        @error('payment_type') <span class="text-red-400">Payment cannot be empty.</span> @enderror
                                        </div>
                                </label>
                                <label class="block">
                                    <span class="font-medium">Cash</span>
                                    <input wire:model="paid_amount" placeholder="Cash. . ."
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:hover:border-black focus:border-primary"
                                    type="number" value="{{ old('paid_amount', '') }}" required>
                                </label>
                            </div> 
                            @if($payment_type == "Renewal")
                                <hr class="w-full">
                                <span class="uppercase flex flex-center justify-center text-lg font-xl">update to new renewaldate</span>
                                <hr class="w-full">
                                <div class="flex flex-center item-center grid grid-cols-4">
                                    <div class="col-span-1"></div>
                                    <div class="col-span-2">
                                        <div>
                                        @if($webdev_renewaldate)
                                        <span class="font-medium mr-10">Website Development</span>
                                            <label class="inline-flex items-center">
                                                <span class="relative mt-1.5 mb-3 flex">
                                                    <input wire:model.live="webdev_renewaldate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                            class="form-input peer w-1/2 rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                            placeholder="Choose date..."  type="text" value="{{ old('webdev_renewaldate') }}">
                                                        <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                            <i class="fa-regular fa-calendar-days text-black"></i>
                                                        </span>
                                                </span>
                                            </label>
                                        @endif   
                                        </div>
                                        <div>
                                        @if($seo_renewaldate)
                                        <span class="font-medium">Search Engine Optimization</span>
                                            <label class="inline-flex items-center">
                                                <span class="relative mt-1.5 mb-3 flex">
                                                    <input wire:model.live="seo_renewaldate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                            class="form-input peer w-1/2 rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                            placeholder="Choose date..."  type="text" value="{{ old('seo_renewaldate') }}">
                                                        <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                            <i class="fa-regular fa-calendar-days text-black"></i>
                                                        </span>
                                                </span>      
                                            </label> 
                                        @endif
                                        </div>
                                        <div>
                                        @if($smm_renewaldate)
                                        <span class="font-medium mr-8">Social Media Marketing</span>
                                            <label class="inline-flex items-center">
                                                <span class="relative mt-1.5 flex">
                                                    <input wire:model.live="smm_renewaldate" x-init="$el._x_flatpickr = flatpickr($el)"
                                                            class="form-input peer w-1/2 rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-white hover:border-black focus:border-primary"
                                                            placeholder="Choose date..."  type="text" value="{{ old('smm_renewaldate') }}">
                                                        <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary">
                                                            <i class="fa-regular fa-calendar-days text-black"></i>
                                                        </span>
                                                </span>
                                            </label>
                                        @endif      
                                        </div> 
                                    </div>
                                </div>       
                            @endif
                                                     
                    </div>
                </div> 
            </form>         
            </div>
        </div>
</div>
