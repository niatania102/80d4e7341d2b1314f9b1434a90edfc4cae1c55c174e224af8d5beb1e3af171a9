<?php

function get_tree($name='root') {
  $mysqli = new mysqli('localhost','root','','magna');
  if (mysqli_connect_errno($mysqli)) {
      die ('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  $arrTemp = [];
  $idx = 0;
  $stmt = $mysqli->prepare('SELECT id, name, COUNT(parent_id) AS nAnak FROM member GROUP BY parent_id');
  // $stmt->bind_param('s', $name);
  $stmt->execute();
  $res = $stmt->get_result();
  while($row=$res->fetch_assoc()) {
      $arrTemp[$idx]['name'] = $row['name'];
      $id = $row['id'];
      for ($i=0; $i < $row['nAnak']; $i++) {
        $stmt1 = $mysqli->prepare('SELECT name FROM member WHERE parent_id = ?');
        $stmt1->bind_param('i', $id);
        $stmt1->execute();
        $res1 = $stmt1->get_result();
          while($row1=$res1->fetch_assoc()) {
            if($row1['name']!='root') $arrTemp[$idx][$i]['children'] = $row1['name'];
          }
        }
      $idx++;
  }
  return $arrTemp;
}

$tree = get_tree();
echo json_encode($tree);

?>