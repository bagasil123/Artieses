<link rel="stylesheet" href="{{ asset('css/partses/topbares.css') }}">
<link rel="stylesheet" href="{{ asset('css/partses/sidebares.css') }}">
<header class="top-navbar">
    <img src="{{ asset('partses/icouth.png') }}" alt="artieses, artiekeles" class="brandes"/>
    <div class="search-wrapper">
        <form action="{{ route('appes.searches') }}" method="POST" class="search-form">
            @csrf
            <input type="text" name="search" id="search-input" placeholder="Cari sesuatu..." required />
            <button type="button" id="clear-btn">&times;</button>
        </form>
    </div>
    <a href="javascript:void(0);" id="profile-icon">
        
    @if(session('isLoggedIn'))
        @php
            $path = implode('/', [session('username'), 'profil', session('improfil')]);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
        @endphp
        @if(in_array($ext, ['gif', 'png', 'jpg', 'jpeg', 'webp']))
            <img src="{{ asset($path) ?? asset('partses/logincon.png') }}" alt="Profile" class="improfiles" loading="lazy" data-light="{{ asset($path) ?? asset('partses/logincon.png') }}" data-dark="{{ asset($path) ?? asset('partses/loginconlm.png') }}"/>
        @endif
    @else
        <img src="{{ asset('partses/logincon.png') }}" alt="Profile" class="improfiles" loading="lazy" data-light="{{ asset('partses/logincon.png') }}" data-dark="{{ asset('partses/loginconlm.png') }}"/>
    @endif
    </a>
        <div class="cardprof" id="cardprof">
            <div class="button-list">
                @if(session('isLoggedIn'))
                    <button class="button-group" onclick="window.location.href='/profile'">
                        <span>{{ session('username') }}</span>
                        @php
                            $path = implode('/', [session('username'), 'profil', session('improfil')]);
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($ext, ['gif', 'png', 'jpg', 'jpeg', 'webp']))
                            <img src="{{ asset($path) }}" alt="Profile" style="width:40px; height:40px;">
                        @endif
                    </button>
                @else
                    <button class="button-group" onclick="window.location.href='/logineses'">
                        <span>Login</span>
                        <img alt="Login" loading="lazy" data-light="{{ session('improfil') ?? asset('partses/logincon.png') }}" data-dark="{{ session('improfil') ?? asset('partses/loginconlm.png') }}">
                    </button>
                @endif
                <button class="button-group tm">
                    <span id="mode-text" data-dark="Dark Mode" data-light="Light Mode"></span>
                    <img class="icon-img" loading="lazy"
                        data-light="{{ asset('partses/togglel.png') }}" 
                        data-dark="{{ asset('partses/toggled.png') }}"alt="Toggle Mode">
                </button>
            </div>
        </div>
        <button class="toggle-mode" data-mode="light">
            <img class="icon-img" data-light="{{ asset('partses/togglel.png') }}" 
                data-dark="{{ asset('partses/toggled.png') }}" alt="Toggle Mode" loading="lazy">
        </button>
        <button class="toggle-mode hidden" data-mode="dark">
            <img class="icon-img" 
                data-light="{{ asset('partses/togglel.png') }}" 
                data-dark="{{ asset('partses/toggled.png') }}" alt="Toggle Mode" loading="lazy">
        </button>
</header>
<body>
<nav class="sidebar">
    <a href="{{ url('/') }}" class="nav-item">
        <img class="icon-img" loading="lazy"
            data-light="{{ asset('partses/hlm.png') }}"
            data-dark="{{ asset('partses/hdm.png') }}">
        <span>Home</span>
    </a>
    <a href="javascript:void(0);" class="nav-item" id="buates">
        <img class="icon-img" loading="lazy" data-light="{{ asset('partses/alm.png') }}" data-dark="{{ asset('partses/adm.png') }}">
        <span>Buat</span>
    </a>
    <div class="cardbu" id="cardbu">
        <button id="show-artiekeles" class="nav-item">
            <img class="icon-img" loading="lazy" data-light="{{ asset('partses/artiekeles.png') }}" data-dark="{{ asset('partses/artiekelesdm.png') }}">
            <span>Artiekeles</span>
        </button>
        @include('appes.artiekeles')
        <button id="show-artievides" class="nav-item">
            <img class="icon-img" loading="lazy" data-light="{{ asset('partses/artievides.png') }}" data-dark="{{ asset('partses/artievidesdm.png') }}">
            <span>Artievides</span>
        </button>
        @include('appes.artievides')
        <button id="show-artiestories" class="nav-item">
            <img class="icon-img" loading="lazy" data-light="{{ asset('partses/artiestories.png') }}" data-dark="{{ asset('partses/artiestoriesdm.png') }}">
            <span>Artiestories</span>
        </button>
        @include('appes.artiestories')
    </div> 
    <div class="carlert" id="carlert" style="{{ session('alert') ? 'display: block;' : 'display: none;' }}">
        @if(session('alert'))
            <div class="feedback error">
                {{ session('alert') }}
            </div>
        @endif
    </div>
    <a href="#" class="nav-item">
        <img class="icon-img" loading="lazy"
            data-light="{{ asset('partses/slm.png') }}"
            data-dark="{{ asset('partses/sdm.png') }}">
        <span>Settings</span>
    </a>
    @if(session('isLoggedIn'))
        <a href="{{ url('/logout') }}" class="nav-item">
            <img class="icon-img" loading="lazy"
                data-light="{{ asset('partses/llm.png') }}"
                data-dark="{{ asset('partses/ldm.png') }}">
            <span>Logout</span>
        </a>
    @elseif(!session('isLoggedIn'))
        <a href="{{ url('/logineses') }}" class="nav-item">
            <img class="icon-img" loading="lazy"
                data-light="{{ asset('partses/llm.png') }}"
                data-dark="{{ asset('partses/ldm.png') }}">
            <span>Login</span>
        </a>
    @endif
</nav>
</body>
<script src="{{ asset('js/appes/artieses.js') }}"></script>
<script src="{{ asset('js/partses/topbares.js') }}"></script>
<script src="{{ asset('js/partses/sidebares.js') }}"></script>