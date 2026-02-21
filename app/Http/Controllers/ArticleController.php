<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        
        $query = Article::query();
        if ($category) {
            $query->where('category', $category);
        }
        
        $articles = $query->orderBy('level_id', 'asc')->latest()->paginate(10);
        $articles->appends($request->query());
        $categories = Article::select('category')->distinct()->pluck('category');

        return view('articles.index', compact('articles', 'category', 'categories'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('articles.show', compact('article'));
    }
}
