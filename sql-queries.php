<?php

function getName($username){
  global $db;
  $query = "SELECT first_name from users where user_email=:user_email";
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $username);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  return $result["first_name"];
}

function getLastName($username){
  global $db;
  $query = "SELECT last_name from users where user_email=:user_email";
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $username);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  return $result["last_name"];
}

function getBio($username){
  global $db;
  $query = "SELECT bio from users where user_email=:user_email";
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $username);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  return $result["bio"];
}

function validUser($username){
    global $db;
    $query = "SELECT count(*) from users where user_email=:user_email";
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
    $query = "INSERT into users values (:user_email, :first_name, :last_name, :bio, :password)";
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
  $query = "UPDATE users set first_name=:firstName, last_name=:lastName, bio=:bio where user_email=:username";
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':firstName', $firstName);
  $statement->bindValue(':lastName', $lastName);
  $statement->bindValue(':bio', $bio);
  $statement->execute();
  $statement->closeCursor();
}
  
function getAllGuides() {
  global $db;
  $query = 'SELECT * FROM guides';
  $statement = $db->prepare($query);
  $statement->execute();
  $allGuides = $statement->fetchAll();
  $statement->closeCursor();
  return $allGuides;
}

function getGuidesWithDuration($duration) {
  global $db;
  $query = 'SELECT * FROM guides WHERE duration = :duration';
  $statement = $db->prepare($query);
  $statement->bindValue(':duration', $duration);
  $statement->execute();
  $guides = $statement->fetchAll();
  $statement->closeCursor();
  return $guides;
}

function getGuidesWithLocation($location) {
  global $db;
  $query = 'SELECT * FROM guides WHERE location LIKE :location';
  $statement = $db->prepare($query);
  $statement->bindValue(':location', '%' . $location . '%');
  $statement->execute();
  $guides = $statement->fetchAll();
  $statement->closeCursor();
  return $guides;
}

function getGuidesWithLocDur($location, $duration) {
  global $db;
  $query = 'SELECT * FROM guides WHERE location LIKE :location and duration=:duration';
  $statement = $db->prepare($query);
  $statement->bindValue(':location', '%' . $location . '%');
  $statement->bindValue(':duration', $duration);
  $statement->execute();
  $guides = $statement->fetchAll();
  $statement->closeCursor();
  return $guides;
}

function followUser($username, $friendName) {
  global $db;
  $query = 'INSERT into following values (:user_email, :followed_user_email)';
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $username);
  $statement->bindValue(':followed_user_email', $friendName);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = 'INSERT into followers values (:user_email, :follower_user_email)';
  $statement = $db->prepare($query);
  $statement->bindValue(':user_email', $friendName);
  $statement->bindValue(':follower_user_email', $username);
  $statement->execute();
  $statement->closeCursor();
}

function unfollowUser($username, $friendName) {
  global $db;
  $query = 'DELETE from following where user_email=:username and followed_user_email=:friendName';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':friendName', $friendName);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = 'DELETE from followers where user_email=:friendName and follower_user_email=:username';
  $statement = $db->prepare($query);
  $statement->bindValue(':friendName', $friendName);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $statement->closeCursor();
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

function getRVGuides($username) {
  global $db;
  $query = 'SELECT * FROM recently_viewed WHERE user_email=:username';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $rvGuides = $statement->fetchAll();
  $statement->closeCursor();
  return $rvGuides;
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
  $query = "insert into guides values (:g_id, :title, :g_date, :description, :location, :duration, :user_email)";
  $statement = $db->prepare($query);
  $statement->bindValue(':g_id', $g_id);
  $statement->bindValue(':title', $title);
  $statement->bindValue(':g_date', $date);
  $statement->bindValue(':description', $description);
  $statement->bindValue(':location', $location);
  $statement->bindValue(':duration', $duration);
  $statement->bindValue(':user_email', $user_email);
  $statement->execute();
  $statement->closeCursor();
}

function createActivity($g_id, $act_id, $title, $description, $address){
  global $db;
  $query = "INSERT into activities values (:act_id, :title, :description, :address)";
  $statement = $db->prepare($query);
  $statement->bindValue(':act_id', $act_id);
  $statement->bindValue(':title', $title);
  $statement->bindValue(':description', $description);
  $statement->bindValue(':address', $address);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = "INSERT into guide_includes values (:g_id, :act_id)";
  $statement = $db->prepare($query);
  $statement->bindValue(':g_id', $g_id);
  $statement->bindValue(':act_id', $act_id);
  $statement->execute();
  $statement->closeCursor();
}

function deleteGuide($g_id){
  global $db;
  $query = "DELETE from guides where g_id=:guide";
  $statement = $db->prepare($query);
  $statement->bindValue(':guide', $g_id);
  $statement->execute();
  $statement->closeCursor();

  $actList = getGuideActivities($g_id);
  foreach($actList as $activity){
    deleteActivity($activity);
  }

  global $db;
  $query = "DELETE from guide_includes where g_id=:guide";
  $statement = $db->prepare($query);
  $statement->bindValue(':guide', $g_id);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = "DELETE from recently_viewed where g_id=:guide";
  $statement = $db->prepare($query);
  $statement->bindValue(':guide', $g_id);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = "DELETE from user_saved where g_id=:guide";
  $statement = $db->prepare($query);
  $statement->bindValue(':guide', $g_id);
  $statement->execute();
  $statement->closeCursor();
}

