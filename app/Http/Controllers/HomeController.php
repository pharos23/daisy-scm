<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = Auth::user()->hasRole(['Admin', 'Super Admin']);
        $activeTab = $request->query('tab', $isAdmin ? 'admin' : 'contact');

        $data = [
            'isAdmin' => $isAdmin,
            'activeTab' => $activeTab,
        ];

        if ($isAdmin && $activeTab === 'admin') {
            $data['adminStats'] = [
                'totalUsers' => User::count(),
                'newUsers' => User::whereBetween('created_at', [now()->startOfMonth(), now()])->count(),
                'totalRoles' => Role::count(),
                'topRole' => DB::table('model_has_roles')
                        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                        ->select('roles.name', DB::raw('count(*) as total'))
                        ->groupBy('roles.name')
                        ->orderByDesc('total')
                        ->first()?->name ?? 'N/A',
                'recentUsers' => User::latest()->take(5)->get(),
            ];
        }

        if ($activeTab === 'contact') {
            $data['contactStats'] = [
                'totalContacts' => DB::table('contacts')->count(),
                'newContacts' => DB::table('contacts')->whereBetween('created_at', [now()->startOfMonth(), now()])->count(),
                'totalGroups' => DB::table('contacts')->distinct('grupo')->count('grupo'),
                'recentContacts' => DB::table('contacts')->latest()->take(5)->get(),
            ];
        }

        return view('home', $data);
    }
}
