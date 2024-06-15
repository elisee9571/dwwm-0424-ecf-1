<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">E-commerce</a>
        <ul class="nav gap-2">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="cart.php">Cart</a>
                </li>

                <div class="dropdown dropdown-profile">
                    <button class="btn btn-outline-white dropdown-toggle rounded-1 text-muted" type="button"
                            id="dropdown-menu-profile" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $_SESSION['user_email'] ?>
                    </button>
                    <ul class="dropdown-menu rounded-1" aria-labelledby="dropdown-menu-profile">
                        <li>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <li class="nav-item">
                    <a href="login.php" class="btn btn-primary">Sign in</a>
                </li>
                <li class="nav-item">
                    <a href="register.php" class="btn btn-outline-secondary">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
