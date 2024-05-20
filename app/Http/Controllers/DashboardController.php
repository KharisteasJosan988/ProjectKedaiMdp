<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Galeri;
use App\Models\Menu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $contacts = Contact::all();
        $galeri = Galeri::all();
        $menus = Menu::all();

        return view('dashboard_admin', compact('contacts', 'galeri', 'menus'));
    }

    public function user()
    {
        return view('frontend.landing.index');
    }
}
