<?php

namespace App\Http\Controllers;

use App\Models\UserLogs;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class UserLogController extends Controller
{
    public function index(Request $request)
    {
        $usersLog = UserLogs::with('user')->get();
        $title = 'Log Activity';
        //dd($usersLog[1]);
        UserLogs::logAction($request, 'Menu Access', Auth::user()->id, 'UserLog', '');
        return view('pages.users_log.index', compact('usersLog', 'title'));
    }
}
