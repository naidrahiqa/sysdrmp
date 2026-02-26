@extends('layouts.admin')
@section('title', 'Articles')
@section('page-title', '~/admin/articles')

@section('content')
{{-- Top bar --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-black text-textBright font-mono">Article Manager</h2>
        <p class="text-xs text-textDim font-mono mt-0.5">{{ $articles->total() }} total records</p>
    </div>
    <a href="{{ route('admin.articles.create') }}"
       class="inline-flex items-center gap-2 bg-primary text-white font-bold font-mono text-sm px-5 py-2.5 rounded-lg shadow-[0_0_12px_rgba(255,0,127,0.3)] border border-primary hover:bg-bgDeep hover:text-primary transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Article
    </a>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.articles') }}"
      class="bg-bgCard border border-borderSoft rounded-xl p-4 mb-6 flex flex-wrap gap-3">
    <input type="text" name="search" placeholder="Search title / author…"
           value="{{ $search }}"
           class="admin-input flex-1 min-w-[200px]" style="max-width:320px">
    <select name="category" class="admin-input" style="max-width:180px">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
        <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    <select name="level" class="admin-input" style="max-width:160px">
        <option value="">All Levels</option>
        <option value="1" {{ $level == 1 ? 'selected' : '' }}>Beginner</option>
        <option value="2" {{ $level == 2 ? 'selected' : '' }}>Intermediate</option>
        <option value="3" {{ $level == 3 ? 'selected' : '' }}>Advanced</option>
        <option value="4" {{ $level == 4 ? 'selected' : '' }}>Expert</option>
    </select>
    <button type="submit" class="px-5 py-2.5 bg-bgElevated border border-borderStrong hover:border-accent text-textNormal hover:text-accent font-bold font-mono text-sm rounded-lg transition-all">Filter</button>
    @if($search || $category || $level)
    <a href="{{ route('admin.articles') }}" class="px-5 py-2.5 bg-bgElevated border border-borderStrong hover:border-primary text-textDim hover:text-primary font-bold font-mono text-sm rounded-lg transition-all">Clear</a>
    @endif
</form>

{{-- Table --}}
<div class="bg-bgCard border border-borderSoft rounded-xl overflow-hidden mb-6">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-borderSoft">
                <th class="px-6 py-3.5 text-left text-[10px] font-bold font-mono uppercase tracking-widest text-textDim">Title</th>
                <th class="px-4 py-3.5 text-left text-[10px] font-bold font-mono uppercase tracking-widest text-textDim hidden md:table-cell">Category</th>
                <th class="px-4 py-3.5 text-left text-[10px] font-bold font-mono uppercase tracking-widest text-textDim hidden lg:table-cell">Author</th>
                <th class="px-4 py-3.5 text-left text-[10px] font-bold font-mono uppercase tracking-widest text-textDim">Level</th>
                <th class="px-4 py-3.5 text-left text-[10px] font-bold font-mono uppercase tracking-widest text-textDim hidden lg:table-cell">Read</th>
                <th class="px-6 py-3.5 text-right text-[10px] font-bold font-mono uppercase tracking-widest text-textDim">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-borderSoft">
            @forelse($articles as $article)
            <tr class="hover:bg-bgElevated/40 transition-colors group">
                <td class="px-6 py-4">
                    <p class="font-medium text-textNormal group-hover:text-textBright transition-colors truncate max-w-[220px]">{{ $article->title }}</p>
                    <p class="text-[10px] font-mono text-textDim mt-0.5 truncate max-w-[220px]">{{ $article->slug }}</p>
                </td>
                <td class="px-4 py-4 hidden md:table-cell">
                    <span class="text-xs font-mono text-warning">{{ $article->category }}</span>
                </td>
                <td class="px-4 py-4 hidden lg:table-cell">
                    <span class="text-xs text-textDim">{{ $article->author }}</span>
                </td>
                <td class="px-4 py-4">
                    @php
                        $lvlMap = [1=>'Beginner',2=>'Intermediate',3=>'Advanced',4=>'Expert'];
                        $clrMap = [1=>'text-success border-success/40',2=>'text-warning border-warning/40',3=>'text-orange-400 border-orange-400/40',4=>'text-primary border-primary/40'];
                    @endphp
                    <span class="text-[10px] font-mono font-bold border px-2 py-0.5 rounded {{ $clrMap[$article->level_id] ?? 'text-textDim border-borderStrong' }}">
                        {{ $lvlMap[$article->level_id] ?? 'N/A' }}
                    </span>
                </td>
                <td class="px-4 py-4 hidden lg:table-cell">
                    <span class="text-xs font-mono text-accent">{{ $article->read_time }}m</span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('tutorials.show', $article->slug) }}" target="_blank"
                           class="text-[10px] font-mono text-textDim hover:text-accent border border-borderStrong hover:border-accent px-2.5 py-1 rounded transition-all">VIEW</a>
                        <a href="{{ route('admin.articles.edit', $article) }}"
                           class="text-[10px] font-mono text-accent hover:text-white border border-accent/30 hover:border-accent px-2.5 py-1 rounded transition-all">EDIT</a>
                        <form method="POST" action="{{ route('admin.articles.destroy', $article) }}"
                              onsubmit="return confirm('Delete &quot;{{ addslashes($article->title) }}&quot;?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-[10px] font-mono text-primary hover:text-white border border-primary/30 hover:border-primary hover:bg-primary/20 px-2.5 py-1 rounded transition-all">DEL</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center text-textDim font-mono text-sm">
                    No articles found. <a href="{{ route('admin.articles.create') }}" class="text-primary hover:underline">Create one →</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($articles->hasPages())
<div class="flex justify-center">
    {{ $articles->links() }}
</div>
@endif
@endsection
