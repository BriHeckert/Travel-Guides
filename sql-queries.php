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
  $query = 'SELECT * FROM guides;';
  $statement = $db->prepare($query);
  $statement->execute();
  $allGuides = $statement->fetchAll();
  $statement->closeCursor();
  return $allGuides;
}

function followUserpt1($username, $friendName) {
  global $db;
  $query = 'insert into following values (:user_email, :followed_user_email)';
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $username);
  $statement->bindValue(':followed_user_email', $friendName);
  $statement->execute();
  $statement->closeCursor();
}

function followUserpt2($friendName, $username) {
  global $db;
  $query = 'insert into followers values (:user_email, :follower_user_email)';
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $friendName);
  $statement->bindValue(':follower_user_email', $username);
  $statement->execute();
  $statement->closeCursor();
}

function unfollowUserpt1($username, $friendName) {
  glpbal $db;
  $query = 'delete from following where user_email=:username and followed_user_email=:friendName';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':friendName', $friendName);
  $statement->execute();
  $statement->closeCursor();
}

function unfollowUserpt2($friendName, $username) {
  global $db;
  $query = 'delete from followers where user_email=:friendName and follower_user_email=:username';
  $statement = $db->prepare($query);
  $statement->bindValue(':friendName', $friendName);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $statement->closeCursor();
}

function getifFollowing($username) {
  global $db;
  $query = 'select followed_user_email from following where user_email=:username';
  $statement->bindValue(':username', $username);
  $statement->execute();
  $following = $statement->fetchAll();
  $statement->closeCursor();
  return $following;
}

function getUserGuides($username) {
  global $db;
  $query = 'SELECT * FROM guides WHERE user_email=:username;';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $userGuides = $statement->fetchAll();
  $statement->closeCursor();
  return $userGuides;
}

function getSavedGuides($username) {
  global $db;
  $query = 'SELECT * FROM user_saved WHERE user_email=:username;';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $savedGuides = $statement->fetchAll();
  $statement->closeCursor();
  return $savedGuides
}
?>
