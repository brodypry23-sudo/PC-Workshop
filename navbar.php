<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isset($_SESSION['userId']);
$currentPage = basename($_SERVER['PHP_SELF']);

if (!function_exists('navLink')) {
    function navLink(string $file, string $label, string $current): void {
        $active = ($file === $current);
        echo '<li class="nav-item"><a class="nav-link' . ($active ? ' active' : '') . '" href="' . $file . '"'
            . ($active ? ' aria-current="page"' : '') . '>' . $label . '</a></li>';
    }
}
?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark website-navbar sticky-top">
            <div class="container">

                <a class="navbar-brand" href="index.php">PC-Workshop</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navContent" aria-controls="navContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navContent">
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <?php
                        navLink('index.php', 'Home', $currentPage);
                        navLink('about.php', 'About', $currentPage);
                        navLink('posts.php', 'Posts', $currentPage);

                        if ($loggedIn) {
                            echo '<li class="nav-item"><span class="nav-user">Hi, '
                                . htmlspecialchars($_SESSION['userName'] ?? 'builder') . '</span></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="lib/logout.lib.php">Log out</a></li>';
                        } else {
                            navLink('login.php', 'Login', $currentPage);
                            navLink('signup.php', 'Signup', $currentPage);
                        }
                        ?>
                    </ul>
                </div>

            </div>
        </nav>
    </header>
