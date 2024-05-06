<div>
    <div class="grid grid-cols-3">
        <div class="bg-white col-span-1">
        
            <div class="flex justify-center grid grid-cols-1 text-black">
               <div class="col-span-1 mb-5 mt-3">
                    <span class="flex justify-center text-3xl font-3xl text-bold font-bold"><i class="fa-solid fa-users"></i>Users</span>
                </div>
                    <x-input type="search" autofocus wire:model.live.debounce.1000ms="search" class="w-1/3 text-black border-black mb-3 ml-5 focus:animate-pulse" placeholder="Search here ..." />   
                <div class="block ml-5">
                    <div class="inline mr-4">
                    
                        @if (session()->has('message1'))
                            <x-modal>
                                <div class="text-green-700 bg-green-500  rounded-lg text-xl flex justify-center mt-3 mr-5 ml-5 p-3 mb-3">
                                    {{ session('message1') }} 
                                </div>
                            </x-modal>
                        @endif
                        
                        <div><span class="text-xl font-xl text-bold font-bold"><i class="fa-solid fa-users"></i>Admin</span></div>
                        @foreach($adminUsers as $user)
                            <div>
                                <div class="inline-flex items-center mt-2">
                                    <div x-data="{ hover: false }">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="edituser({{ $user -> id }})"
                                          class="btn min-w-[3rem] bg-blue-600 font-medium text-black hover:bg-green-600 focus:bg-green-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          value="save">
                                          <i class="fas fa-edit" ></i>
                                          <span x-show="hover">Edit</span>
                                        </button>
                                    </div>
                                    <div x-data="{ hover: false }">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="setpassword({{ $user -> id }})"
                                          class="btn min-w-[3rem] bg-blue-600 font-medium text-black hover:bg-orange-600 focus:bg-orange-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          value="delete">
                                          <i class="fa fa-key"></i>
                                          <span x-show="hover">Set Password</span>
                                        </button>
                                    </div> 
                                    <div x-data="{ hover: false }">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="deleteuser({{ $user -> id }})" wire:confirm="Are you sure you want delete this user?"
                                          class="btn min-w-[3rem] bg-blue-600 font-medium text-black hover:bg-red-600 focus:bg-red-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          value="delete">
                                          <i class="fa fa-trash"></i>
                                          <span x-show="hover">Delete</span>
                                        </button>
                                    </div> 
                                    <span><i>({{$user -> role -> title ?? '' }}) </i> {{$user->name}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $adminUsers ->links() }}
                    <hr class="mt-3 border-black border-5 mr-5">
                    <div class="inline mr-4">
                        <div><span class="text-xl font-xl text-bold font-bold"><i class="fa-solid fa-users"></i>Sales Department</span></div>
                        @foreach($saleUsers as $user)
                            <div>
                                <div class="inline-flex items-center mt-2">
                                    <div x-data="{ hover: false }">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="edituser({{ $user -> id }})"
                                          class="btn min-w-[3rem] bg-blue-600 font-medium text-black hover:bg-green-600 focus:bg-green-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          value="save">
                                          <i class="fas fa-edit" ></i>
                                          <span x-show="hover">Edit</span>
                                        </button>
                                    </div>
                                    <div x-data="{ hover: false }">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="setpassword({{ $user -> id }})"
                                          class="btn min-w-[3rem] bg-blue-600 font-medium text-black hover:bg-orange-600 focus:bg-orange-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          value="delete">
                                          <i class="fa fa-key"></i>
                                          <span x-show="hover">Set Password</span>
                                        </button>
                                    </div> 
                                    <div x-data="{ hover: false }">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="deleteuser({{ $user -> id }})" wire:confirm="Are you sure you want delete this project?"
                                          class="btn min-w-[3rem] bg-blue-600 font-medium text-black hover:bg-red-600 focus:bg-red-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          value="delete">
                                          <i class="fa fa-trash"></i>
                                          <span x-show="hover">Delete</span>
                                        </button>
                                    </div> 
                                    <span><i>({{$user -> role -> title ?? '' }}) </i> {{$user->name}}</span>
                                </div>
                            </div>
                       @endforeach
                    </div>
                    {{ $saleUsers ->links() }}
                    <hr class="mt-3 border-black border-5 mr-5">
                    <div class="inline mr-4">
                        <div><span class="text-xl font-xl text-bold font-bold"><i class="fa-solid fa-users"></i>IT Department</span></div>
                        @foreach($itUsers as $user)
                            <div>
                                <div class="inline-flex items-center mt-2">
                                    <div x-data="{ hover: false }">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="edituser({{ $user -> id }})"
                                          class="btn min-w-[3rem] bg-blue-600 font-medium text-black hover:bg-green-600 focus:bg-green-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          value="save">
                                          <i class="fas fa-edit" ></i>
                                          <span x-show="hover">Edit</span>
                                        </button>
                                    </div>
                                    <div x-data="{ hover: false }">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="setpassword({{ $user -> id }})"
                                          class="btn min-w-[3rem] bg-blue-600 font-medium text-black hover:bg-orange-600 focus:bg-orange-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          value="delete">
                                          <i class="fa fa-key"></i>
                                          <span x-show="hover">Set Password</span>
                                        </button>
                                    </div> 
                                    <div x-data="{ hover: false }">
                                        <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" wire:click="deleteuser({{ $user -> id }})" wire:confirm="Are you sure you want delete this project?"
                                          class="btn min-w-[3rem] bg-blue-600 font-medium text-black hover:bg-red-600 focus:bg-red-600 active:bg-primary-focus/90 rounded-full"
                                          type="submit"
                                          value="delete">
                                          <i class="fa fa-trash"></i>
                                          <span x-show="hover">Delete</span>
                                        </button>
                                    </div> 
                                    <span><i>({{$user -> role -> title ?? '' }}) </i> {{$user -> name}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $itUsers ->links() }}
                </div>   
            </div>
        
        </div>
        <div class="col-span-2 mb-5">
            <div class="flex flex-col sm:justify-center items-center sm:pt-0">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg mt-10">  
                <x-validation-errors />  
                    <form @if($edit)wire:submit.prevent="updateuser" @elseif($editpass)wire:submit.prevent="updatepassword" @else wire:submit.prevent="addUser" @endif>
                        @csrf
                            <div class="block">
                                <x-label class="text-white" for="name" value="{{ __('Name') }}" />
                                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full bg-transparent text-black" type="text" wire:model="name" :value="old('name')" @if($editpass) readonly @else required @endif autofocus autocomplete="name" />
                            </div>

                            <div @if($editpass) class="hidden" @else class="block mt-4" @endif>
                                <x-label class="text-white" for="email" value="{{ __('Email') }}" />
                                <x-input id="email" class="block mt-1 w-full bg-transparent text-black" type="email" wire:model="email" :value="old('email')" required autocomplete="username" />
                            </div>

                            <div @if($edit)class="hidden" @else class="block mt-4" @endif>
                                <x-label class="text-white" for="password" value="{{ __('Password') }}" />
                                <x-input id="password" class="block mt-1 w-full bg-transparent text-black" type="password" wire:model="password" />
                            </div>

                            <div  @if($edit) class="hidden" @else class="block mt-4" @endif>
                                <x-label class="text-white" for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                <x-input id="password_confirmation" class="block mt-1 w-full bg-transparent text-black" type="password" wire:model="password_confirmation" />
                            </div>
                            <div @if($editpass) class="hidden" @else class="block mt-4" @endif>
                            <x-label class="text-white" for="password_confirmation" value="{{ __('Role') }}" />
                                <select wire:model="role_id" class="mt-1.5 w-full rounded-lg bg-transparent text-black border border-slate-300 hover:border-black" required>
                                <option selected>Select Role</option>
                                    @foreach( $roles as $role)
                                    <option value="{{ $role -> id ?? '' }}">{{ ucwords($role -> title ?? '') }}</option>   
                                    @endforeach                                               
                                </select>
                            </div>
                            <div class="inline-flex">
                                <div x-data="{ hover: false }" class="mt-5 ml-8  flex justify-start">
                                    <button x-on:mouseover="hover = true" x-on:mouseout="hover = false"   @if($edit) wire:click="updateuser" wire:confirm="Update User?" @elseif($editpass)wire:click="updatepassword" wire:confirm="Set new passowrd?" @else wire:click="addUser" wire:confirm="Add User?" @endif
                                      class="btn min-w-[10rem] min-h-[3rem] bg-green-600 font-medium text-black hover:bg-green-700 focus:bg-green-700 active:bg-primary-focus/90 rounded-full"
                                      type="submit">
                                        <i class="fa fa-save"></i>
                                        <span x-show="hover">@if($edit)Update User @elseif($editpass)Update Password @else Add User @endif</span>
                                    </button>
                                </div>
                                <div x-data="{ hover: false }" class="mt-5 ml-8 flex justify-end">
                                    <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" type="button" wire:click="resetpage" wire:confirm="Clear all fields?"
                                      class="btn min-w-[10rem] min-h-[3rem] bg-red-600 font-medium text-black hover:bg-red-700 focus:bg-red-700 active:bg-primary-focus/90 rounded-full">
                                      <i class="fa fa-refresh"></i>
                                      <span x-show="hover">Reset</span>
                                    </button>
                                </div> 
                            </div> 
                    </form>     
            </div>
            </div>
        </div>
    </div>
</div>
