<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $title = 'Evoting';
    protected $menu = 'beranda';

    public function index()
    {
        
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'label' => $this->menu,
          
            

        ];
        return view('dashboard.dashboard')->with($data);
    }
}
