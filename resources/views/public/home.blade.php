@extends('layouts.guest')

@section('content')

<!-- Search Section -->
<section class="bg-search-section py-8">
     <div class="container mx-auto px-4">
          <div class="relative">
               <!-- Desktop search -->
               <div class="items-center space-x-4 hidden md:flex">
                    <div class="relative flex-1">
                         <form id="desktop-search-form" action="{{ route('knowledge.search') }}" method="GET" class="w-full">
                              <div class="w-full flex items-center border border-gray-primary rounded-lg overflow-hidden">
                                   <input id="desktop-search-input" name="search" type="text" placeholder="Search articles"
                                        class="flex-1 px-4 py-4 outline-none border-0 focus:ring-0">
                                   <button type="submit" id="desktop-search-dropdown" style="background: white"
                                        class="px-4 py-4 text-gray-500 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 
                                                       1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                        </svg>
                                   </button>
                              </div>
                         </form>
                    </div>
               </div>

               <!-- Mobile search -->
               <div class="md:hidden relative mt-4">
                    <form id="mobile-search-form" action="{{ route('knowledge.search') }}" method="GET" class="w-full">
                         <div class="w-full flex items-center border border-gray-primary rounded-lg overflow-hidden">
                              <input id="mobile-search-input" name="search" type="text" placeholder="Search articles"
                                   class="flex-1 px-4 py-4 outline-none border-0 focus:ring-0">
                              <button type="submit" id="mobile-search-dropdown" style="background: white"
                                   class="px-4 py-4 text-gray-500 hover:text-gray-700">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                             d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 
                                                  1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                   </svg>
                              </button>
                         </div>
                    </form>

                    <!-- Floating Action Button (Mobile Only) -->
                    <div class="fixed bottom-6 right-6 z-50">
                         <button id="mobile-fab"
                              class="w-14 h-14 bg-red-keloola text-white-primary rounded-full shadow-lg flex items-center justify-center">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                              stroke-width="2" stroke="currentColor" class="w-8 h-8">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                   d="M12 4.5v15m7.5-7.5h-15" />
                              </svg>
                         </button>
                    </div>
               </div>
          </div>
     </div>

     <!-- Breadcrumb -->
     <div class="container mx-auto px-4 py-4">
          <div class="text-sm text-primary">
               <a href="#" class="text-primary">My Area</a>
               <span class="mx-2 text-icon-breadcrumb">/</span>
               <span class="text-icon-breadcrumb">Submit a Request</span>
          </div>
     </div>
</section>

<!-- Departments Section -->
<section class="bg-form-section py-10">
     <div class="departments-container container mx-auto px-4">
         <h2 class="text-2xl md:text-3xl text-black-keloola font-bold mb-4">
             Departments
         </h2>
         <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
             @foreach($departments as $department)
                 <div class="bg-white-primary shadow rounded-lg p-6">
                     <div class="flex flex-wrap border-b border-card-bor-keloola mb-4 pb-2 gap-4">
                         @if($department->logo_url)
                         <img src="{{ asset('storage/' . $department->logo_url) }}" style="object-fit:cover;" alt="icon-{{ Str::slug($department->name) }}" class="w-20 h-20 mr-2 rounded-full object-cover">
                         @endif 
                           <h3 class="text-lg font-semibold flex items-center">{{ $department->name }}</h3>
                         {{-- <a href="{{ route('ticket.create', ['department' => $department->id]) }}" target="_blank" class="hover:text-primary cursor-pointer">
                          
                         </a> --}}
                     </div>
                     <p class="text-black-keloola my-4">{{ $department->description }}</p>
                     <div class="mt-8">
                         <a href="{{ route('ticket.create', ['department' => $department->id]) }}" target="_blank">
                             <button class="border border-red-keloola text-red-keloola px-4 py-2 rounded font-medium hover:bg-red-keloola hover:text-white-primary transition">
                                 Submit Request
                             </button>
                         </a>
                     </div>
                 </div>
             @endforeach
         </div>
     </div>
 </section>
 
{{-- Footer --}}
@include('layouts.footer')
<script src="{{ asset('dist/js/app.js') }}"></script>
<script>
// Submit search on enter (desktop)
document.getElementById('desktop-search-input').addEventListener('keydown', function(e) {
    if(e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('desktop-search-form').submit();
    }
});
// Submit search on enter (mobile)
document.getElementById('mobile-search-input').addEventListener('keydown', function(e) {
    if(e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('mobile-search-form').submit();
    }
});
</script>
@endsection
