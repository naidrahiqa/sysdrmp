<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ─── Dashboard ────────────────────────────────────────────────────────────
    public function index()
    {
        $stats = [
            'total'        => Article::count(),
            'beginner'     => Article::where('level_id', 1)->count(),
            'intermediate' => Article::where('level_id', 2)->count(),
            'advanced'     => Article::where('level_id', 3)->count(),
            'expert'       => Article::where('level_id', 4)->count(),
        ];
        $categories  = Article::select('category')->distinct()->pluck('category');
        $recentArticles = Article::latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'categories', 'recentArticles'));
    }

    // ─── List All Articles ────────────────────────────────────────────────────
    public function articles(Request $request)
    {
        $query    = Article::query();
        $search   = $request->query('search');
        $category = $request->query('category');
        $level    = $request->query('level');

        if ($search)   $query->where(fn($q) => $q->where('title', 'like', "%$search%")->orWhere('author', 'like', "%$search%"));
        if ($category) $query->where('category', $category);
        if ($level)    $query->where('level_id', $level);

        $articles   = $query->orderBy('level_id')->latest()->paginate(15)->withQueryString();
        $categories = Article::select('category')->distinct()->pluck('category');

        return view('admin.articles', compact('articles', 'categories', 'search', 'category', 'level'));
    }

    // ─── Create Form ──────────────────────────────────────────────────────────
    public function create()
    {
        $categories = Article::select('category')->distinct()->pluck('category');
        return view('admin.article-form', compact('categories'));
    }

    // ─── Store ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255|unique:articles,slug',
            'category'  => 'required|string|max:100',
            'author'    => 'required|string|max:100',
            'read_time' => 'required|integer|min:1|max:999',
            'excerpt'   => 'required|string|max:500',
            'content'   => 'required|string',
            'level_id'  => 'required|integer|in:1,2,3,4',
        ]);

        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        // Make sure slug is unique
        $baseSlug = $validated['slug'];
        $i = 1;
        while (Article::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "$baseSlug-$i";
            $i++;
        }

        $article = Article::create($validated);

        return redirect()->route('admin.articles')
            ->with('success', "Article \"{$article->title}\" created successfully.");
    }

    // ─── Edit Form ────────────────────────────────────────────────────────────
    public function edit(Article $article)
    {
        $categories = Article::select('category')->distinct()->pluck('category');
        return view('admin.article-form', compact('article', 'categories'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'slug'      => "nullable|string|max:255|unique:articles,slug,{$article->id}",
            'category'  => 'required|string|max:100',
            'author'    => 'required|string|max:100',
            'read_time' => 'required|integer|min:1|max:999',
            'excerpt'   => 'required|string|max:500',
            'content'   => 'required|string',
            'level_id'  => 'required|integer|in:1,2,3,4',
        ]);

        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $article->update($validated);

        return redirect()->route('admin.articles')
            ->with('success', "Article \"{$article->title}\" updated successfully.");
    }

    // ─── Delete ───────────────────────────────────────────────────────────────
    public function destroy(Article $article)
    {
        $title = $article->title;
        $article->delete();

        return redirect()->route('admin.articles')
            ->with('success', "Article \"{$title}\" deleted.");
    }

    // ─── Preview (AJAX) ───────────────────────────────────────────────────────
    public function preview(Request $request)
    {
        return response()->json([
            'html' => $request->input('content', ''),
        ]);
    }
}
