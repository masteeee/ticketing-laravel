{{-- resources/views/partials/footer.blade.php --}}
<style>
    /* Efek glow merah */
    .icon-hover img {
        transition: transform 0.3s ease, filter 0.3s ease, box-shadow 0.3s ease;
    }
    .icon-hover:hover img {
        transform: scale(1.1);
        filter: drop-shadow(0 0 10px red);
    }
</style>
<div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 p-1 bg-white-primary">
    <div class="flex items-center justify-center">
        <span class="text-sm font-medium">Follow us on :</span>
        <div class="flex space-x-2">
            {{-- Linkedin --}}
            <a href="https://www.linkedin.com/company/thriveconsultant/" target="_blank"
               class="icon-hover">
                <img src="https://www.keloola.com/app/assets/icon-linkedin.svg"
                     class="w-16 h-16 cursor-pointer" alt="Linkedin">
            </a>
            {{-- Instagram --}}
            <a href="https://www.instagram.com/thrive.itsolutions/" target="_blank"
               class="icon-hover">
                <img src="https://www.keloola.com/app/assets/icon-ig.svg"
                     class="w-16 h-16 cursor-pointer" alt="Instagram">
            </a>
            {{-- Youtube --}}
            <a href="https://www.youtube.com/playlist?list=PLkQosKGTL55_WzDqVKVe-2DeluOEacIe1" target="_blank"
               class="icon-hover">
                <img src="https://www.keloola.com/app/assets/icon-youtube.svg"
                     class="w-16 h-16 cursor-pointer" alt="Youtube">
            </a>
            {{-- Twitter/X --}}
            <a href="https://x.com/Thrive_Story/" target="_blank"
               class="icon-hover">
                <img src="https://www.keloola.com/app/assets/icon-x.svg"
                     class="w-16 h-16 cursor-pointer" alt="Twitter">
            </a>
        </div>
    </div>
</div>

<footer class="bg-section-footer text-txt-footer pt-4 pb-4">
    <div class="border-top border-secondary mt-4 pt-3 text-center small text-secondary">
        &copy; 2025 Keloola. All Rights Reserved
    </div>
</footer>
