<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\ScSchool;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function search($data)
    {
        $app['user'] = User::join('sc_schools', 'users.sc_school_id', '=', 'sc_schools.id')->where('users.name', 'like', '%' . $data . '%')
            ->orderBy('id', 'ASC')
            ->orWhere('users.nisn', 'like', '%' . $data . '%')
            ->select('users.id', 'users.name', 'users.nisn', 'users.avatar', 'sc_schools.name as school_name')
            ->paginate(25);
        $app['school'] = ScSchool::join('users', 'sc_schools.user_id', '=', 'users.id')
            ->orderBy('id', 'ASC')
            ->orWhere('sc_schools.name', 'like', '%' . $data . '%')
            ->select(
                'sc_schools.id', 'sc_schools.name', 'sc_schools.description',
                'sc_schools.created_at','sc_schools.updated_at',
                'users.name as user_name', 'users.id as user_id')
            ->paginate(25);
        return response()->json($app, 200);
    }
}