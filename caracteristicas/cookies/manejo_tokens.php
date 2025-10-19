<?php
// remember_tokens.php
// Uso: include 'remember_tokens.php'; luego llama a las funciones desde tu login/logout/middleware.
// Requiere: PDO y la tabla `cookies` tal como la tienes en la BD.

// ---------------- CONFIG ----------------

include "./caracteristicas/servidor/datos_servidor.php";

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'biblioteca_videojuegos');
define('DB_USER', 'root');
define('DB_PASS', '');

define('REMEMBER_COOKIE_NAME', 'remember_token'); // nombre de la cookie
define('REMEMBER_COOKIE_DAYS', 30);                // días por defecto de caducidad

// ---------------- Conexión a la BD (PDO) ----------------
function db_connect(): PDO {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    return new PDO($dsn, DB_USER, DB_PASS, $options);
}

// ---------------- Generador de token ----------------
// Genera un token seguro de 40 hex chars (20 bytes).
function generateRandomToken(int $bytes = 20): string {
    return bin2hex(random_bytes($bytes)); // 40 chars por defecto
}

// ---------------- Crear token al registrar / login ----------------
// Guarda un token en la tabla `cookies` y devuelve el token.
// $days controla la caducidad (por defecto REMEMBER_COOKIE_DAYS)
function createRememberToken(PDO $pdo, string $username, int $days = REMEMBER_COOKIE_DAYS): ?string {
    try {
        $token = generateRandomToken();
        $fecha_creacion = date('Y-m-d');
        $fecha_caduca = date('Y-m-d', strtotime("+{$days} days"));

        $sql = "INSERT INTO cookies (nombre_usuario, token, fecha_caduca, fecha_creacion)
                VALUES (:username, :token, :fecha_caduca, :fecha_creacion)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':token' => $token,
            ':fecha_caduca' => $fecha_caduca,
            ':fecha_creacion' => $fecha_creacion
        ]);

        return $token;
    } catch (Exception $e) {
        // manejar/loggear error segun convenga
        return null;
    }
}

// ---------------- Setear la cookie en el cliente ----------------
// Llama a esta función después de createRememberToken()
// $secure y $httponly deberían ser true en producción (HTTPS)
function setRememberCookie(string $token, int $days = REMEMBER_COOKIE_DAYS): void {
    $expiry = time() + ($days * 24 * 60 * 60);
    // Ajusta domain/path según necesites
    setcookie(REMEMBER_COOKIE_NAME, $token, [
        'expires' => $expiry,
        'path' => '/',
        //'domain' => 'tudominio.com', // descomenta si necesitas
        'secure' => isset($_SERVER['HTTPS']), // true si HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

// ---------------- Validar cookie y obtener usuario ----------------
// Si la cookie existe y corresponde a un token válido (no expirado) devuelve el nombre de usuario.
// Si no es válida devuelve null.
// Esta función hace el "auto-login" lógico: devuelve username si token válido.
function validateRememberCookie(PDO $pdo): ?string {
    if (empty($_COOKIE[REMEMBER_COOKIE_NAME])) {
        return null;
    }
    $token = $_COOKIE[REMEMBER_COOKIE_NAME];

    try {
        $sql = "SELECT nombre_usuario, fecha_caduca FROM cookies WHERE token = :token LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':token' => $token]);
        $row = $stmt->fetch();

        if (!$row) {
            // token no encontrado -> limpiar cookie
            clearRememberCookie();
            return null;
        }

        // comprobar expiración (fecha en formato YYYY-MM-DD)
        $today = date('Y-m-d');
        if ($row['fecha_caduca'] < $today) {
            // expirado -> borrar registro y cookie
            revokeToken($pdo, $token);
            clearRememberCookie();
            return null;
        }

        // token válido -> devolver usuario (a quien deberás crear la sesión)
        return $row['nombre_usuario'];
    } catch (Exception $e) {
        // manejar/loggear error segun convenga
        return null;
    }
}

// ---------------- Revocar / borrar token concreto ----------------
function revokeToken(PDO $pdo, string $token): bool {
    try {
        $sql = "DELETE FROM cookies WHERE token = :token";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':token' => $token]);
        // también limpiar cookie en cliente
        clearRememberCookie();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// ---------------- Revocar todos los tokens de un usuario (ej: al cambiar contraseña) ----------------
function revokeAllTokensForUser(PDO $pdo, string $username): bool {
    try {
        $sql = "DELETE FROM cookies WHERE nombre_usuario = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        // No limpiamos cookie del cliente porque puede que sea de otro dispositivo.
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// ---------------- Limpiar cookie del cliente ----------------
function clearRememberCookie(): void {
    // Pone la cookie con pasado para borrarla en el navegador
    setcookie(REMEMBER_COOKIE_NAME, '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    // Además eliminar de la superglobal para que futuras llamadas en este request no la vean
    unset($_COOKIE[REMEMBER_COOKIE_NAME]);
}

// ---------------- Limpieza periódica: borrar tokens expirados ----------------
// Llama esta función desde una tarea cron o manualmente de vez en cuando.
function cleanupExpiredTokens(PDO $pdo): int {
    try {
        $today = date('Y-m-d');
        $sql = "DELETE FROM cookies WHERE fecha_caduca < :today";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':today' => $today]);
        return $stmt->rowCount(); // número de filas borradas
    } catch (Exception $e) {
        return 0;
    }
}

// ---------------- Funciones auxiliares de ejemplo ----------------
// Ejemplo: llamar esto en el login (después de validar credenciales):
// $pdo = db_connect();
// $token = createRememberToken($pdo, $username, 30); // 30 días
// if ($token) setRememberCookie($token, 30);

// Ejemplo: en el middleware que corre en cada request (antes de mostrar páginas protegidas):
// $pdo = db_connect();
// if (! isset($_SESSION['user'])) {
//     $username = validateRememberCookie($pdo);
//     if ($username) {
//         // Aquí creas la sesión del usuario:
//         session_start();
//         $_SESSION['user'] = $username;
//     }
// }

// Ejemplo: logout:
// session_start();
// // ... destruir sesión ...
// if (!empty($_COOKIE[REMEMBER_COOKIE_NAME])) {
//     $pdo = db_connect();
//     revokeToken($pdo, $_COOKIE[REMEMBER_COOKIE_NAME]);
// }
// // luego clearRememberCookie() es llamada dentro de revokeToken()

?>
