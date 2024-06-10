<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="style2.css">


</head>
<body>


    <nav class="navbar navbar-expand-md navbar-dark mb-4" id="main-nav">
        <div class="container-fluid">
          <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">

            <ul class="navbar-nav">

              <li class="nav-item" id="home">
                <a class="nav-link" href="#">Home</a>
              </li>


              <li class="nav-item" id="community">
                <a class="nav-link" href="#">Community</a>
              </li>


              <li class="nav-item" id="favorites">
                <a class="nav-link" href="#">Favorites</a>
              </li>


            </ul>

            <form class="d-flex"role="search" id="search-bar">
                <div class="input-wrapper">
                    <input type="text" placeholder="search...">
                    <i class="fa fa-search"></i>
                </div>
            </form>

            <div class="d-flex">
              <button class="btn btn-outline-success" type="submit" id="config">
                    <span class="material-symbols-outlined">
                    settings
                    </span>
                </button>
            </div>

          </div>
        </div>
    </nav>
</body>
</html>


