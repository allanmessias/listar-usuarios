<?php
include_once "./server/server.php";

// filter only "page" gets and sanitize for only integer numbers
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
  $query_id = "SELECT id, nome, email FROM usuarios WHERE id =:id LIMIT 1";
  $result_user = $conn->prepare($query_id);
  $result_user->bindParam(":id", $id);

  $result_user->execute();

  $return_user = $result_user->fetch(PDO::FETCH_ASSOC);

  $data = "Id: " . $id;

  $return = ["erro" => false, "data" => $return_user];
} else {
  $return = ["erro" => true, "msg" => "nada encontrado!"];
}

echo json_encode($return);
