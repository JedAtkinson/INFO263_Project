<?php
/**
 * Create connection to the database
 *
 * @return PDO object which is the connection to the database
 */
function openConnection()
{
    $host = 'localhost';
    $data = 'open_review';
    $user = 'root';
    $pass = 'mysql';
    $chrs = 'utf8mb4';
    $attr = "mysql:host=$host;dbname=$data;charset=$chrs";
    $opts =[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($attr, $user, $pass, $opts);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    return $pdo;
}

/**
 * Close connection to given database
 *
 * @param $pdo PDO object
 */
function closeConnection($pdo)
{
    $pdo = null;
}
?>