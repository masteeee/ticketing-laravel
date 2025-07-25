@extends('layouts.guest')

@section('content')
<div class="bg-gray-900 min-h-screen py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-center mb-4" style="color: #dc3545; font-size: 2.5rem; font-weight: 900; font-family: Segoe UI, Tahoma, 'Geneva', Verdana, sans-serif;">
                Knowledge Base
            </h1>
            <div class="flex justify-center mb-4">
                <form method="GET" action="" class="w-full max-w-xl">
                    <input type="text" name="search" id="search-input" value="{{ $keyword ?? '' }}" placeholder="Search articles" class="w-full border border-gray-700 bg-gray-800 text-gray-100 rounded-md px-4 py-2 focus:outline-none focus:ring" autocomplete="off" />
                </form>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 shadow">
            @php
            function renderCategoryTreeDark($categories, $level = 0)
            {
                foreach ($categories as $cat) {
                    $hasChildren = $cat->children && $cat->children->count();
                    $hasArticles = $cat->articles && $cat->articles->count();
                    $hasContent = $hasChildren || $hasArticles;
                    $catId = 'cat-' . $cat->id;

                    echo '<div class="ml-'.($level * 4).' mb-3">';
                    echo '<div class="bg-gray-700 rounded-lg shadow px-4 py-3 cursor-pointer flex items-center justify-between category-header transition-colors duration-200 hover:bg-gray-600" data-target="'.$catId.'">';

                    echo '<div class="flex items-center gap-2">';
                    if ($hasContent) {
                        echo '<span class="text-white toggle-icon" data-icon="'.$catId.'">›</span>';
                    }
                    echo '<span class="text-white font-medium">'.$cat->name.'</span>';
                    echo '</div>';

                    echo '</div>';

                    if ($hasContent) {
                        echo '<div class="tree-children mt-3 pl-6 hidden" id="'.$catId.'">';

                        if ($hasArticles) {
                            echo '<div class="space-y-2 mb-2">';
                            foreach ($cat->articles as $art) {
                                echo '<a href="'.route('articles.show', $art->id).'" class="flex items-center gap-3 bg-gray-800 text-gray-100 rounded px-3 py-2 shadow hover:bg-gray-700 transition">';
                                if ($art->thumbnail) {
                                    echo '<img src="'.asset("storage/".$art->thumbnail).'" alt="'.$art->title.'" class="w-10 h-10 rounded object-cover"/>';
                                }
                                echo '<div class="text-sm font-medium">'.$art->title.'</div>';
                                echo '</a>';
                            }
                            echo '</div>';
                        }

                        if ($hasChildren) {
                            renderCategoryTreeDark($cat->children, $level + 1);
                        }

                        echo '</div>';
                    }

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

<!-- Artikel Terbaru & Populer -->
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.category-header').forEach(header => {
        header.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const target = document.getElementById(targetId);
            const icon = this.querySelector('.toggle-icon');

            if (target) {
                const isOpen = !target.classList.contains('hidden');
                target.classList.toggle('hidden');

                // Ubah ikon dari › ke ˅ dan sebaliknya
                if (icon) {
                    icon.textContent = isOpen ? '›' : '˅';
                }
            }
        });
    });
});
</script>
@endpush
