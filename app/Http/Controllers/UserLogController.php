<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLogs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersLogExport;

class UserLogController extends Controller
{
    public function index(Request $request)
    {
        $usersLog = UserLogs::with('user')->get();
        $users = User::all();
        $title = 'Log Activity';
        UserLogs::logAction($request, 'Menu Access', Auth::user()->id, 'UserLog', '');
        return view('pages.users_log.index', compact('usersLog', 'title', 'users'));
    }

    public function downloadLog(Request $request)
    {
        try {
            $dateRange = explode(' - ', $request->input('daterange'));
            $users = $request->input('users');

            if (count($dateRange) !== 2) {
                return redirect()->back()->with('error', 'Invalid date range format.');
            }

            $startDate = Carbon::parse($dateRange[0]);
            $endDate = Carbon::parse($dateRange[1]);

            $usersLog = UserLogs::with('user')
                ->where('users', $users)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            if ($usersLog->isEmpty()) {
                return redirect()->back()->with('error', 'No logs found within the specified date range.');
            }

            return Excel::download(new UsersLogExport($usersLog), $startDate . '-' . $endDate . '.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
