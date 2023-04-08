<?php

function getName($username){
    global $db;
    $query = "select first_name from users where user_email=:user_email";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_email', $username);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result["first_name"];
}

function getLastName($username){
  global $db;
  $query = "select last_name from users where user_email=:user_email";
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $username);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  return $result["last_name"];
}

function getBio($username){
  global $db;
  $query = "select bio from users where user_email=:user_email";
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $username);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  return $result["bio"];
}

function validUser($username){
    global $db;
    $query = "select count(*) from users where user_email=:user_email";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_email', $username);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    if ($result["count(*)"] != 0){
      return False;
    } else {
      return True;}
}

function addUser($username, $password, $firstName, $lastName, $bio){
    global $db;
    $query = "insert into users values (:user_email, :first_name, :last_name, :bio, :password)";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_email', $username);
    $statement->bindValue(':first_name', $firstName);
    $statement->bindValue(':last_name', $lastName);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':bio', $bio);
    $statement->execute();
    $statement->closeCursor();
}

function updateProfile($username, $firstName, $lastName, $bio){
  global $db;
  $query = "update users set first_name=:firstName, last_name=:lastName, bio=:bio where user_email=:username";
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':firstName', $firstName);
  $statement->bindValue(':lastName', $lastName);
  $statement->bindValue(':bio', $bio);
  $statement->execute();
  $statement->closeCursor();
}
  
function getGuides() { // Eventually will add filters as params
  global $db;
  $queryAllGuides = 'SELECT * FROM guides;';
  $statement = $db->prepare($queryAllGuides);
  $statement->execute();
  $allGuides = $statement->fetchAll();
  $statement->closeCursor();

  return $allGuides;
}

?>
