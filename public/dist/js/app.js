// Mobile menu toggle
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

if (mobileMenuButton && mobileMenu) {
     mobileMenuButton.addEventListener('click', function () {
          mobileMenu.classList.toggle('hidden');
          document.body.style.overflow = mobileMenu.classList.contains('hidden') ? 'auto' : 'hidden';
     });
}

// Function Language dropdown toggle
function toggleLanguageMenu(buttonId, menuId) {
     const button = document.getElementById(buttonId);
     const menu = document.getElementById(menuId);

     if (button && menu) {
          button.addEventListener('click', function (e) {
               e.stopPropagation();
               menu.classList.toggle('hidden');
          });
     }
}

// Initialize language dropdowns
toggleLanguageMenu('desktop-language-button', 'desktop-language-menu');
toggleLanguageMenu('mobile-language-button', 'mobile-language-menu');

// Function Handle language selection
function handleLanguageChange(buttonId, menuId) {
     const button = document.getElementById(buttonId);
     const menu = document.getElementById(menuId);

     if (button && menu) {
          menu.addEventListener('click', function (e) {
               if (e.target.tagName === 'A') {
                    e.preventDefault();
                    const selectedLanguage = e.target.textContent.trim();

                    button.innerHTML = `${selectedLanguage} <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>`;
                    menu.classList.add('hidden');
               }
          });
     }
}

// Initialize language change handlers
handleLanguageChange('desktop-language-button', 'desktop-language-menu');
handleLanguageChange('mobile-language-button', 'mobile-language-menu');

// Function to handle dropdown toggle
function toggleDropdown(dropdownId, menuId) {
     const dropdown = document.getElementById(dropdownId);
     const menu = document.getElementById(menuId);

     if (dropdown && menu) {
          dropdown.addEventListener('click', function (e) {
               e.stopPropagation();
               menu.classList.toggle('hidden');
          });
     }
}

// Function to handle dropdown item selection
function handleDropdownSelection(inputId, menuId) {
     const menu = document.getElementById(menuId);
     const searchInput = document.getElementById(inputId);

     if (menu && searchInput) {
          menu.addEventListener('click', function (e) {
               if (e.target.tagName === 'A') {
                    e.preventDefault();

                    // Update placeholder
                    const newPlaceholder = e.target.getAttribute('data-placeholder');
                    searchInput.setAttribute('placeholder', newPlaceholder);

                    // Update active state
                    menu.querySelectorAll('a').forEach(item => {
                         item.classList.remove('text-blue-primary');
                    });
                    e.target.classList.add('text-blue-primary');

                    // Hide menu
                    menu.classList.add('hidden');
               }
          });
     }
}

// Initialize search dropdowns if elements exist
if (document.getElementById('desktop-search-dropdown')) {
     toggleDropdown('desktop-search-dropdown', 'desktop-search-menu');
     handleDropdownSelection('desktop-search-input', 'desktop-search-menu');
}

if (document.getElementById('mobile-search-dropdown')) {
     toggleDropdown('mobile-search-dropdown', 'mobile-search-menu');
     handleDropdownSelection('mobile-search-input', 'mobile-search-menu');
}

// Font size control functionality
let currentFontSize = 16;
const minFontSize = 12;
const maxFontSize = 24;

// Function update font size
function updateFontSize() {
     const fontSizeDisplay = document.getElementById('font-size-display');
     if (fontSizeDisplay) {
          document.body.style.fontSize = `${currentFontSize}px`;
          fontSizeDisplay.textContent = `${currentFontSize}px`;
     }
}

// Function update language size
function updateLanguageSize() {
     const languageButtons = document.querySelectorAll('#desktop-language-button, #mobile-language-button');
     languageButtons.forEach(button => {
          if (button) {
               button.style.fontSize = `${currentFontSize}px`;
          }
     });
}

// Font control event listeners
const fontButton = document.getElementById('font-button');
const fontMenu = document.getElementById('font-menu');
const decreaseFont = document.getElementById('decrease-font');
const increaseFont = document.getElementById('increase-font');

if (fontButton && fontMenu) {
     fontButton.addEventListener('click', function (e) {
          e.stopPropagation();
          fontMenu.classList.toggle('hidden');
     });
}

if (decreaseFont) {
     decreaseFont.addEventListener('click', function () {
          if (currentFontSize > minFontSize) {
               currentFontSize -= 2;
               updateFontSize();
               updateLanguageSize();
               saveFontSize();
          }
     });
}

if (increaseFont) {
     increaseFont.addEventListener('click', function () {
          if (currentFontSize < maxFontSize) {
               currentFontSize += 2;
               updateFontSize();
               updateLanguageSize();
               saveFontSize();
          }
     });
}

