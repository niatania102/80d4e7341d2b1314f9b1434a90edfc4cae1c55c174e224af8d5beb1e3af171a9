<?php

function get_tree($name) {
  $mysqli = new mysqli('localhost','root','','magna');
  if (mysqli_connect_errno($mysqli)) {
      die ('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  $arrTemp = [];
  $stmt = $mysqli->prepare('SELECT * FROM member WHERE name = ?');
  $stmt->bind_param('s', $name);
  $stmt->execute();
  $res = $stmt->get_result();
  $idx = 0;
  while($row=$res->fetch_assoc()) {
      $id = $row['id'];
      $stmt1 = $mysqli->prepare('SELECT * FROM member WHERE parent_id = ?');
      $stmt1->bind_param('i', $id);
      $stmt1->execute();
      $res1 = $stmt1->get_result();
      while($row1=$res1->fetch_assoc()) {
        $arrTemp[$idx] = $row1['name'];
        $idx++;
      }
  }
  return $arrTemp;
}

  $children = get_tree('Samantha');
  echo json_encode($children);
?>