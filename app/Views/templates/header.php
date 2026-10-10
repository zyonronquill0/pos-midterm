<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'POS Application') ?></title>
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    body {
        background-color: #f8fafc;
        color: #1e293b;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    header {
        background-color: #0f172a;
        color: #ffffff;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    header a.brand {
        color: #ffffff;
        font-size: 1.25rem;
        font-weight: 700;
        text-decoration: none;
    }

    nav {
        display: flex;
        gap: 1.25rem;
        align-items: center;
    }

    nav a {
        color: #cbd5e1;
        text-decoration: none;
        font-size: 0.95rem;
        transition: color 0.2s;
    }

    nav a:hover {
        color: #ffffff;
    }

    .btn-auth-login {
        background-color: #0284c7;
        color: #ffffff !important;
        padding: 0.4rem 0.9rem;
        border-radius: 4px;
        font-weight: 500;
    }

    .btn-auth-logout {
        background-color: #ef4444;
        color: #ffffff !important;
        padding: 0.4rem 0.9rem;
        border-radius: 4px;
        font-weight: 500;
    }

    .user-greeting {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .user-greeting strong {
        color: #f8fafc;
    }

    main {
        flex: 1;
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }
    </style>
</head>

<body>
    <header>
        <a href="<?= base_url() ?>" class="brand">POS Complete System</a>
        <nav>
            <a href="<?= base_url() ?>">Home</a>
            <a href="<?= base_url('about') ?>">About</a>

            <?php if (session()->get('isLoggedIn')): ?>
            <a href="<?= base_url('sales') ?>">Sales</a>
            <a href="<?= base_url('products') ?>">Products</a>
            <a href="<?= base_url('customers') ?>">Customers</a>
            <a href="<?= base_url('users') ?>">Staff</a>
            <span class="user-greeting">Signed in as <strong><?= esc(session()->get('username')) ?></strong></span>
            <a href="<?= base_url('logout') ?>" class="btn-auth-logout">Logout</a>
            <?php else: ?>
            <a href="<?= base_url('login') ?>" class="btn-auth-login">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>