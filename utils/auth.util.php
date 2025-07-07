<?php

declare(strict_types=1);

include_once UTILS_PATH . "/envSetter.util.php";

class Auth
{
    /**
     * Initialize session if not already started
     */
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Attempt login; returns true if successful
     */
    public static function login(PDO $pdo, string $username, string $password): bool
    {
        self::init();
        try {
            // 1) Fetch the user record
            $stmt = $pdo->prepare("
                SELECT
                    id,
                    username,
                    lastname,
                    firstname,
                    role,
                    password
                FROM users
                WHERE username = :username
                LIMIT 1
            ");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log('[Auth::login] PDOException: ' . $e->getMessage());
            return false;
        }

        if (!$user) {
            return false;
        }

        // 2) Verify password
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // 3) Success: regenerate session & store user + role
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'lastname' => $user['lastname'],
            'firstname' => $user['firstname'],
            'role' => $user['role'],
        ];

        return true;
    }

    /**
     * Returns the currently logged-in user, or null if not logged in
     */
    public static function user(): ?array
    {
        self::init();
        return $_SESSION['user'] ?? null;
    }

    /**
     * Check if a user is logged in
     */
    public static function check(): bool
    {
        self::init();
        return isset($_SESSION['user']);
    }

    /**
     * Log out the current user
     */
    public static function logout(): void
    {
        self::init();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }
}
