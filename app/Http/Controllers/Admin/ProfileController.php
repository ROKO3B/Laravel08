<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


// 以下の1行を追記することで、News Modelが扱えるようになる
use App\Models\Profile;

// 以下を追記
use App\Models\History;

use Carbon\Carbon;


class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }
    // 以下を追記
    public function create(Request $request)
    {
        
        // 以下を追記
        // Validationを行う
        $this->validate($request, Profile::$rules);

        $profile =new Profile;
        $form = $request->all();

       
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        
        // データベースに保存する
        $profile->fill($form);
        $profile->save();
        // admin/news/createにリダイレクトする
        return redirect('admin/profile/create');
    }
    // 以下を追記
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            // 検索されたら検索結果を取得する
            $posts = Profile::where('title', $cond_title)->get();
        } else {
            // それ以外はすべてのニュースを取得する
            $posts = profile::all();
        }
        return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    
    public function edit(Request $request)
    {
        // News Modelからデータを取得する
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Profile::$rules);
        // News Modelからデータを取得する
        $profile = Profile::find($request->id);
        // 送信されてきたフォームデータを格納する
        $profile_form = $request->all();
        
        
        unset($profile_form['_token']);
        

        // 該当するデータを上書きして保存する
        $profile->fill($profile_form)->save();
        
         // 以下を追記
        $history = new History();
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/profile');
    }
    
    // 以下を追記

    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $profile = Profile::find($request->id);

        // 削除する
        $profile->delete();

        return redirect('admin/profile/');
    }
}
