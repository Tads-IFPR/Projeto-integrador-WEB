<nav class="navbar navbar-expand-md navbar-dark mb-4" id="main-nav">

    <div class="container-fluid">
        <div class="navbar-collapse justify-content-between" id="navbarCollapse">

            <ul class="navbar-nav">
                <li @class(['nav-item', 'active' => request()->routeIs("home")]) id="home">
                    <a class="nav-link" href="#">Home</a>
                </li>

                <li @class(['nav-item', 'active' => request()->routeIs("community")]) id="community">
                    <a class="nav-link" href="#">Community</a>
                </li>

                <li @class(['nav-item', 'active' => request()->routeIs("favorites")]) id="favorites">
                    <a class="nav-link" href="#">Favorites</a>
                </li>
            </ul>

            <form class="d-flex"role="search" id="search-bar">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
                <div class="input-wrapper">
                    <input type="text" placeholder="Search here">
                    <i class="fa fa-search"></i>
                </div>
            </form>

            <div class="d-flex">
                <button type="submit" id="config">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                </button>
            </div>

        </div>
    </div>
</nav>