function deleteActivity($act_id){
  global $db;
  $query = "DELETE from activities where act_id=:activity";
  $statement = $db->prepare($query);
  $statement->bindValue(':activity', $act_id);
  $statement->execute();
  $statement->closeCursor();

  global $db;
  $query = "DELETE from guide_includes where act_id=:activity";
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
  $query = 'INSERT into comments values (:username, :guide_id, :comment, :time)';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':guide_id', $guide_id);
  $statement->bindValue(':comment', $comment);
  $statement->bindValue(':time', $time);
  $statement->execute();
  $statement->closeCursor();
}

function getRating($g_id) {
  global $db;
  $query = 'SELECT rate FROM ratings WHERE g_id=:guide_id';
  $statement = $db->prepare($query);
  $statement->bindValue(':guide_id', $g_id);
  $statement->execute();
  $ratings = $statement->fetchAll();
  $statement->closeCursor();

  $total = 0.0;

  foreach($ratings as $rate){
    $total += $rate['rate'];
  }
  if (count($ratings) == 0){
    return "N/A";
  }
  $total = $total / count($ratings);
  return $total;
}

function checkRated($g_id, $user_email) {
  global $db;
  $query = 'SELECT count(*) FROM ratings WHERE g_id=:guide_id and user_email=:email';
  $statement = $db->prepare($query);
  $statement->bindValue(':guide_id', $g_id);
  $statement->bindValue(':email', $user_email);
  $statement->execute();
  $ratings = $statement->fetch();
  $statement->closeCursor();
  if ($ratings["count(*)"] != 0){
    return False;
  }
  return True;
}

function leaveRating($g_id, $user_email, $rate){
  global $db;
  $query = 'INSERT into ratings values (:g_id, :user_email, :rate)';
  $statement = $db->prepare($query);
  $statement->bindValue(':g_id', $g_id);
  $statement->bindValue(':user_email', $user_email);
  $statement->bindValue(':rate', $rate);
  $statement->execute();
  $statement->closeCursor();
}

function saveGuide($username, $guide_id) {
  global $db;
  $query = 'INSERT into user_saved values (:username, :guide_id)';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':guide_id', $guide_id);
  $statement->execute();
  $statement->closeCursor();
}

function unsaveGuide($username, $guide_id) {
  global $db;
  $query = 'DELETE from user_saved where user_email=? AND g_id=?';
  $statement = $db->prepare($query);
  $statement->bindParam(1, $username);
  $statement->bindParam(2, $guide_id);
  $statement->execute();
  $statement->closeCursor();
}

function addToRecentlyViewed($username, $guide_id, $time) {
  global $db;
  $query = 'INSERT into recently_viewed values (:username, :guide_id, :time)';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':guide_id', $guide_id);
  $statement->bindValue(':time', $time);
  $statement->execute();
  $statement->closeCursor();
}

function checkRecentlyViewed($username, $guide_id) {
  global $db;
  $query = 'SELECT count(*) FROM recently_viewed WHERE user_email=:username and g_id=:guide_id';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':guide_id', $guide_id);
  $statement->execute();
  $recentlyViewed = $statement->fetch();
  $statement->closeCursor();
  if ($recentlyViewed["count(*)"] == 0){
    return False;
  }
  return True;
}

function getFollowers($username) {
  global $db;
  $query = 'SELECT U.user_email, U.first_name, U.last_name, U.bio FROM users as U, followers as F WHERE F.user_email=:username and F.follower_user_email=U.user_email';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $followers = $statement->fetchAll();
  $statement->closeCursor();
  return $followers;
}

function getFollowing($username) {
  global $db;
  $query = 'SELECT U.user_email, U.first_name, U.last_name, U.bio from users as U, following as F where F.user_email=:username and F.followed_user_email=U.user_email';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $following = $statement->fetchAll();
  $statement->closeCursor();
  return $following;
}

function editGuide($gid, $new_title, $new_date, $new_description, $new_location, $new_duration, $email){
  global $db;
  // $query = "UPDATE guides set title=$new_title, \n date=$new_date, \n description=$new_description, \n location=$new_location, \n duration=$new_duration, \n user_email=$email where g_id=$gid";
  $query = "UPDATE guides set title=:new_title where g_id=:gid";
  $statement = $db->prepare($query);
  $statement->bindValue(':new_title', $new_title);
  $statement->bindValue(':gid', $gid);
  $statement->execute();
	$statement->closeCursor();

  $query = "update guides set g_date=:new_date where g_id=:gid";
  $statement = $db->prepare($query);
  $statement->bindValue(':gid', $gid);
  $statement->bindValue(':new_date', $new_date);
  $statement->execute();
	$statement->closeCursor();

  $query = "UPDATE guides set description=:new_description where g_id=:gid";
  $statement = $db->prepare($query);
  $statement->bindValue(':gid', $gid);
  $statement->bindValue(':new_description', $new_description);
  $statement->execute();
	$statement->closeCursor();

  $query = "UPDATE guides set location=:new_location where g_id=:gid";
  $statement = $db->prepare($query);
  $statement->bindValue(':gid', $gid);
  $statement->bindValue(':new_location', $new_location);
  $statement->execute();
	$statement->closeCursor();

  $query = "UPDATE guides set duration=:new_duration where g_id=:gid";
  $statement = $db->prepare($query);
  $statement->bindValue(':gid', $gid);
  $statement->bindValue(':new_duration', $new_duration);
  $statement->execute();
	$statement->closeCursor();
}

function editActivity($aid, $new_title, $new_description, $new_address){
  global $db;
  $query = "update activities set title=:new_title, description=:new_description, address=:new_address where act_id=:aid";
  $statement = $db->prepare($query);
  $statement->bindValue(':new_title', $new_title);
  $statement->bindValue(':new_description', $new_description);
  $statement->bindValue(':new_address', $new_address);
  $statement->bindValue(':aid', $aid);
  $statement->execute();
  $statement->closeCursor();
}
?>
