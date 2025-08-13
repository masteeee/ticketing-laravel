@extends('layouts.guest')

@section('title', 'Submit a Request')

@section('content')
<section class="bg-form-section py-5">
    <div class="departments-container container mx-auto px-4">
        <div class="bg-section-text-form p-4 border border-section-bor-form rounded-md my-4 flex lg:w-[73.5%] md:w-full">
            <h2 class="lg:text-xl sm:text-sm font-semibold">Keloola Corporation's Help Center is hosted in our US data center</h2>
        </div>
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Form kiri -->
            <div class="lg:w-3/4 bg-white-primary border border-section-bor rounded-md">
                <div class="p-6">
                    <h1 class="text-3xl font-semibold mb-6">Submit a request</h1>
                    <h4 class="text-xl font-semibold my-10">Request Information</h4>

                    {{-- Error Laravel --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <strong class="font-bold">Terjadi kesalahan:</strong>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="space-y-6" action="{{ route('ticket.public.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Department -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Department <span class="text-red-keloola">*</span></label>
                            <select name="department_id" id="department_id" class="w-full p-3 border border-section-bor rounded-md" required>
                                <option value="">-- Pilih Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ (old('department_id') == $dept->id || $selectedDepartment == $dept->id) ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Contact Name -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Contact Name <span class="text-red-keloola">*</span></label>
                            <input name="contact_name" type="text" class="w-full p-2 border border-section-bor rounded-md" value="{{ old('contact_name') }}" required />
                            @error('contact_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Service -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Service <span class="text-red-keloola">*</span></label>
                            <select name="service_id" id="service_id" class="w-full p-3 border border-section-bor rounded-md" required>
                                <option value="">-- Silahkan Pilih Department terlebih dahulu --</option>
                            </select>
                            @error('service_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Email <span class="text-red-keloola">*</span></label>
                            <input name="email" type="email" class="w-full p-2 border border-section-bor rounded-md" value="{{ old('email') }}" required />
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Phone</label>
                            <input name="phone" type="text" class="w-full p-2 border border-section-bor rounded-md" value="{{ old('phone') }}" />
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Subject <span class="text-red-keloola">*</span></label>
                            <input name="subject" type="text" class="w-full p-2 border border-section-bor rounded-md" value="{{ old('subject') }}" required />
                            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Description</label>
                            <textarea name="description" class="w-full p-2 border border-section-bor rounded-md min-h-[200px]">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Attachment -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Attach a file</label>
                            <input name="attachment" type="file" class="w-full p-2 border rounded-md" />
                            <small>(Up to 40 MB)</small>
                            @error('attachment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit -->
                        <div class="flex gap-4">
                            <button type="submit" id="submit-ticket-btn" class="bg-red-keloola text-white-primary px-6 py-2 flex items-center justify-center gap-2">
                                <span id="submit-ticket-text">SUBMIT</span>
                                <span id="submit-ticket-spinner" class="hidden animate-spin">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                </span>
                            </button>
                            <a href="/" class="bg-primary text-white-primary px-6 py-2">DISCARD</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar kanan -->
            <div class="lg:w-1/4">
                <div class="mt-3">
                    <h2 class="text-xl font-semibold mb-4">Popular Articles</h2>
                    <ul class="space-y-4">
                        @forelse ($popularArticles as $article)
                            <li>
                                <a href="{{ route('public.articles.show', $article->slug) }}" class="flex items-start gap-2 text-black-keloola hover:text-blue-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" />
                                    </svg>
                                    {{ $article->title }}
                                </a>
                            </li>
                        @empty
                            <li><span class="text-gray-500">Tidak ada artikel populer</span></li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts.footer')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function loadServices(deptId) {
            $('#service_id').empty().append('<option>Loading...</option>');
            if (deptId) {
                $.ajax({
                    url: `/get-services/${deptId}`,
                    method: 'GET',
                    success: function(data) {
                        $('#service_id').empty().append('<option value="">-- Pilih Layanan --</option>');
                        data.forEach(function(service) {
                            $('#service_id').append(`<option value="${service.id}">${service.name}</option>`);
                        });
                    },
                    error: function() {
                        $('#service_id').empty().append('<option value="">-- Tidak dapat memuat layanan --</option>');
                    }
                });
            } else {
                $('#service_id').empty().append('<option value="">-- Pilih Department dulu --</option>');
            }
        }

        $('#department_id').on('change', function() {
            const deptId = $(this).val();
            loadServices(deptId);
        });

        const selectedDeptId = $('#department_id').val();
        if (selectedDeptId) {
            loadServices(selectedDeptId);
        }
    });
</script>
@endsection
