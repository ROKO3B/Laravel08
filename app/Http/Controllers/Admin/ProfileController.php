<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


// 以下の1行を追記することで、News Modelが扱えるようになる
use App\Models\Profile;


class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }
    public function create()
    {
        return redirect('admin/profile/create');
    }
    public function edit()
    {
        return view('admin.profile.edit');
    }
    public function update()
    {
       return redirect('admin/profile/edit'); 
    }
    
    
}
