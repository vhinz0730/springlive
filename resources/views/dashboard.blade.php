<x-app-layout>
    <div class="w-full bg-gradient-to-b from-indigo-500 to-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-5 gap-3 mb-5 ">
            <!-- Top Saler idea -->
            <div class="col-span-3 gap-3 p-3 bg-blue-400 border-indigo-400 border-4 rounded-lg mt-5">
                        <p class="text-3xl text-bold text-black flex justify-center p-2">Congratulation to our top agent of the month!</p>
                <div class=" grid grid-cols-3 mt-5">
                    <div class="col-span-1 border-indigo-400 border-2 bg-yellow-500">
                        <div class="flex justify-center">
                            <img src="{{ asset('2.jpg') }}" class="rounded-full w-32 h-32 p-2">
                        </div>
                        <div class="p-2 text-black text-xsm">
                            <p class="p-2">Name:</p>
                            <p class="p-2">Name:</p>
                            <p class="p-2">Name:</p>
                        </div>
                    </div>
                    <div class="col-span-1 border-indigo-400 border-2 ml-2 bg-stone-300">
                        <div class="flex justify-center">
                            <img src="{{ asset('2.jpg') }}" class="rounded-full w-32 h-32 p-2 transition-transform duration-500 ease-in-out hover:rotate-[360deg]">
                        </div>
                        <div class="p-2 text-black text-xsm ">
                            <p class="p-2">Name:</p>
                            <p class="p-2">Name:</p>
                            <p class="p-2">Name:</p>
                        </div>
                    </div>
                    <div class="col-span-1 border-indigo-400 border-2 ml-2 bg-yellow-950">
                        <div class="flex justify-center">
                            <img src="{{ asset('2.jpg') }}" class="rounded-full w-32 h-32 p-2 transition-transform duration-500 ease-in-out hover:rotate-[360deg]">
                        </div>
                        <div class="p-2 text-black text-xsm ">
                            <p class="p-2">Name:</p>
                            <p class="p-2">Name:</p>
                            <p class="p-2">Name:</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Data info -->
            <div class="col-span-2 p-2 border-indigo-400 border-4 bg-blue-400 rounded-lg mt-5">
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-5 lg:grid-cols-2 p-3">
                   
                    <div class="rounded-lg bg-blue-300 p-1 dark:bg-navy-700 grid">
                        <div class="flex justify-end space-x-1">
                            <i class="fa-solid fa-sack-dollar text-blue-600 text-3xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl text-center text-black font-bold">99</p>
                        </div>
                        <div class="">
                            <p class="text-xl text-black font-bold">INCOME</p>
                        </div>
                    </div>
                    
                    <div class="rounded-lg bg-blue-300 p-1 dark:bg-navy-700 grid">
                        <div class="flex justify-end space-x-1">
                            <i class="fa-solid fa-laptop-code text-blue-600 text-3xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl text-center text-black font-bold">99</p>
                        </div>
                        <div class="">
                            <p class="text-xl text-black font-bold">PRODUCT</p>
                        </div>
                    </div>
                
                    <div class="rounded-lg bg-yellow-600 p-1 dark:bg-navy-700 grid">
                        <div class="flex justify-end space-x-1">
                            <i class="fa-solid fa-clock text-yellow-800 text-3xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl text-center text-black font-bold">99</p>
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
                            <p class="text-3xl text-center text-black font-bold">99</p>
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
                            <p class="text-3xl text-center text-black font-bold">99</p>
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
                            <p class="text-3xl text-black text-center font-bold">99</p>
                        </div>
                        <div class="">
                            <p class="text-xl text-black font-bold">CANCELLED</p>
                        </div>
                    </div>
                   
                </div>    
            </div>

        </div>
    
                <!-- Services -->
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-5 p-4 bg-transparent">  
                               
                                <div class="relative flex flex-col overflow-hidden rounded-lg bg-gradient-to-br from-rose-600 to-gray-300 p-3.5">
                                        <p class="text-l uppercase font-medium text-black">Web Design |</p>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="text-medium text-black">Deadline: </p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="ml-14 text-medium text-black"><u></u></p1>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="mt-4 text-medium text-black">Launch Date:</p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="ml-14 text-medium text-black"><u></u></p>
                                    </div>
                                </div>
                               
                                <div class="relative flex flex-col overflow-hidden rounded-lg bg-gradient-to-br from-rose-600 to-gray-300 p-3.5">
                                        <p class="text-l uppercase font-medium text-black">SEO |</p>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="text-medium text-black">Deadline:</p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="ml-14 text-medium text-black"><u></u></p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="mt-4 text-medium text-black">Launch Date:</p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="ml-14 text-medium text-black"><u></u></p>
                                    </div>
                                </div>
                               
                                <div class="relative flex flex-col overflow-hidden rounded-lg bg-gradient-to-br from-rose-600 to-gray-300 p-3.5">
                                        <p class="text-l uppercase font-medium text-black">SMM |</p>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="text-medium text-black">Deadline:</p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="ml-14 text-medium text-black"><u></u></p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="mt-4 text-medium text-black">Launch Date:</p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="ml-14 text-medium text-black"><u></u></p>
                                    </div>
                                </div>
                              
                                <div class="relative flex flex-col overflow-hidden rounded-lg bg-gradient-to-br from-rose-600 to-gray-300 p-3.5">
                                        <p class="text-l uppercase font-medium text-black">Video | </p>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="text-medium text-black">Deadline:</p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="ml-14 text-medium text-black"><u></u></p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="mt-4 text-medium text-black">Launch Date:</p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="ml-14 text-medium text-black"><u></u></p>
                                    </div>
                                </div>
                               
                                <div class="relative flex flex-col overflow-hidden rounded-lg bg-gradient-to-br from-rose-600 to-gray-300 p-3.5">
                                        <p class="text-l uppercase font-medium text-black">Graphics |</p>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="text-medium text-black">Deadline:</p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                        <p class="ml-14 text-medium text-black"><u></u></p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="mt-4 text-medium text-black">Launch Date:</p>
                                    </div>
                                    <div class="flex items-end justify-between space-x-2">
                                         <p class="ml-14 text-medium text-black"><u></u></p>
                                    </div>
                                </div>
                              
                    </div> 
                </div>
                                <div><br><br><br></div>
  
    </div>  
</x-app-layout>
