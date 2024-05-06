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
              <x-nav-link href="{{ route('creator-sales') }}" wire:navigate>
                <div class="mr-20 font-xl text-xl">    
                  <i class="fas fa-edit mt-10"></i>{{('Payment') }} 
                </div>
              </x-nav-link>
            </div>
    </div>

        <div class="bg-transparent">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card mt-3" >
              <div class="min-w-full">
                <table class="w-full bg-indigo-400 text-black rounded">
                  <thead class="text-center">
                    <th class="whitespace-nowrap text-slate-800 px-4 py-3 font-semibold uppercase  lg:px-5">
                      project id  
                    </th>
                    <th class="whitespace-nowrap text-slate-800 px-4 py-3 font-semibold uppercase  lg:px-5 ">
                      project name
                    </th>
                    <th class="whitespace-nowrap text-slate-800 px-4 py-3 font-semibold uppercase  lg:px-5 ">
                      agent
                    </th>
                    <th class="whitespace-nowrap text-slate-800 px-4 py-3 font-semibold uppercase  lg:px-5 ">
                      More
                    </th> 
                  </thead>
                    <td colspan="100"><hr class="border border-black"></td>
                  @forelse ($sales as $sale)
                  <tbody x-data="{expanded:false}" class="text-center">
                    <tr class="border-transparent">
                      <td class=" whitespace-nowrap px-4 py-3 sm:px-5 text-black">  
                        {{ $sale -> project -> id ?? '' }}
                      </td>          
                      <td class=" whitespace-nowrap px-4 py-3 sm:px-5 text-black">  
                        {{ $sale -> project -> project_name ?? '' }}
                      </td>
                      <td class=" whitespace-nowrap px-4 py-3 sm:px-5 text-black">  
                        {{ ucwords ($sale -> project -> agent -> name ?? '') }}
                      </td>
                      <td class=" px-4 py-3 sm:px-5">
                        <button @click="expanded = !expanded" class="btn rounded-full h-8 w-8 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25">
                          <i :class="expanded && '-rotate-180'"
                            class="fas fa-chevron-down text-sm transition-transform">
                          </i>
                        </button>
                      </td>
                    </tr>
                                  
                      <td colspan="100" class="p-0">
                        <div x-show="expanded" x-collapse  class="border-black border rounded-3xl">
                          <div class="px-4 pb-4 sm:px-5">
                            <div class="relative flex flex-col overflow-hidden rounded-lg bg-transparent p-3.5">
                              <table class="w-full text-center bg-gradient-to-t from-indigo-300 to-indigo-500 text-black rounded-lg">
                                <caption class="px-4 py-3 font-bold uppercase text-slate-800 lg:px-5">transaction history</caption>
                                  <thead class="text-center bg-gradient-to-b from-indigo-300 to-indigo-500">
                                    <th class="px-4 py-3 font-semibold uppercase text-slate-800 lg:px-5">
                                      id
                                    </th>
                                    <th class=" px-4 py-3 font-semibold uppercase text-slate-800 lg:px-5">
                                      payment type
                                    </th> 
                                    <th class=" px-4 py-3 font-semibold uppercase text-slate-800 lg:px-5">
                                      paid
                                    </th>
                                  </thead>
                                  @foreach($dups as $key => $dup)
                                  @if($dup->project_id == $sale->project_id)
                                  <tbody class="text-center">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-black">
                                      {{ $dup -> id ?? '' }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-black">
                                      {{ $dup -> payment_type ?? '' }} 
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-black">
                                      {{ number_format($dup -> paid_amount ?? 0,0) }}
                                    </td>
                                  </tbody>
                                  @endif
                                  @endforeach 
                              </table>
                                             
                                      <div class="mt-5 relative flex flex-center justify-center overflow-hidden rounded-lg bg-gradient-to-b from-indigo-300 to-indigo-500 p-5" style="display: flex; justify-content: space-between;">
                                        <p class="text-l uppercase font-medium text-black">Total Cost: {{ number_format($sale -> project -> total_cost ?? 0,0)}}</p>
                                        <p class="text-l uppercase font-medium text-black">Total Paid: {{ number_format($sale -> project -> total_paid ?? 0,0) }} </p>
                                        <p class="text-l uppercase font-medium text-black">Current Balance: {{ number_format($sale -> project -> balance ?? 0,0) }}</p>
                                      </div>                                    
                                      <div class="text-right">
                                        <button @click="expanded = false" class="btn mt-2 h-8 rounded px-3 text-xs+ font-medium text-gray-900 hover:text-red-600 focus:bg-red-600 active:bg-red-400">
                                           Hide
                                        </button>
                                      </div> 
                                      <div class="grid grid-cols-9">
                                        <div class="col-span-4">
                                          <hr class="border-red-800 border-2">
                                        </div>
                                        <div class="col-span-1 flex justify-center">
                                          <span class="font-sm text-center -mt-5 font-bold">END OF RECORDS</span>
                                        </div>
                                        <div class="col-span-4">
                                          <hr class="border-red-800 border-2">
                                        </div>
                                      </div>
                            </div>
                          </div>
                        </div>
                      </td>
                  </tbody> 
                                  @empty
                                  <tr>
                                    <td colspan="4">
                                      <div class="flex justify-center item-center mt-20 mb-20">
                                        <i class="fa-solid fa-face-frown text-2xl text-red-800"> No Record...</i>
                                      </div>
                                    </td>
                                  </tr>  
                                  @endforelse

                  <tfoot>
                    <tr>
                      <td colspan="4" class="bg-indigo-300">
                        <div class="relative overflow-x-auto">
                          {{ $sales ->links() }}
                        <div>
                      </td>
                    </tr>
                  </tfoot>  
                </table> 
                                      
              </div>
            </div>
          <div>
        </div>
</div>

