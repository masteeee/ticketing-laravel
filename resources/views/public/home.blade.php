<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="{{ asset('dist/css/output.css') }}">
</head>
<body class="bg-gray-parent">
@include('layouts.guest')
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden">
               <div class="min-h-screen bg-white-primary">
                    <ul class="flex flex-col items-center justify-center space-y-4 py-8">
                         <li><a href="index.html" class="active text-black-keloola text-lg">Home</a></li>
                         <li><a href="knowledge.html" target="_blank" class="text-black-keloola text-lg">Knowledge
                                   Base</a></li>
                         <li><a href="#" class="text-black-keloola text-lg">Community</a></li>
                         <li><a href="#" class="text-black-keloola text-lg">Sign In</a></li>
                         <li class="relative">
                              <button id="mobile-language-button"
                                   class="text-black-keloola bg-gray-parent px-4 py-2 rounded text-lg hover:bg-gray-primary flex items-center">
                                   English <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M19 9l-7 7-7-7" />
                                   </svg>
                              </button>
                              <ul id="mobile-language-menu"
                                   class="hidden absolute mt-2 bg-white shadow rounded-md text-lg w-full">
                                   <li><a href="#" class="block px-4 py-2 hover:bg-gray-parent text-center">English</a>
                                   </li>
                                   <li><a href="#" class="block px-4 py-2 hover:bg-gray-parent text-center">Spanish</a>
                                   </li>
                                   <li><a href="#" class="block px-4 py-2 hover:bg-gray-parent text-center">French</a>
                                   </li>
                              </ul>
                         </li>
                    </ul>
               </div>
          </div>
     </nav>

     <!-- Search Section -->
     <section class="bg-search-section py-8">
          <div class="container mx-auto px-4">
               <div class="relative">
                    <div class="items-center space-x-4 hidden md:flex">
                         <div class="relative flex-1">
                              <!-- <input id="search-input" type="text" placeholder="Search articles"
                                             class="w-4/5 p-4 pr-32 border border-gray-primary outline-none"> -->
                              <input id="desktop-search-input" type="text" placeholder="Search articles"
                                   class="w-4/5 p-4 pr-32 border border-gray-primary outline-none">
                              <button id="desktop-search-dropdown"
                                   class="absolute right-[20%] top-0 h-full px-4 rounded-r-lg flex items-center hover:shadow-md">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M19 9l-7 7-7-7" />
                                   </svg>
                              </button>
                              <!-- Dropdown menu -->
                              <ul id="desktop-search-menu"
                                   class="absolute hidden right-[15%] mt-1 w-48 bg-white-primary shadow-md rounded-md z-50">
                                   <li><a href="#" class="block px-4 py-2 hover:text-blue-primary text-gray-700"
                                             data-placeholder="Search articles" data-value="kb">Knowledge Base</a></li>
                                   <li><a href="#" class="block px-4 py-2 hover:text-blue-primary"
                                             data-placeholder="Search community" data-value="community">Community</a>
                                   </li>
                              </ul>
                         </div>
                         <button
                              class="flex gap-1 text-primary font-semibold bg-white-primary px-4 py-3 rounded hover:text-blue-primary shadow-xl">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                   stroke="currentColor" class="w-5 h-5">
                                   <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                              </svg>
                              Add Topic
                         </button>
                    </div>
                    <!-- Mobile search -->
                    <div class="md:hidden">
                         <input id="mobile-search-input" type="text" placeholder="Search articles"
                              class="w-full p-4 border border-gray-primary outline-none rounded">
                         <button id="mobile-search-dropdown"
                              class="absolute right-0 top-0 h-full px-4 rounded-r-lg flex items-center hover:shadow-md">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none"
                                   viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                              </svg>
                         </button>
                         <!-- Mobile dropdown menu -->
                         <ul id="mobile-search-menu"
                              class="absolute hidden w-full mt-1 bg-white-primary shadow-md rounded-md z-50">
                              <li><a href="#" class="block px-4 py-2 hover:text-blue-primary text-gray-700"
                                        data-placeholder="Search articles" data-value="kb">Knowledge Base</a></li>
                              <li><a href="#" class="block px-4 py-2 hover:text-blue-primary"
                                        data-placeholder="Search community" data-value="community">Community</a>
                              </li>
                         </ul>
                         <div class="fixed bottom-6 right-6 z-50">
                              <button id="mobile-fab"
                                   class="w-14 h-14 bg-red-keloola text-white-primary rounded-full shadow-lg flex items-center justify-center">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                             d="M12 4.5v15m7.5-7.5h-15" />
                                   </svg>
                              </button>
                              <div id="fab-menu" class="absolute bottom-16 right-0 hidden flex-col gap-2 items-end">
                                   <div class="flex items-center gap-2">
                                        <span
                                             class="bg-white-primary flex flex-col px-3 py-2 rounded shadow-lg text-gray-txt">Add
                                             Topic</span>
                                        <button
                                             class="w-12 h-12 bg-white-primary text-blue-primary rounded-full shadow-lg flex items-center justify-center">
                                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                  stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                  <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                             </svg>
                                        </button>
                                   </div>
                              </div>
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
               <h2 class="flex flex-wrap items-center gap-1 text-2xl font-semibold mb-6">Departments <svg
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5 cursor-pointer">
                         <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                    </svg>
               </h2>
               <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
                    <div class="bg-white-primary shadow rounded-lg p-6">
                         <div class="flex flex-wrap border-b border-card-bor-keloola">
                              <img src="https://accounts.keloola.com/storage/27/accounting-logo.webp"
                                   alt="icon-keloola-accounting">
                              <a href="form.html" target="_blank" class="flex hover:text-primary cursor-pointer">
                                   <h3 class="text-lg font-semibold flex items-center">Keloola Accounting</h3>
                              </a>
                         </div>
                         <p class="text-black-keloola my-4">Automate Your Accounting</p>
                         <div class="mt-20">
                              <button
                                   class="border border-red-keloola text-red-keloola px-4 py-2 rounded font-medium hover:bg-red-keloola hover:text-white-primary">Submit
                                   Request</button>
                         </div>
                    </div>

                    <div class="bg-white-primary shadow rounded-lg p-6">
                         <div class="flex flex-wrap border-b border-card-bor-keloola">
                              <img src="https://accounts.keloola.com/storage/63/absensi-logo.webp"
                                   alt="icon-keloola-absensi">
                              <a href="form.html" target="_blank" class="flex hover:text-primary cursor-pointer">
                                   <h3 class="text-lg font-semibold flex items-center">Keloola Absensi</h3>
                              </a>
                         </div>
                         <p class="text-black-keloola my-4">Digital Attendance Made Easy</p>
                         <div class="mt-20">
                              <button
                                   class="border border-red-keloola text-red-keloola px-4 py-2 rounded font-medium hover:bg-red-keloola hover:text-white-primary">Submit
                                   Request</button>
                         </div>
                    </div>

                    <div class="bg-white-primary shadow rounded-lg p-6">
                         <div class="flex flex-wrap border-b border-card-bor-keloola">
                              <img src="https://accounts.keloola.com/storage/92/media-librarylAzwoS"
                                   alt="icon-keloola-book">
                              <a href="form.html" target="_blank" class="flex hover:text-primary cursor-pointer">
                                   <h3 class="text-lg font-semibold flex items-center">Keloola Book</h3>
                              </a>
                         </div>
                         <p class="text-black-keloola my-4">Interactive Flipbooks Made Easy</p>
                         <div class="mt-20">
                              <button
                                   class="border border-red-keloola text-red-keloola px-4 py-2 rounded font-medium hover:bg-red-keloola hover:text-white-primary">Submit
                                   Request</button>
                         </div>
                    </div>

                    <div class="bg-white-primary shadow rounded-lg p-6">
                         <div class="flex flex-wrap border-b border-card-bor-keloola">
                              <img src="https://accounts.keloola.com/storage/39/file-logo.webp" alt="icon-keloola-file">
                              <a href="form.html" target="_blank" class="flex hover:text-primary cursor-pointer">
                                   <h3 class="text-lg font-semibold flex items-center">Keloola File</h3>
                              </a>
                         </div>
                         <p class="text-black-keloola my-4">Secure Cloud Store for Legal Professinals</p>
                         <div class="mt-20">
                              <button
                                   class="border border-red-keloola text-red-keloola px-4 py-2 rounded font-medium hover:bg-red-keloola hover:text-white-primary">Submit
                                   Request</button>
                         </div>
                    </div>

                    <div class="bg-white-primary shadow rounded-lg p-6">
                         <div class="flex flex-wrap border-b border-card-bor-keloola">
                              <img src="https://accounts.keloola.com/storage/51/chat-logo.webp" alt="icon-keloola-chat">
                              <a href="form.html" target="_blank" class="flex hover:text-primary cursor-pointer">
                                   <h3 class="text-lg font-semibold flex items-center">Keloola Chat</h3>
                              </a>
                         </div>
                         <p class="text-black-keloola my-4">More Action, Less Email</p>
                         <div class="mt-20">
                              <button
                                   class="border border-red-keloola text-red-keloola px-4 py-2 rounded font-medium hover:bg-red-keloola hover:text-white-primary">Submit
                                   Request</button>
                         </div>
                    </div>

                    <div class="bg-white-primary shadow rounded-lg p-6">
                         <div class="flex flex-wrap border-b border-card-bor-keloola">
                              <img src="https://accounts.keloola.com/storage/1/xchange-logo.webp"
                                   alt="icon-keloola-chat">
                              <a href="form.html" target="_blank" class="flex hover:text-primary cursor-pointer">
                                   <h3 class="text-lg font-semibold flex items-center">Keloola Exchange</h3>
                              </a>
                         </div>
                         <p class="text-black-keloola my-4">Data Power Made Simple</p>
                         <div class="mt-20">
                              <button
                                   class="border border-red-keloola text-red-keloola px-4 py-2 rounded font-medium hover:bg-red-keloola hover:text-white-primary">Submit
                                   Request</button>
                         </div>
                    </div>
               </div>
          </div>
     </section>
     {{-- Footer --}}
     @include('layouts.footer')
    <script src="{{ asset('dist/js/app.js') }}"></script>
</body>
</html>
