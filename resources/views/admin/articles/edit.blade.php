@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded p-4">
        <h1 class="text-xl font-bold mb-4">Edit Artikel</h1>

        <form action="{{ route('articles.update', $article->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ $article->title }}" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label fw-semibold">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $article->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label fw-semibold">Thumbnail</label><br>
                @if($article->thumbnail)
                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" width="120" class="mb-2 rounded shadow-sm"><br>
                @endif
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="content" class="form-label fw-semibold">Konten <span class="text-red-500">*</span></label>
                <textarea id="summernote" name="content" class="form-control">{!! $article->content !!}</textarea>
                <div id="content-error" class="text-danger small d-none">Konten wajib diisi</div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-danger">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
 
<style>
    /* Biar bullet & numbering muncul meski pakai Tailwind */
    .note-editor .note-editable ul {
        list-style-type: disc !important;
        list-style-position: outside !important;
        margin-left: 1.25rem !important;
        padding-left: 1.25rem !important;
    }
    .note-editor .note-editable ol {
        list-style-type: decimal !important;
        list-style-position: outside !important;
        margin-left: 1.25rem !important;
        padding-left: 1.25rem !important;
    }
    .note-editor .note-editable li {
        display: list-item !important;
    }
    /* Nested lists */
    .note-editor .note-editable ul ul,
    .note-editor .note-editable ol ul {
        list-style-type: circle !important;
    }
    .note-editor .note-editable ul ol,
    .note-editor .note-editable ol ol {
        list-style-type: lower-alpha !important;
    }
    /* As a last resort, revert Tailwind resets inside editor */
    .note-editor .note-editable ul,
    .note-editor .note-editable ol {
        list-style: revert !important;
        margin: revert !important;
        padding: revert !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<!-- Modal Bootstrap untuk Table Properties -->
<div class="modal fade" id="tablePropsModal" tabindex="-1" aria-labelledby="tablePropsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white py-2">
        <h5 class="modal-title" id="tablePropsModalLabel">Table Properties</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Kiri: Opsi -->
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Border Width (px)</label>
              <input type="number" id="tableBorderWidth" class="form-control" min="0" value="1">
            </div>
            <div class="mb-3">
              <label class="form-label">Border Color</label>
              <input type="color" id="tableBorderColor" class="form-control form-control-color" value="#dee2e6">
            </div>
            <div class="mb-3">
              <label class="form-label">Border Style</label>
              <select id="tableBorderStyle" class="form-select">
                <option value="solid">Solid</option>
                <option value="dashed">Dashed</option>
                <option value="dotted">Dotted</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Background Color</label>
              <input type="color" id="tableBgColor" class="form-control form-control-color" value="#ffffff">
            </div>
          </div>

          <!-- Kanan: Preview -->
          <div class="col-md-8">
            <label class="form-label fw-bold">Preview:</label>
            <div class="border p-2 bg-light" style="overflow-x:auto;">
              <table id="tablePreview" class="w-100 text-center"></table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-warning btn-sm" id="resetTableProps">Reset Default</button>
        <button type="button" class="btn btn-danger btn-sm" id="applyTableProps">Apply</button>
      </div>
    </div>
  </div>
</div>

<script>
    let selectedTable = null;
    let tablePropsModal = null;

    function rgbToHex(rgb) {
        if (!rgb || rgb === 'transparent') return '#000000';
        const m = rgb.match(/\d+/g);
        if (!m) return '#000000';
        return "#" + m.slice(0, 3).map(v => {
            const h = parseInt(v, 10).toString(16);
            return h.length === 1 ? "0" + h : h;
        }).join('');
    }

    function updatePreview() {
        const width = parseInt($('#tableBorderWidth').val(), 10) || 1;
        const color = $('#tableBorderColor').val() || '#dee2e6';
        const style = $('#tableBorderStyle').val() || 'solid';
        const bg    = $('#tableBgColor').val() || '#ffffff';

        const $preview = $('#tablePreview');
        $preview.css({
            'border-collapse': 'collapse',
            'border': `${width}px ${style} ${color}`
        });

        $preview.find('th, td').each(function(){
            $(this).css({
                'border': `${width}px ${style} ${color}`,
                'background-color': bg
            });
        });
    }

    function cloneTableToPreview($table) {
        const $preview = $('#tablePreview');
        $preview.empty();

        $table.find('tr').each(function(){
            const $row = $('<tr></tr>');
            $(this).children().each(function(){
                const cellTag = this.tagName.toLowerCase();
                const styles = $(this).attr('style') || '';
                const content = $(this).html() || '&nbsp;';
                $row.append(`<${cellTag} style="${styles}">${content}</${cellTag}>`);
            });
            $preview.append($row);
        });

        updatePreview();
    }

    $(function () {
        // Init Summernote
        $('#summernote').summernote({
            placeholder: 'Tulis konten artikel di sini...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['custom', ['tableProperties']]
            ],
            buttons: {
                tableProperties: TablePropertiesButton
            }
        });

        tablePropsModal = new bootstrap.Modal(document.getElementById('tablePropsModal'));

        $('#tableBorderWidth, #tableBorderColor, #tableBorderStyle, #tableBgColor')
            .on('input change', updatePreview);

        $('#applyTableProps').on('click', function () {
            if (!selectedTable) return;

            const width = parseInt($('#tableBorderWidth').val(), 10) || 1;
            const color = $('#tableBorderColor').val() || '#dee2e6';
            const style = $('#tableBorderStyle').val() || 'solid';
            const bg    = $('#tableBgColor').val() || '#ffffff';

            selectedTable.css({
                'border-collapse': 'collapse',
                'border': `${width}px ${style} ${color}`
            });

            selectedTable.find('th, td').each(function(){
                $(this).css({
                    'border': `${width}px ${style} ${color}`,
                    'background-color': bg
                });
            });

            tablePropsModal.hide();
        });

        $('#resetTableProps').on('click', function () {
            if (!selectedTable) return;

            selectedTable.removeAttr('style').removeClass().addClass('table table-bordered');

            selectedTable.find('th, td').each(function(){
                $(this).removeAttr('style');
            });

            cloneTableToPreview(selectedTable);
        });

        // 🚀 VALIDASI konten wajib diisi
        $('form').on('submit', function(e) {
            let content = $('#summernote').summernote('isEmpty') ? '' : $('#summernote').summernote('code');
            let cleanContent = $('<div>').html(content).text().trim();

            if (cleanContent === '' || content === '<p><br></p>') {
                e.preventDefault();
                $('#content-error').removeClass('d-none');
                return false;
            } else {
                $('#content-error').addClass('d-none');
            }
        });

        // Hilangkan error kalau user mulai ngetik
        $('#summernote').on('summernote.change', function() {
            $('#content-error').addClass('d-none');
        });
    });

    function TablePropertiesButton(context) {
        const ui = $.summernote.ui;
        return ui.button({
            contents: '<i class="note-icon-magic"></i> Table Props',
            tooltip: 'Table Properties',
            click: function () {
                const $table = $(context.invoke('editor.createRange').commonAncestor()).closest('table');
                if (!$table.length) {
                    alert('Pilih tabel terlebih dahulu untuk mengubah properties.');
                    return;
                }
                selectedTable = $table;

                const $firstCell = $table.find('th, td').first();
                const cs = window.getComputedStyle($firstCell[0]);

                $('#tableBorderWidth').val(parseInt(cs.borderTopWidth, 10) || 1);
                $('#tableBorderColor').val(rgbToHex(cs.borderTopColor) || '#dee2e6');
                $('#tableBorderStyle').val(cs.borderTopStyle || 'solid');
                $('#tableBgColor').val(rgbToHex(cs.backgroundColor) || '#ffffff');

                cloneTableToPreview($table);
                tablePropsModal.show();
            }
        }).render();
    }
</script>

@endpush