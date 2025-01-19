<title><?=$_SESSION['nameAll'] ?? null ?></title>
<header>
        <nav>
            <div class="logo">
                <div class="icon">
                    <i class="fa-duotone fa-solid fa-user"></i>
                </div>
                <div class="text">
                    <samp><?= env('APP_NAME'); ?></samp>
                </div>
            </div>
            <div class="users">
                <div class="icon">
                    <img src=" images/logo.png" alt="">
                </div>
                <div class="text">
                    <samp><?=$_SESSION['nameAll'] ?? null?></samp>
                </div>

            </div>
        </nav>
    </header>