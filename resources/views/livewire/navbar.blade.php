<nav class="navbar navbar-expand-md navbar-dark mb-4" id="main-nav">
    <div class="container-fluid">
        <div class="navbar-collapse justify-content-between" id="navbarCollapse">

            <ul class="navbar-nav">
                <li @class(['nav-item', 'active' => request()->routeIs("home")]) id="home">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li @class(['nav-item', 'active' => request()->routeIs("community")]) id="community">
                    <a class="nav-link" href="{{route('community')}}">Community</a>
                </li>

                <li @class(['nav-item', 'active' => request()->routeIs("favorites")]) id="favorites">
                    <a class="nav-link" href="{{ route('favorites') }}">Favorites</a>
                </li>
            </ul>

            <form class="d-flex" role="search" id="search-bar">
                <div class="input-wrapper">
                    <input type="text" placeholder="Search here" wire:keydown.debounce.300ms="search" wire:model="searchInput">
                    <i class="fa fa-search"></i>
                </div>
            </form>

            <div class="d-flex">
                <button type="submit" id="config">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                </button>
                <div id="drop-back" style="display: none;"></div>
                <div id="dropdown" class="dropdown-content" style="display: none;">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           Logout
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

@script
    <script>
        const config = document.getElementById('config');
        const dropdown = document.getElementById('dropdown');
        const dropback = document.getElementById('drop-back');

        toggleDropDown = () => {
            config.classList.toggle('remove-radius-bottom');
            if (dropdown.style.display === 'none') {
                dropdown.style.display = 'block';
                dropback.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
                dropback.style.display = 'none';
            }
        }

        config.addEventListener('click', toggleDropDown);
        dropback.addEventListener('click', toggleDropDown);
    </script>
@endscript
