<div>
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-5 gap-3 mb-5 ">
        <!-- Top Saler idea -->
        <div class="col-span-3 gap-3 p-3">
            <div class=" grid grid-cols-3 mt-3">
                <div class="col-span-1 bg-cover bg-no-repeat bg-center mr-2" style="background-image: url('{{ asset('top.gif') }}');">
                    <div class="flex justify-center">
                        <p class="text-sm text-black flex justify-center uppercase mt-5 mb-5 animate-pulse hover:animate-ping">top agent of the month!</p>
                    </div>
                    <?php
                    $x = 1;
                    ?>
                    @foreach ($topThreeUsers as $userName => $totalCosts)
                    @if($totalCosts != 0)
                    <div class="flex justify-left ml-5 mb-5">
                    <p> {{$x++}}) {{ $userName}}: {{ $totalCosts }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
               
                <div class="col-span-2 ml-2 border-black mr-3 border-4 bg-contain bg-center bg-no-repeat" style="height: 62vh; overflow-y: auto;">
                    @foreach ($announcements as $announcement)
                        @if ($announcement->created_at->diffInDays(now()) <= 3)
                            <main class="antialiased ml-5 mt-3 mb-5">
                                <div class="inline-flex items-center mr-3 text-md text-gray-900 dark:text-white">
                                    <img class="w-5 h-5 rounded-full" src="{{ asset('app-logo.png') }}">
                                    <p>Announcement Bot </p>
                                    <span class="text-xs ml-2"> ({{$announcement->created_at}})</span>
                                </div>    
                                    <div class="ml-8">
                                        <p class="text-l font-bold text-black dark:text-white">Cheers to <span class="text-white">{{$announcement->agent}}</span> for a job well done!</p>
                                        <p class="text-base text-black dark:text-gray-400">{{$announcement->title}} : {{$announcement->body}}</p>
                                        <p class="text-base text-sm text-gray-500 dark:text-gray-400 flex justify-end mr-3"><time>{{ $announcement->created_at->diffForHumans() }}</time></p>
                                    </div>

                            </main>
                        @endif    
                    @endforeach
                </div>
               


            </div>
        </div>

        <!-- Data info -->
        <div class="col-span-2 p-2">
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-5 lg:grid-cols-2 p-3 border-indigo-400 border-4 bg-blue-400 rounded-lg mt-3">
               
                <a href="{{route ('sales')}}" wire:navigate>
                    <div class="rounded-lg bg-blue-300 hover:bg-blue-500 p-1 dark:bg-navy-700 grid">
                        <div class="flex justify-end space-x-1">
                            <i class="fa-solid fa-sack-dollar text-blue-600 text-3xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl text-center text-black font-bold">{{$monthlyincome}}</p>
                        </div>
                        <div class="">
                            <p class="text-xl text-black font-bold">INCOME</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('renewal') }}" wire:navigate>
                    <div class="rounded-lg bg-blue-300 hover:bg-blue-500 p-1 dark:bg-navy-700 grid">
                        <div class="flex justify-end space-x-1">
                        <i class="fa-solid fa-calendar-xmark text-red-600 text-3xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl text-center text-black font-bold">{{$projects}}</p>
                        </div>
                        <div class="">
                            <p class="text-xl text-black font-bold">Pending Renewal</p>
                        </div>
                    </div>
                </a>
            
                <div class="rounded-lg bg-yellow-600 p-1 dark:bg-navy-700 grid">
                    <div class="flex justify-end space-x-1">
                        <i class="fa-solid fa-clock text-yellow-800 text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-3xl text-center text-black font-bold">69</p>
                    </div>
                    <div class="">
                        <p class="text-xl text-black font-bold">PENDING</p>
                    </div>
                </div>
                  
                <div class="rounded-lg bg-green-300 p-1 dark:bg-navy-700 grid">
                    <div class="flex justify-end space-x-1">
                        <i class="fa-solid fa-circle-check text-green-600 text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-3xl text-center text-black font-bold">69</p>
                    </div>
                    <div class="">
                        <p class="text-xl text-black font-bold">COMPLETED</p>
                    </div>
                </div>

                <div class="rounded-lg bg-orange-300 p-1 dark:bg-navy-700 grid">
                    <div class="flex justify-end space-x-1">
                        <i class="fa-solid fa-hourglass text-orange-600 text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-3xl text-center text-black font-bold">69</p>
                    </div>
                        <div class="">
                    <p class="text-xl text-black font-bold">NOT STARTED</p>
                    </div>
                </div>

                <div class="rounded-lg bg-red-300 p-1 dark:bg-navy-700 grid">
                    <div class="flex justify-end space-x-1">
                        <i class="fa-solid fa-ban text-red-600 text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-3xl text-black text-center font-bold">69</p>
                    </div>
                    <div class="">
                        <p class="text-xl text-black font-bold">CANCELLED</p>
                    </div>
                </div>
                
            </div>    
        </div>

    </div>
  
</div>
