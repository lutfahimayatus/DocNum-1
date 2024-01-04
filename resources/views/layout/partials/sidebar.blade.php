<div class="scrollable-sidebar" style="max-height: 80vh; overflow-y: auto;">
    <section class="sidebar">
        <div class="logo-details">
            <a href="#">
                <i class='bx bx-menu' ></i>
            </a>
            <a class="logo" href="{{route('dashboard')}}">
                <img src="{{ asset('assets/img/logo.png')}}" alt="" class="logo-name">
            </a>
        </div>
        <ul class="nav-links">
            <li @if (Route::currentRouteName() == 'dashboard') class="active" @endif>
                <a href="{{ route('dashboard')}}">
                    <i class='bx bxs-home' ></i>
                    <div class="item-container"> 
                        <span class="link_name">Home</span>
                    </div>
                </a>
            </li>
            @if (Auth::user()->role == 'administrator')
            <li @if (Route::currentRouteName() == 'div.index' || Route::currentRouteName() == 'user.index' || Route::currentRouteName() == 'cat.index' || Route::currentRouteName() == 'jenis.index') class="active" @endif>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bxs-file'></i>
                        <div class="item-container"> 
                            <span class="link_name">Data Master</span>
                            <i style="margin-left: 53px; font-size: 20px;" class='bx bx-chevron-down arrow'></i>
                        </div>
                    </a>
                    <ul class="sub-menu">
                        <li @if (Route::currentRouteName() == 'user.index') class="active" @endif>
                            <a style="width: 140px;" class="link_name" href="{{ route('user.index') }}">Pengguna</a>
                        </li>
                        <li @if (Route::currentRouteName() == 'cat.index') class="active" @endif>
                            <a style="width: 140px;" href="{{ route('cat.index')}}">Kategori Dokumen</a>
                        </li>
                        <li @if (Route::currentRouteName() == 'jenis.index') class="active" @endif>
                            <a style="width: 140px;" href="{{ route('jenis.index')}}">Jenis Dokumen</a>
                        </li>
                        <li @if (Route::currentRouteName() == 'div.index') class="active" @endif>
                            <a style="width: 140px;" href="{{ route('div.index')}}">Divisi</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li @if (Route::currentRouteName() == 'document.index') class="active" @endif>
                <a href="{{ route('document.index')}}">
                    <i class='bx bx-history'></i>
                    <div class="item-container"> 
                        <span class="link_name">Riwayat Dokumen</span>
                    </div>
                </a>
            </li>
            <li @if (Route::currentRouteName() == 'log.index') class="active" @endif>
                <a href="{{ route('log.index') }}">
                    <i class='bx bxs-comment-minus'></i>
                    <div class="item-container"> 
                        <span class="link_name">Log Activity</span>
                    </div>
                </a>
            </li>
            @else
            <li @if (Route::currentRouteName() == 'employee.document' || Route::currentRouteName() == 'employee.generate' || Route::currentRouteName() == 'employee.detail' || Route::currentRouteName() == 'employee.document.update') class="active" @endif>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bxs-file'></i>
                        <div class="item-container"> 
                            <span class="link_name">Dokumen</span>
                            <i style="margin-left: 70px; font-size: 20px;" class='bx bx-chevron-down arrow'></i>
                        </div>
                    </a>
                    <ul class="sub-menu">
                        <li @if (Route::currentRouteName() == 'employee.generate') class="active" @endif>
                            <a style="width: 140px;" href="{{ route('employee.generate')}}">Generate No. Dokumen</a>
                        </li>
                        <li @if (Route::currentRouteName() == 'employee.document' || Route::currentRouteName() == 'employee.detail' || Route::currentRouteName() == 'employee.document.update') class="active" @endif>
                            <a style="width: 140px;" href="{{ route('employee.document')}}">Riwayat Dokumen</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            <li @if (Route::currentRouteName() == 'profile' || Route::currentRouteName() == 'profile.change.password') class="active" @endif>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-cog' ></i>
                        <div class="item-container"> 
                            <span class="link_name">Pengaturan</span>
                            <i style="margin-left: 58px; font-size: 20px;" class='bx bx-chevron-down arrow'></i>
                        </div>
                    </a>
                    <ul class="sub-menu">
                        <li @if (Route::currentRouteName() == 'profile') class="active" @endif>
                            <a style="width: 140px;" class="link_name" href="{{ route('profile', encrypt(Auth::user()->id)) }}">Edit Profil</a>
                        </li>
                        <li @if (Route::currentRouteName() == 'profile.change.password') class="active" @endif>
                            <a style="width: 140px;" class="link_name" href="{{ route('profile.change.password', encrypt(Auth::user()->id)) }}">Ganti Kata Sandi</a>
                        </li>
                        <li>
                            <a style="width: 140px;" class="link_name" href="{{ route('logout') }}" onclick="event.preventDefault(); showLogoutConfirmation()">Keluar</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // jQuery script to handle sidebar collapse/expand and toggle sub-menu
    $(document).ready(function () {
        // Toggle the 'collapsed' class when the menu icon is clicked
        $('.logo-details a').click(function () {
            $('.sidebar').toggleClass('collapsed');
        });

        // Show/hide sub-menu on clicking a menu item, logo, arrow, or menu icon
        $('.nav-links .icon-link a, .logo-details a.logo, .icon-link .arrow').click(function (e) {
            e.preventDefault();
            var $submenu = $(this).next('.sub-menu');
            if ($submenu.length > 0) {
                $submenu.toggleClass('showMenu');
            } else {
                // If there is no sub-menu, navigate to the specified route
                var href = $(this).attr('href');
                if (href) {
                    window.location.href = href;
                }
            }
        });

        // Add a click event listener to the text container for menu items
        $('.nav-links .icon-link .item-container').click(function (e) {
            e.preventDefault();
            var $submenu = $(this).siblings('.sub-menu');
            if ($submenu.length > 0) {
                $submenu.toggleClass('showMenu');
            }
        });

        // Add a click event listener to the arrow for showing/hiding sub-menu
        $('.nav-links .icon-link .arrow').click(function (e) {
            e.preventDefault();
            var $submenu = $(this).closest('.icon-link').find('.sub-menu');
            if ($submenu.length > 0) {
                $submenu.toggleClass('showMenu');
                
                // Calculate the position of the sub-menu
                var containerWidth = $('.icon-link .item-container').outerWidth();
                var arrowWidth = $('.icon-link .arrow').outerWidth();
                var totalWidth = containerWidth + arrowWidth;
                
                // Set the position of the sub-menu
                $submenu.css('left', totalWidth);
            }
        });

        function showLogoutConfirmation() {
        var isConfirmed = confirm("Apakah Anda yakin ingin keluar?");
        if (isConfirmed) {
            window.location.href = "{{ route('logout') }}";
        }
    }    
    });
</script>
