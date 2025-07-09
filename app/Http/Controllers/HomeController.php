<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

/**
 * Controller responsible for rendering the home/dashboard view.
 * Displays different statistics and panels depending on user role and active tab.
 */
class HomeController extends Controller
{
    /**
     * Displays the main dashboard with either admin or contact stats,
     * depending on user role and selected tab.
     */
    public function index(Request $request)
    {
        // Check if the current user has Admin or Super Admin role
        $isAdmin = Auth::user()->hasRole(['Admin', 'Super Admin']);

        // Get the currently active tab from query string (?tab=admin/contact)
        // If the user is an admin, default to 'admin'; otherwise, 'contact'
        $activeTab = $request->query('tab', $isAdmin ? 'admin' : 'contact');

        // Initialize data array with access-level and UI state
        $data = [
            'isAdmin' => $isAdmin,
            'activeTab' => $activeTab,
        ];

        /**
         * If the user is an admin and the active tab is 'admin',
         * prepare statistics related to users and roles.
         */
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

        /**
         * If the active tab is 'contact', show contact-related statistics.
         * This is available to all users.
         */
        if ($activeTab === 'contact') {
            $data['contactStats'] = [
                'totalContacts' => DB::table('contacts')->count(),
                'newContacts' => DB::table('contacts')->whereBetween('created_at', [now()->startOfMonth(), now()])->count(),
                'totalGroups' => DB::table('contacts')->distinct('grupo')->count('grupo'),
                'recentContacts' => DB::table('contacts')->latest()->take(5)->get(),
            ];
        }

        // Return the home view with the assembled data
        return view('home', $data);
    }
}
