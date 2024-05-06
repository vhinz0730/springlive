<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Project;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Home extends Component
{
    public function render()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $users = User::where('role_id', 2)->get();
        
        $userTotals = [];

        $announcements = Announcement::latest()->get();

        foreach ($users as $user) {
            $totalCost = Project::where('agent_id', $user->id)
                        ->whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear)
                        ->sum('total_cost');
            $userTotals[$user->name] = $totalCost;
        }
        $monthlyincome = Project::whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear)
                        ->sum('total_cost');
        arsort($userTotals);
        $topThreeUsers = array_slice($userTotals, 0, 3, true);

        $projects = Project::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('webdev_renewaldate', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('seo_renewaldate', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('smm_renewaldate', [$startOfMonth, $endOfMonth]);
        })->count();
        return view('livewire.home', compact('topThreeUsers','totalCost','announcements','monthlyincome','projects'));
    }
}
