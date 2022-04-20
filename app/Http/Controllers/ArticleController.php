<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Article;
use DB;

class ArticleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:article-list|article-create|article-edit|article-delete', ['only' => ['index','store']]);
         $this->middleware('permission:article-create', ['only' => ['create','store']]);
         $this->middleware('permission:article-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:article-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $articles = DB::table('articles')
                    ->join('users','users.id', '=', 'articles.user_id')
                    ->get();
        return response()->json($articles);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'user_id'  => 'required',
            'title'    => 'required',
            'desc'     => 'required'
        ]);

        $article = Article::create([
            'user_id'      => $request->user_id,
            'title'        => $request->title,
            'desc'         => $request->desc
            // 'active'       => $request->input('active', 1)
        ]);

        if($article){
            return response()->json([
                'success'   => true,
                'message'   => 'List article Post',
                'data'      => $article
            ]);
        }else{
            return response()->json([
                'success'       => false,
                'message'       => 'Post Failed to Save',
                'data'          => $article
            ],200);
        }
    }
    public function show($id)
    {
        $article = Article::findOrFail($id);

        return response()->json([
            'success'   => true,
            'message'   => 'Detail article',
            'data'      => $article
        ],200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'user_id'  => 'required',
            'title'    => 'required',
            'desc'     => 'required'
        ]);

        $articles = [
            'user_id'      => $request->user_id,
            'title'        => $request->title,
            'desc'         => $request->desc
        ];
       $article = Article::whereId($id)->update($articles);
        if($article){
            return response()->json([
                'success'   => true,
                'message'   => 'Success article Update',
                'data'      => $article
            ]);
        }else{
            return response()->json([
                'success'       => false,
                'message'       => 'Update Failed to Save',
                'data'          => $article
            ],200);
        }
    }
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        if ($article) {
            return response()->json([
                'success' => true,
                'message' => 'article Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'article Gagal Dihapus!',
            ], 400);
        }

    }
}
