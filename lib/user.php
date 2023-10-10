<?php

/*
 * Add a user to the database
 * @param PDO $pdo
 * @param string $first_name
 * @param string $last_name
 * @param string $email
 * @param string $password
 * @param string $role
 * @return void
 */
function addUser(PDO $pdo, string $first_name, string $last_name, string $email, string $password, $role = "user")
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (:first_name, :last_name, :email, :password, :role)");
    $query->bindParam(":first_name", $first_name);
    $query->bindParam(":last_name", $last_name);
    $query->bindParam(":email", $email);
    $query->bindParam(":password", $password);
    $query->bindParam(":role", $role);
    $query->execute();
}

/*
 * Check if a user exists in the database
 * @param PDO $pdo
 * @param string $email
 * @return bool
 */
function verifyUserLoginPassword(PDO $pdo, string $email, string $password)
{
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(":email", $email);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
    
    return ($user && password_verify($password, $user["password"])) ? $user : false;
}
