@extends('layouts.guest')

@section('content')
<div class="bg-gray-900 min-h-screen py-10" style="padding: 50px;">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-100 mb-4">Knowledge Base</h1>
            <div class="flex justify-center mb-4">
                <form method="GET" action="" class="w-full max-w-xl">
                    <input type="text" name="search" id="search-input" value="{{ $keyword ?? '' }}" placeholder="Search articles" class="w-full border border-gray-700 bg-gray-800 text-gray-100 rounded-md px-4 py-2 focus:outline-none focus:ring" autocomplete="off" />
                </form>
            </div>
            <div class="relative inline-block text-left mb-6">
                <div id="dropdownMenu" class="origin-top-left absolute left-0 mt-2 w-72 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50 hidden max-h-96 overflow-auto">
                    <ul class="py-1 text-gray-100 text-sm">
                        @php
                        function renderDropdownTreeWithArticles($categories, $level = 0) {
                            foreach($categories as $cat) {
                                $hasChildren = $cat->children && $cat->children->count();
                                $hasArticles = $cat->articles && $cat->articles->count();
                                echo '<li class="pl-'.($level*16).'">';
                                if($hasChildren) {
                                    echo '<button type="button" class="dropdown-toggle w-full flex items-center py-1 px-2 hover:bg-gray-700 rounded focus:outline-none" data-target="dropdown-cat-'.$cat->id.'">▸ <span class=\'ml-2\'>'.$cat->name.'</span></button>';
                                    echo '<ul class="ml-4 hidden" id="dropdown-cat-'.$cat->id.'">';
                                    renderDropdownTreeWithArticles($cat->children, $level+1);
                                    echo '</ul>';
                                } else {
                                    echo '<a href="#cat-'.$cat->id.'" class="block py-1 px-2 hover:bg-gray-700 rounded">'.$cat->name.'</a>';
                                }
                                // Artikel di bawah kategori
                                if($hasArticles) {
                                    echo '<ul class="ml-4">';
                                    foreach($cat->articles as $art) {
                                        echo '<li class="flex items-center px-2 py-1 hover:bg-gray-700 rounded transition">';
                                        echo '<span class="mr-2">📝</span>';
                                        echo '<a href="'.route('articles.show', $art->id).'" class="text-gray-200 hover:text-blue-400">'.$art->title.'</a>';
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                }
                                echo '</li>';
                            }
                        }
                        @endphp
                        @if($categories->count())
                            @php renderDropdownTreeWithArticles($categories->where('parent_id', null)); @endphp
                        @else
                            <li class="px-4 py-2 text-gray-400">Tidak ada kategori</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-6 shadow p-4 mt-4">
            @php
                function renderCategoryTreeDark($categories, $level = 0) {
                    foreach($categories as $cat) {
                        $hasChildren = $cat->children && $cat->children->count();
                        $catId = 'cat-'.$cat->id;
                        echo '<div class="ml-'.($level*16).'">';
                        echo '<div class="flex items-center w-full px-2 py-1 rounded group '.($level==0?'mt-2':'').'">';
                        if($hasChildren) {
                            echo '<button type="button" class="toggle-tree bg-gray-700 text-gray-300 rounded w-6 h-6 flex items-center justify-center mr-2 focus:outline-none" data-target="'.$catId.'">▸</button>';
                        } else {
                            echo '<span class="w-6 h-6 mr-2 flex items-center justify-center">📁</span>';
                        }
                        echo '<span class="font-medium text-gray-100">'.$cat->name.'</span>';
                        echo '</div>';
                        echo '<div class="pl-8">';
                        if($cat->articles->count()) {
                            echo '<ul class="mb-2">';
                            foreach($cat->articles as $art) {
                                echo '<li class="flex items-center px-2 py-1 hover:bg-gray-700 rounded transition">';
                                echo '<span class="mr-2">📝</span>';
                                echo '<a href="'.route('articles.show', $art->id).'" class="text-gray-200 hover:text-blue-400">'.$art->title.'</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        }
                        if($hasChildren) {
                            echo '<div class="tree-children" id="'.$catId.'" style="display:none;">';
                            renderCategoryTreeDark($cat->children, $level+1);
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
            @endphp
            <div class="space-y-2">
                @if($categories->count())
                    @php renderCategoryTreeDark($categories->where('parent_id', null)); @endphp
                @else
                    <p class="text-gray-400">Tidak ada kategori tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Artikel Terbaru & Populer tetap di bawah -->
<div class="bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Artikel Terbaru -->
        <div>
            <h2 class="text-md font-semibold mb-4">Recent Articles</h2>
            <ul class="bg-white p-6 rounded-lg shadow space-y-2 text-sm">
                @forelse($recentArticles as $article)
                    <li class="border-b pb-2">{{ $article->title }}</li>
                @empty
                    <li>Tidak ada artikel terbaru.</li>
                @endforelse
            </ul>
        </div>
        <!-- Artikel Populer -->
        <div>
            <h2 class="text-md font-semibold mb-4">Popular Articles</h2>
            <ul class="bg-white p-6 rounded-lg shadow space-y-2 text-sm">
                @forelse($popularArticles as $article)
                    <li class="border-b pb-2">{{ $article->title }}</li>
                @empty
                    <li>Tidak ada artikel populer.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('dist/js/app.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debounce search
    let timer;
    document.getElementById('search-input').addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            this.form.submit();
        }, 400);
    });
    // Tree-view expand/collapse
    document.querySelectorAll('.toggle-tree').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = document.getElementById(this.dataset.target);
            if(target.style.display === 'none' || target.style.display === '') {
                target.style.display = 'block';
                this.textContent = '▾';
            } else {
                target.style.display = 'none';
                this.textContent = '▸';
            }
        });
    });
    // Dropdown multi-level
    const dropdownBtn = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');
    dropdownBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
    });
    document.addEventListener('click', function(e) {
        if (!dropdownMenu.contains(e.target) && e.target !== dropdownBtn) {
            dropdownMenu.classList.add('hidden');
        }
    });
    document.querySelectorAll('.dropdown-toggle').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const target = document.getElementById(this.dataset.target);
            if(target.classList.contains('hidden')) {
                target.classList.remove('hidden');
                this.textContent = this.textContent.replace('▸', '▾');
            } else {
                target.classList.add('hidden');
                this.textContent = this.textContent.replace('▾', '▸');
            }
        });
    });
    // Scroll to tree-view category on click
    document.querySelectorAll('#dropdownMenu a[href^="#cat-"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('href').substring(1);
            const el = document.getElementById(id);
            if(el) {
                el.scrollIntoView({behavior: 'smooth', block: 'center'});
            }
            dropdownMenu.classList.add('hidden');
        });
    });
});
</script>
@endpush
