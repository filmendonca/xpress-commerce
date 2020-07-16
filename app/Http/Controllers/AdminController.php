<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function index(){

        return view('dashboard');

    }

    public function users(){

        //Obtem todos os utilizadores que não sejam o utilizador logado e que estejam verificados
        $totalUsers = User::where('id', '<>', auth()->user()->id)
        ->where('email_verified_at', '<>', null)
        ->paginate(10);
        
        return view('users')->with('users', $totalUsers);

    }

    public function turnAdmin($id){

        $user = User::find($id);

        $user->user_type = "admin";

        $user->save();

        return redirect('users');

    }
    
}
