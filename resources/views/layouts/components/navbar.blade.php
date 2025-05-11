<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">My Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ $slug == 'home' ? 'active' : '' }}" aria-current="page" href="{{ url('/')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $slug == 'posts' ? 'active' : '' }}" href="{{ url('posts') }}">Postingan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $slug == 'category_post' ? 'active' : '' }}" href="{{ url('category_post')}}">Kategori</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if (auth()->user()->role_id == 1)
                                <li><a class="dropdown-item" href="{{ url('admin/user') }}">Data Pengguna</a></li>
                                <li><a class="dropdown-item" href="{{ url('admin/category_post') }}">Data Kategori Postingan</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ url('account') }}">Profil Pengguna</a></li>
                            <li><a class="dropdown-item" href="{{ url('user/posts') }}">Data Postingan</a></li>
                            <li><a class="dropdown-item logout-url" href="{{ url('logout') }}">Logout</a></li>
                        </ul>
                    </li>   
                @else
                    <li class="nav-item">
                        <a href="{{ url('login') }}" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('register') }}" class="nav-link">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>