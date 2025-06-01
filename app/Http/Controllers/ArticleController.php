<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class ArticleController extends Controller
{   
    public function __construct()
    {
        $this->middleware("auth")->except(['index', 'detail']);
    }

    public function index() 
    {
        // $data = Article::all(); 
        $data = Article::latest()->paginate(5);  
        return view("article.index", [
            'articles' => $data
        ]);
    }
    public function detail($id)
    {
        // return "Article Controller Detail - $id";
        $data = Article::find($id);
        return view('article.detail',[
            'article' => $data
        ]);
    }
    public function delete($id) 
    {
        $article = Article::find($id);

        if(Gate::allows('delete-article', $article)){
            $article->delete();
            return redirect('/articles')->with("info", "Deleted an article");
        }
        

        return back()->with("info", "Unauthorize to delete");
    }

    public function add()
    {
        return view('article.add');
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            "title" => 'required',
            "body" => ' required',
            "category_id" => 'required'

        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = Auth::id();
        $article->save();


        return redirect("/articles");
    }

    public function edit()
    {
        return view('article.edit');
    }
    public function update($id)
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $article = Article::find($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();
        return redirect("/articles/detail/{$id}")->with("edit", "Edit Success");

    }
}

