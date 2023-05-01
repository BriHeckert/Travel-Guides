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
  $query = 'SELECT * FROM guides';
  $statement = $db->prepare($query);
  $statement->execute();
  $allGuides = $statement->fetchAll();
  $statement->closeCursor();
  return $allGuides;
}

function followUser($username, $friendName) {
  global $db;
  $query = 'insert into following values (:user_email, :followed_user_email)';
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $username);
  $statement->bindValue(':followed_user_email', $friendName);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = 'insert into followers values (:user_email, :follower_user_email)';
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $friendName);
  $statement->bindValue(':follower_user_email', $username);
  $statement->execute();
  $statement->closeCursor();
}

function unfollowUser($username, $friendName) {
  global $db;
  $query = 'delete from following where user_email=:username and followed_user_email=:friendName';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':friendName', $friendName);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = 'delete from followers where user_email=:friendName and follower_user_email=:username';
  $statement = $db->prepare($query);
  $statement->bindValue(':friendName', $friendName);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $statement->closeCursor();
}

function getFollowing($username) {
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
  $query = 'SELECT * FROM guides WHERE user_email=:username';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $userGuides = $statement->fetchAll();
  $statement->closeCursor();
  return $userGuides;
}

function getSavedGuides($username) {
  global $db;
  $query = 'SELECT * FROM user_saved WHERE user_email=:username';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $savedGuides = $statement->fetchAll();
  $statement->closeCursor();
  return $savedGuides;
}

function getGuideDetails($gid) {
  global $db;
  $query = 'SELECT * FROM guides WHERE g_id=:gid';
  $statement = $db->prepare($query);
  $statement->bindValue(':gid', $gid);
  $statement->execute();
  $guidesDets = $statement->fetch();
  $statement->closeCursor();
  return $guidesDets;
}

function getGuideActivities($gid) {
  $actList = [];
  global $db;
  $query = 'SELECT * FROM guide_includes WHERE g_id=:gid';
  $statement = $db->prepare($query);
  $statement->bindValue(':gid', $gid);
  $statement->execute();
  $activityIds = $statement->fetchAll();
  $statement->closeCursor();

  foreach($activityIds as $id){
    global $db;
    $query = 'SELECT * FROM activities WHERE act_id=:id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id['act_id']);
    $statement->execute();
    $activity = $statement->fetch();
    $statement->closeCursor();
    array_push($actList, $activity);
  }
  return $actList;
}

function createGuide($g_id, $title, $date, $description, $location, $duration, $user_email){
  global $db;
  $query = "insert into guides values (:g_id, :title, :date, :description, :location, :duration, :user_email)";
  $statement = $db->prepare($query);
  $statement->bindValue(':g_id', $g_id);
  $statement->bindValue(':title', $title);
  $statement->bindValue(':date', $date);
  $statement->bindValue(':description', $description);
  $statement->bindValue(':location', $location);
  $statement->bindValue(':duration', $duration);
  $statement->bindValue(':user_email', $user_email);
  $statement->execute();
  $statement->closeCursor();
}

function createActivity($g_id, $act_id, $title, $description, $address){
  global $db;
  $query = "insert into activities values (:act_id, :title, :description, :address)";
  $statement = $db->prepare($query);
  $statement->bindValue(':act_id', $act_id);
  $statement->bindValue(':title', $title);
  $statement->bindValue(':description', $description);
  $statement->bindValue(':address', $address);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = "insert into guide_includes values (:g_id, :act_id)";
  $statement = $db->prepare($query);
  $statement->bindValue(':g_id', $g_id);
  $statement->bindValue(':act_id', $act_id);
  $statement->execute();
  $statement->closeCursor();
}

function deleteGuide($g_id){
  global $db;
  $query = "delete from guides where g_id=:guide";
  $statement = $db->prepare($query);
  $statement->bindValue(':guide', $g_id);
  $statement->execute();
  $statement->closeCursor();

  $actList = getGuideActivities($g_id);
  foreach($actList as $activity){
    deleteActivity($activity);
  }

  global $db;
  $query = "delete from guide_includes where g_id=:guide";
  $statement = $db->prepare($query);
  $statement->bindValue(':guide', $g_id);
  $statement->execute();
  $statement->closeCursor();
}

function deleteActivity($act_id){
  global $db;
  $query = "delete from activities where act_id=:activity";
  $statement = $db->prepare($query);
  $statement->bindValue(':activity', $act_id);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = "delete from guide_includes where act_id=:activity";
  $statement = $db->prepare($query);
  $statement->bindValue(':activity', $act_id);
  $statement->execute();
  $statement->closeCursor();
}

function getComments($guide_id) {
  global $db;
  $query = 'SELECT C.user_email, C.text, C.timestamp FROM comments as C WHERE C.g_id=:guide_id';
  $statement = $db->prepare($query);
  $statement->bindValue(':guide_id', $guide_id);
  $statement->execute();
  $comments = $statement->fetchAll();
  $statement->closeCursor();
  return $comments;
}

function addComment($username, $guide_id, $comment, $time) {
  global $db;
  $query = 'insert into comments values (:username, :guide_id, :comment, :time)';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':guide_id', $guide_id);
  $statement->bindValue(':comment', $comment);
  $statement->bindValue(':time', $time);
  $statement->execute();
  $statement->closeCursor();
}
?>
