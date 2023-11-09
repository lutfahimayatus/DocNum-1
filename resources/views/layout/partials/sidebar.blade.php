<div class="scrollable-sidebar">
    <section class="sidebar">
        <div class="logo-details">
            <a href="#">
                <i class='bx bx-menu' ></i>
            </a>
            <img src="{{ asset('assets/img/logo.png')}}" alt="" class="logo-name">
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
            <li @if (Route::currentRouteName() == 'user.index' || Route::currentRouteName() == 'cat.index' || Route::currentRouteName() == 'jenis.index') class="active" @endif>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bxs-file'></i>
                        <div class="item-container"> 
                            <span class="link_name">Data Master</span>
                            <i class='bx bx-chevron-down arrow'></i>
                        </div>
                    </a>
                    <ul class="sub-menu">
                        <li @if (Route::currentRouteName() == 'user.index') class="active" @endif>
                            <a class="link_name" href="{{ route('user.index') }}">Pengguna</a>
                        </li>
                        <li @if (Route::currentRouteName() == 'cat.index') class="active" @endif>
                            <a href="{{ route('cat.index')}}">Kategori Dokumen</a>
                        </li>
                        <li @if (Route::currentRouteName() == 'jenis.index') class="active" @endif>
                            <a href="{{ route('jenis.index')}}">Jenis Dokumen</a>
                        </li>
                        <li @if (Route::currentRouteName() == 'div.index') class="active" @endif>
                            <a href="{{ route('div.index')}}">Divisi</a>
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
                            <i class='bx bx-chevron-down arrow'></i>
                        </div>
                    </a>
                    <ul class="sub-menu">
                        <li @if (Route::currentRouteName() == 'employee.generate') class="active" @endif>
                            <a href="{{ route('employee.generate')}}">Generate No. Dokumen</a>
                        </li>
                        <li @if (Route::currentRouteName() == 'employee.document' || Route::currentRouteName() == 'employee.detail' || Route::currentRouteName() == 'employee.document.update') class="active" @endif>
                            <a href="{{ route('employee.document')}}">Riwayat Dokumen</a>
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
                            <i class='bx bx-chevron-down arrow'></i>
                        </div>
                    </a>
                    <ul class="sub-menu">
                        <li @if (Route::currentRouteName() == 'profile') class="active" @endif>
                            <a class="link_name" href="{{ route('profile', Auth::user()->id) }}">Edit Profil</a></li>
                        <li @if (Route::currentRouteName() == 'profile.change.password') class="active" @endif>
                            <a class="link_name" href="{{ route('profile.change.password', Auth::user()->id) }}">Ganti Kata Sandi</a></li>
                        <li>
                            <a class="link_name" href="{{ route('logout') }}">Keluar</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </section>
</div>