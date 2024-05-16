<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('frontend.menu_user.index', compact('menus'));
    }
}
