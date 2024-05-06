<div>
    <div class="ml-20 mt-10 mb-5">
        
                        <x-nav-link href="{{ route('duedate') }}" class="hover:animate-bounce" :active="request()->routeIs('duedate')" wire:navigate>
                            {{ __('Due Date') }} </span>
                        </x-nav-link>
                        <x-nav-link href="{{ route('renewal') }}" class="hover:animate-bounce" :active="request()->routeIs('renewal')" wire:navigate>
                            {{ __('Current Month') }} </span>
                        </x-nav-link>
                        <x-nav-link href="{{ route('nextmonth') }}" class="hover:animate-bounce" :active="request()->routeIs('nextmonth')" wire:navigate>
                            {{ __('Next Month') }} </span>
                        </x-nav-link>

    </div>
    <hr class=" mb-10">
        <div class="relative overflow-x-auto flex justify-center">
            <table class="w-2/3 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded border-white border-2">
                <thead class="text-black uppercase bg-transparent dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-center bg-indigo-300">
                        <th scope="col" class="px-6 py-3 text-md">
                            Project name
                        </th>
                        <th scope="col" class="px-6 py-3 text-md">
                            web
                        </th>
                        <th scope="col" class="px-6 py-3 text-md">
                           seo
                        </th>
                        <th scope="col" class="px-6 py-3 text-md">
                           smm
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr class="bg-indigo-200 dark:bg-transparent">
                        <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap dark:text-white text-center">
                           {{$project -> project_name}}
                        </th>
                        @php
                            // Extract month and year from renewal dates
                            $webdev_month = date('m', strtotime($project->webdev_renewaldate));
                            $webdev_year = date('Y', strtotime($project->webdev_renewaldate));

                            $seo_month = date('m', strtotime($project->seo_renewaldate));
                            $seo_year = date('Y', strtotime($project->seo_renewaldate));

                            $smm_month = date('m', strtotime($project->smm_renewaldate));
                            $smm_year = date('Y', strtotime($project->smm_renewaldate));

                            // Get current month and year
                            $current_month = date('m', strtotime('+1 month'));
                            $current_year = date('Y');
                        @endphp
                        <td class="px-6 py-4 text-black">
                            @if($project->webdev_renewaldate)
                                <span class="relative mt-1.5 flex">
                                    <span class="{{$webdev_month == $current_month && $webdev_year == $current_year ? 'block text-white bg-red-400' : 'hidden'}} form-input peer w-full rounded-lg border border-slate-300 px-3 py-2 pl-9 placeholder:text-black hover:border-black">
                                        <i class="fa-regular fa-calendar-days"> </i> {{ $project->webdev_renewaldate }}
                                    </span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-black">
                            @if($project->seo_renewaldate)
                                <span class="relative mt-1.5 flex">
                                    <span class="{{$seo_month == $current_month && $seo_year == $current_year ? 'block text-white bg-red-400' : 'hidden'}} form-input peer w-full rounded-lg border border-slate-300 px-3 py-2 pl-9 placeholder:text-black hover:border-black">
                                        <i class="fa-regular fa-calendar-days"> </i> {{ $project->seo_renewaldate }}
                                    </span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-black">
                            @if($project->smm_renewaldate)
                                <span class="relative mt-1.5 flex">
                                    <span class="{{$smm_month == $current_month && $smm_year == $current_year ? 'block text-white bg-red-400' : 'hidden'}} form-input peer w-full rounded-lg border border-slate-300 px-3 py-2 pl-9 placeholder:text-black hover:border-black">
                                        <i class="fa-regular fa-calendar-days"> </i> {{ $project->smm_renewaldate }}
                                    </span>
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="bg-indigo-300">
                            <div class="relative overflow-x-auto">
                                {{ $projects ->links() }}
                            <div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
</div>
