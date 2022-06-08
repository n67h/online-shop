    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- custom css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- latest fontawesome -->
    <script src="https://kit.fontawesome.com/1216c1ba01.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php">Online Shop</a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon navbar-dark"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="mx-auto">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Test</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Test</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Test</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Test</a>
                    </li>

                    <li class="nav-item dropdown">
                        <?php
                            if(isset($_SESSION['id'])){
                                $user_id = $_SESSION['id'];
                                $sql = "SELECT * FROM users WHERE user_id = $user_id;";
                                $result = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_assoc($result)){
                                        $f_name = $row['f_name'];
                                        $l_name = $row['l_name'];
                                    }
                                }
                                echo '<a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.$f_name. ' ' .$l_name.'</a>';
                                echo '
                                <ul class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item text-white" href="#">My Account</a></li>
                                    <li><a class="dropdown-item text-white" href="#">My Purchase</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-white" href="includes/logout.inc.php">Log out</a></li>
                                ';
                            }else {
                                echo '<a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>';
                                echo '
                                <ul class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item text-white" href="login.php">Log in</a></li>
                                    <li><a class="dropdown-item text-white" href="registration.php">Register</a></li>
                                </ul>
                                ';
                            }
                        ?>
                    </li>
                    <!-- <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                    </li> -->
                </ul>
            </div>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
        </div>
    </div>
    </nav>
    <!-- end of navbar -->