@extends('layouts.admin')
@section('title', isset($article) ? 'Edit Article' : 'New Article')
@section('page-title', isset($article) ? '~/admin/articles/'.$article->slug.'/edit' : '~/admin/articles/create')

@section('content')
@php $editing = isset($article); @endphp

<form id="article-form"
      method="POST"
      action="{{ $editing ? route('admin.articles.update', $article) : route('admin.articles.store') }}"
      class="space-y-6">
    @csrf
    @if($editing) @method('PUT') @endif

    {{-- Validation errors --}}
    @if($errors->any())
    <div class="bg-primary/10 border border-primary/40 rounded-xl p-4">
        <p class="text-primary font-bold font-mono text-sm mb-2">Validation errors:</p>
        <ul class="space-y-1">
            @foreach($errors->all() as $err)
            <li class="text-primary/80 font-mono text-xs">• {{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid xl:grid-cols-2 gap-6">

        {{-- ── LEFT: Form ───────────────────────────────────────────────── --}}
        <div class="space-y-5">

            {{-- Title --}}
            <div>
                <label class="admin-label" for="title">Title *</label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $article->title ?? '') }}"
                       placeholder="e.g. Setting Up NGINX on Debian 12"
                       class="admin-input" required>
            </div>

            {{-- Slug --}}
            <div>
                <label class="admin-label" for="slug">Slug <span class="text-textDim normal-case">(auto-generated from title if empty)</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-textDim font-mono text-sm">/tutorials/</span>
                    <input type="text" id="slug" name="slug"
                           value="{{ old('slug', $article->slug ?? '') }}"
                           placeholder="nginx-setup-debian-12"
                           class="admin-input pl-[90px]">
                </div>
            </div>

            {{-- Row: Category + Author --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="admin-label" for="category">Category *</label>
                    <input type="text" id="category" name="category"
                           value="{{ old('category', $article->category ?? '') }}"
                           list="category-suggestions"
                           placeholder="e.g. Debian Server"
                           class="admin-input" required>
                    <datalist id="category-suggestions">
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="admin-label" for="author">Author *</label>
                    <input type="text" id="author" name="author"
                           value="{{ old('author', $article->author ?? 'naldrahiqa') }}"
                           placeholder="naldrahiqa"
                           class="admin-input" required>
                </div>
            </div>

            {{-- Row: Level + Read time --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="admin-label" for="level_id">Difficulty Level *</label>
                    <select id="level_id" name="level_id" class="admin-input" required>
                        @php $lvl = old('level_id', $article->level_id ?? 2); @endphp
                        <option value="1" {{ $lvl == 1 ? 'selected' : '' }}>1 — Beginner</option>
                        <option value="2" {{ $lvl == 2 ? 'selected' : '' }}>2 — Intermediate</option>
                        <option value="3" {{ $lvl == 3 ? 'selected' : '' }}>3 — Advanced</option>
                        <option value="4" {{ $lvl == 4 ? 'selected' : '' }}>4 — Expert</option>
                    </select>
                </div>
                <div>
                    <label class="admin-label" for="read_time">Read Time (min) *</label>
                    <input type="number" id="read_time" name="read_time" min="1" max="999"
                           value="{{ old('read_time', $article->read_time ?? 5) }}"
                           class="admin-input" required>
                </div>
            </div>

            {{-- Excerpt --}}
            <div>
                <label class="admin-label" for="excerpt">Excerpt / Short Description *</label>
                <textarea id="excerpt" name="excerpt" rows="3"
                          placeholder="A brief summary of what this tutorial covers…"
                          class="admin-input resize-none" required>{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
            </div>

            {{-- Content editor --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="admin-label mb-0" for="content">Content (HTML) *</label>
                    <div class="flex items-center gap-2">
                        <button type="button" id="insert-h2"    class="cli-insert-btn" data-insert="&lt;h2&gt;Heading 2&lt;/h2&gt;\n">H2</button>
                        <button type="button" id="insert-h3"    class="cli-insert-btn" data-insert="&lt;h3&gt;Heading 3&lt;/h3&gt;\n">H3</button>
                        <button type="button" id="insert-code"  class="cli-insert-btn" data-insert="&lt;pre&gt;&lt;code class=&quot;language-bash&quot;&gt;command here&lt;/code&gt;&lt;/pre&gt;\n">CODE</button>
                        <button type="button" id="insert-note"  class="cli-insert-btn" data-insert="&lt;blockquote&gt;📝 Note: text here&lt;/blockquote&gt;\n">NOTE</button>
                        <button type="button" id="insert-p"     class="cli-insert-btn" data-insert="&lt;p&gt;Paragraph text here.&lt;/p&gt;\n">P</button>
                    </div>
                </div>
                <textarea id="content" name="content" rows="22"
                          placeholder="Write HTML content here. Use &lt;h2&gt;, &lt;h3&gt;, &lt;p&gt;, &lt;pre&gt;&lt;code&gt;, &lt;ul&gt;&lt;li&gt;, &lt;strong&gt;, &lt;a&gt;, etc."
                          class="admin-input resize-y font-mono text-xs leading-relaxed" required>{{ old('content', $article->content ?? '') }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 bg-primary text-white font-black font-mono text-sm rounded-lg shadow-[0_0_15px_rgba(255,0,127,0.35)] border border-primary hover:bg-bgDeep hover:text-primary transition-all">
                    {{ $editing ? '⚡ UPDATE ARTICLE' : '⚡ PUBLISH ARTICLE' }}
                </button>
                <a href="{{ route('admin.articles') }}"
                   class="py-3 px-6 bg-bgElevated border border-borderStrong text-textDim hover:text-textNormal font-bold font-mono text-sm rounded-lg transition-all">
                    Cancel
                </a>
            </div>
        </div>

        {{-- ── RIGHT: Live Preview ──────────────────────────────────────── --}}
        <div class="flex flex-col gap-5">

            {{-- Article Meta Preview --}}
            <div class="bg-bgCard border border-borderSoft rounded-xl overflow-hidden">
                <div class="px-5 py-3 border-b border-borderSoft flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-primary shadow-[0_0_6px_rgba(255,0,127,0.8)]"></div>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-textDim">Article Meta Preview</span>
                </div>
                <div class="p-5 space-y-3">
                    <p id="prev-title" class="text-xl font-black text-textBright leading-tight">&mdash;</p>
                    <p id="prev-excerpt" class="text-sm text-textDim leading-relaxed">&mdash;</p>
                    <div class="flex flex-wrap gap-3 mt-3">
                        <span class="text-[10px] font-mono border px-2 py-0.5 rounded" id="prev-level">Level: —</span>
                        <span class="text-[10px] font-mono text-warning" id="prev-cat">Category: —</span>
                        <span class="text-[10px] font-mono text-accent" id="prev-read">—min read</span>
                        <span class="text-[10px] font-mono text-textDim" id="prev-author">by —</span>
                    </div>
                </div>
            </div>

            {{-- CLI Terminal Preview --}}
            <div class="cli-box flex-1 flex flex-col overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3 border-b border-borderStrong shrink-0">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-success/80"></div>
                    </div>
                    <span class="text-textDim text-[10px] font-mono">article://live-preview</span>
                    <div class="flex items-center gap-2">
                        <button type="button" id="tab-preview"
                                onclick="switchTab('preview')"
                                class="preview-tab-btn active-tab text-[10px] font-mono px-3 py-1 rounded">PREVIEW</button>
                        <button type="button" id="tab-source"
                                onclick="switchTab('source')"
                                class="preview-tab-btn text-[10px] font-mono px-3 py-1 rounded">SOURCE</button>
                    </div>
                </div>

                {{-- Preview pane --}}
                <div id="pane-preview" class="flex-1 overflow-y-auto p-6">
                    <div id="live-preview-content" class="prose prose-sm max-w-none text-textNormal">
                        <p class="text-textDim font-mono text-xs">← Start typing in the content editor to see live preview…</p>
                    </div>
                </div>

                {{-- Source pane --}}
                <div id="pane-source" class="hidden flex-1 overflow-y-auto">
                    <pre class="!m-0 !rounded-none !border-0 !p-6 text-xs h-full overflow-auto"><code id="source-code" class="language-html text-xs leading-relaxed break-all whitespace-pre-wrap"></code></pre>
                </div>
            </div>

            {{-- CLI Command Cheatsheet --}}
            <div class="cli-box p-5">
                <p class="text-[10px] font-bold font-mono uppercase tracking-widest text-textDim mb-3">HTML Snippet Reference</p>
                <div class="space-y-1.5 text-xs font-mono text-textDim">
                    <p><span class="text-success">&lt;h2&gt;</span> Section heading</p>
                    <p><span class="text-success">&lt;h3&gt;</span> Sub-heading (cyan styled)</p>
                    <p><span class="text-accent">&lt;pre&gt;&lt;code class="language-bash"&gt;</span> Code block</p>
                    <p><span class="text-warning">&lt;blockquote&gt;</span> Note / tip callout</p>
                    <p><span class="text-primary">&lt;strong&gt;</span> Bold / emphasis</p>
                    <p><span class="text-textNormal">&lt;ul&gt;&lt;li&gt;</span> Unordered list</p>
                    <p><span class="text-textNormal">&lt;ol&gt;&lt;li&gt;</span> Ordered list</p>
                    <p><span class="text-textNormal">&lt;a href=""&gt;</span> Hyperlink</p>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .cli-insert-btn {
        font-family: 'JetBrains Mono', monospace;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 4px;
        border: 1px solid #444b6a;
        color: #787c99;
        background: #1e2130;
        cursor: pointer;
        transition: all 0.15s;
    }
    .cli-insert-btn:hover {
        border-color: #00e5ff;
        color: #00e5ff;
    }
    .preview-tab-btn {
        border: 1px solid transparent;
        color: #787c99;
        transition: all 0.15s;
        cursor: pointer;
        background: transparent;
    }
    .preview-tab-btn:hover { color: #a9b1d6; }
    .preview-tab-btn.active-tab {
        border-color: #444b6a;
        color: #a9b1d6;
        background: #1e2130;
    }

    /* Prose overrides inside preview */
    #live-preview-content h2 { color: #ffffff; font-weight: 800; font-size: 1.15rem; margin: 1.5rem 0 0.6rem; }
    #live-preview-content h3 { color: #00e5ff; font-weight: 700; font-size: 1rem; margin: 1.2rem 0 0.5rem; border-bottom: 1px solid #2a2e42; padding-bottom: 0.3rem; }
    #live-preview-content p  { color: #a9b1d6; margin: 0.6rem 0; line-height: 1.7; }
    #live-preview-content code { color: #ff007f; background: rgba(255,0,127,0.1); padding: 0.15rem 0.35rem; border-radius: 3px; font-size: 0.8rem; }
    #live-preview-content pre { background: #090a0f; border: 1px solid #2a2e42; border-radius: 6px; padding: 1rem; margin: 0.8rem 0; }
    #live-preview-content pre code { background: transparent; color: #a9b1d6; padding: 0; }
    #live-preview-content blockquote { border-left: 3px solid #ff007f; background: #1e2130; padding: 0.5rem 1rem; margin: 0.8rem 0; border-radius: 0 4px 4px 0; color: #787c99; }
    #live-preview-content strong { color: #ffffff; }
    #live-preview-content ul { color: #a9b1d6; padding-left: 1.4rem; margin: 0.6rem 0; }
    #live-preview-content ol { color: #a9b1d6; padding-left: 1.4rem; margin: 0.6rem 0; }
    #live-preview-content li { margin: 0.25rem 0; }
    #live-preview-content a  { color: #00e5ff; }
</style>
@endsection

@section('scripts')
<script>
// ── Level label/color map ───────────────────────────────────────────────
const levelMap = {
    '1': { label: 'Beginner',     cls: 'text-green-400 border-green-400' },
    '2': { label: 'Intermediate', cls: 'text-yellow-400 border-yellow-400' },
    '3': { label: 'Advanced',     cls: 'text-orange-500 border-orange-500' },
    '4': { label: 'Expert',       cls: 'text-primary border-primary shadow-[0_0_8px_rgba(255,0,127,0.6)]' },
};

// ── Live content preview ────────────────────────────────────────────────
const contentTA = document.getElementById('content');
const previewDiv = document.getElementById('live-preview-content');
const sourceCode = document.getElementById('source-code');

function updatePreview() {
    const html = contentTA.value;
    previewDiv.innerHTML = html || '<p class="text-textDim font-mono text-xs">← Start typing in the content editor to see live preview…</p>';
    sourceCode.textContent = html;
    if (window.Prism) Prism.highlightElement(sourceCode);
}

contentTA.addEventListener('input', updatePreview);

// ── Meta preview fields ─────────────────────────────────────────────────
function bind(id, elId, transform) {
    const input = document.getElementById(id);
    const el    = document.getElementById(elId);
    if (!input || !el) return;
    input.addEventListener('input', () => { el.textContent = transform ? transform(input.value) : (input.value || '—'); });
}

bind('title',     'prev-title');
bind('excerpt',   'prev-excerpt');
bind('category',  'prev-cat',   v => 'Category: ' + (v || '—'));
bind('read_time', 'prev-read',  v => (v || '—') + 'min read');
bind('author',    'prev-author',v => 'by ' + (v || '—'));

document.getElementById('level_id').addEventListener('change', function() {
    const el  = document.getElementById('prev-level');
    const map = levelMap[this.value] || { label: '—', cls: 'text-textDim border-borderStrong' };
    el.textContent = 'Level: ' + map.label;
    el.className   = 'text-[10px] font-mono border px-2 py-0.5 rounded ' + map.cls;
});

// ── Tab switching ───────────────────────────────────────────────────────
function switchTab(tab) {
    document.getElementById('pane-preview').classList.toggle('hidden', tab !== 'preview');
    document.getElementById('pane-source').classList.toggle('hidden',  tab !== 'source');
    document.getElementById('tab-preview').classList.toggle('active-tab', tab === 'preview');
    document.getElementById('tab-source').classList.toggle('active-tab',  tab === 'source');
    if (tab === 'source' && window.Prism) Prism.highlightElement(sourceCode);
}

// ── Insert snippet buttons ──────────────────────────────────────────────
document.querySelectorAll('.cli-insert-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const snippet = btn.dataset.insert.replace(/\\n/g, '\n');
        const start   = contentTA.selectionStart;
        const end     = contentTA.selectionEnd;
        const val     = contentTA.value;
        contentTA.value = val.substring(0, start) + snippet + val.substring(end);
        contentTA.selectionStart = contentTA.selectionEnd = start + snippet.length;
        contentTA.focus();
        updatePreview();
    });
});

// ── Auto-generate slug from title ───────────────────────────────────────
const titleInput = document.getElementById('title');
const slugInput  = document.getElementById('slug');
let   slugTouched = slugInput.value.length > 0;

slugInput.addEventListener('input', () => { slugTouched = true; });
titleInput.addEventListener('input', () => {
    document.getElementById('prev-title').textContent = titleInput.value || '—';
    if (!slugTouched) {
        slugInput.value = titleInput.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    }
});

// ── Initial render ──────────────────────────────────────────────────────
updatePreview();
// Pre-fill meta preview from existing values (edit mode)
['title','excerpt','category','read_time','author'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.dispatchEvent(new Event('input'));
});
document.getElementById('level_id').dispatchEvent(new Event('change'));
</script>
@endsection