// Function save font size
function saveFontSize() {
     localStorage.setItem('fontSize', currentFontSize.toString());
}

// Function Layout Control
function updateGridClasses(element, removeClasses, addClasses) {
     if (element) {
          removeClasses.forEach(className => element.classList.remove(className));
          addClasses.forEach(className => element.classList.add(className));
     }
}

// Function generate layout
function applyLayoutPreference(layout) {
     const formSection = document.querySelector('.lg\\:w-3\\/4');
     const popularArticles = document.querySelector('.lg\\:w-1\\/4');
     const layout1Button = document.getElementById('layout-1');
     const layout2Button = document.getElementById('layout-2');

     if (formSection && popularArticles) {
          // Remove existing order classes
          formSection.classList.remove('order-1', 'order-2');
          popularArticles.classList.remove('order-1', 'order-2');

          if (layout === 'left') {
               formSection.classList.add('order-1');
               popularArticles.classList.add('order-2');
          } else {
               formSection.classList.add('order-2');
               popularArticles.classList.add('order-1');
          }

          // Visual feedback for buttons
          if (layout1Button && layout2Button) {
               if (layout === 'left') {
                    layout1Button.classList.add('border-primary');
                    layout2Button.classList.remove('border-primary');
               } else {
                    layout2Button.classList.add('border-primary');
                    layout1Button.classList.remove('border-primary');
               }
          }

          localStorage.setItem('departmentsLayout', layout);
     }
}

// Event listeners untuk tombol layout
const layout1Button = document.getElementById('layout-1');
const layout2Button = document.getElementById('layout-2');

if (layout1Button) {
     layout1Button.addEventListener('click', function () {
          applyLayoutPreference('left');
     });
}

if (layout2Button) {
     layout2Button.addEventListener('click', function () {
          applyLayoutPreference('right');
     });
}

// Full width toggle
const fullWidthToggle = document.getElementById('full-width-toggle');
const toggleCircle = document.getElementById('toggle-circle');
const departmentsSection = document.querySelector('.departments-container');

if (fullWidthToggle && toggleCircle && departmentsSection) {
     fullWidthToggle.addEventListener('change', function () {
          if (this.checked) {
               departmentsSection.classList.remove('container', 'mx-auto');
               departmentsSection.classList.add('w-full', 'px-8');
               toggleCircle.classList.add('translate-x-7', 'bg-primary');
               localStorage.setItem('isFullWidth', 'true');
          } else {
               departmentsSection.classList.add('container', 'mx-auto');
               departmentsSection.classList.remove('w-full', 'px-8');
               toggleCircle.classList.remove('translate-x-7', 'bg-primary');
               localStorage.setItem('isFullWidth', 'false');
          }
     });
}

// Load saved preferences when page loads
document.addEventListener('DOMContentLoaded', function () {
     // Layout preference
     const savedLayout = localStorage.getItem('departmentsLayout');
     if (savedLayout) {
          applyLayoutPreference(savedLayout);
     }

     // Full width preference
     const isFullWidth = localStorage.getItem('isFullWidth');
     if (isFullWidth === 'true' && fullWidthToggle) {
          fullWidthToggle.checked = true;
          fullWidthToggle.dispatchEvent(new Event('change'));
     }

     // Font size preference
     const savedFontSize = localStorage.getItem('fontSize');
     if (savedFontSize) {
          currentFontSize = parseInt(savedFontSize);
          updateFontSize();
          updateLanguageSize();
     }
});

// Close dropdowns when clicking outside
document.addEventListener('click', function () {
     // Dapatkan referensi elemen
     const desktopLanguageMenu = document.getElementById('desktop-language-menu');
     const mobileLanguageMenu = document.getElementById('mobile-language-menu');
     const searchMenu = document.getElementById('search-menu');
     const fontMenu = document.getElementById('font-menu');

     // Cek dan sembunyikan menu jika elemen ada
     if (desktopLanguageMenu) {
          desktopLanguageMenu.classList.add('hidden');
     }
     if (mobileLanguageMenu) {
          mobileLanguageMenu.classList.add('hidden');
     }
     if (searchMenu) {
          searchMenu.classList.add('hidden');
     }
     if (fontMenu) {
          fontMenu.classList.add('hidden');
     }
});

// Floating action button Add Request & Add Category
const mobileFab = document.getElementById('mobile-fab');
const fabMenu = document.getElementById('fab-menu');

if (mobileFab && fabMenu) {
     mobileFab.addEventListener('click', function () {
          fabMenu.classList.toggle('hidden');
     });
}
