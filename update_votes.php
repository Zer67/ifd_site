<?php
  session_start();
  $db = new PDO("mysql:host=localhost;dbname=projetifd;charset=utf8","root","");
  $userid = $_SESSION['id'];
  $critiqueid = $_GET['id'];
  $value = $_GET['value'];
  $sql = 'SELECT * FROM link_utilisateur_score WHERE id_utilisateur = '.$userid.' AND id_critiques='.$critiqueid;
  $req = $db->prepare($sql);
  $req->execute();
  if(!($req->fetch()) && $value!=0){
    $sql = "INSERT INTO link_utilisateur_score(id_utilisateur,id_critiques) VALUES ('$userid','$critiqueid');";
    $req = $db->prepare($sql);
    $req->execute();
  }

  $req_check_upvote = $db->prepare('SELECT value FROM link_utilisateur_score WHERE id_utilisateur='.$userid.' AND id_critiques='.$critiqueid.';');
  $req_check_upvote->execute();
  $value_upvote = $req_check_upvote->fetch();
  if($value_upvote['value']!=$value){
    $sql = 'UPDATE link_utilisateur_score SET value='.$value.' WHERE id_utilisateur = '.$userid.' AND id_critiques='.$critiqueid;
    $req = $db->prepare($sql);
    $req->execute();
  } else {
    $sql = 'DELETE FROM link_utilisateur_score WHERE id_utilisateur = '.$userid.' AND id_critiques='.$critiqueid;
    $req = $db->prepare($sql);
    $req->execute();
  }

  header('location: critique.php?id='.$critiqueid);
?>
