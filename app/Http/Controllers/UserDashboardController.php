<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(){
        $galeri = Galeri::all();
        return view('frontend.dashboard_user.index', compact('galeri'));
    }
}
