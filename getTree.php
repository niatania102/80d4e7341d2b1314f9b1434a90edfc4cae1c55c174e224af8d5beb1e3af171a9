<?php

function get_tree($name = "root") {
  $mysqli = new mysqli("localhost","root","","magna");
  if (mysqli_connect_errno($mysqli)) {
      die ("Failed to connect to MySQL: " . mysqli_connect_error());
  }
  $arrTemp = [];
  $idx = 0;
  $stmt = $mysqli->prepare("SELECT * FROM member");
  $stmt->execute();
  $res = $stmt->get_result();
  while($row=$res->fetch_assoc()) {
      $arrTemp[$idx]["name"] = $row['name'];
      $arrTemp[$idx]["children"] = $row['parent_id'];
      $idx++;
  }
  echo json_encode($arrTemp);
}

  get_tree();

?>