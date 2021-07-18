<?php

function get_tree($name) {
  $mysqli = new mysqli("localhost","root","","magna");
  if (mysqli_connect_errno($mysqli)) {
      die ("Failed to connect to MySQL: " . mysqli_connect_error());
  }
  $arrTemp = [];
  $stmt = $mysqli->prepare("SELECT * FROM member where name = ?");
  $stmt->bind_param('s', $name);
  $stmt->execute();
  $res = $stmt->get_result();
  $arrParents = [];
  while($row=$res->fetch_assoc()) {
      $id = $row['parent_id'];
      for ($i=0; $i < count($arrParents)+1; $i++) {
        $stmt1 = $mysqli->prepare("SELECT * FROM member where id = ?");
        $stmt1->bind_param('i', $id);
        $stmt1->execute();
        $res1 = $stmt1->get_result();
          while($row1=$res1->fetch_assoc()) {
            $id = $row1['parent_id'];
            if($row1['id']==0 AND in_array("root", $arrParents)) break;
            array_push($arrParents,$row1['name']);
          }
        }
  }
  return $arrParents;
}

  $children = get_tree("Derpina");
  echo json_encode($children);
?>