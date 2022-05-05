<?php
include_once "./server/server.php";

// filter's id user by get http
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

// if filter_input return's not empty, query from database and returns data by json
if (!empty($id)) {
  $query_id = "DELETE FROM usuarios WHERE id=:id";
  $result_user = $conn->prepare($query_id);
  $result_user->bindParam(":id", $id);

  if ($result_user->execute()) {
    $return = ["erro" => false, "msg" => "Usuário apagado com sucesso"];
  } else {
    $return = ["erro" => true, "msg" => "Não foi possível excluir o usuário"];
  }
} else {
  $return = ["erro" => true, "msg" => "Não foi possível encontrar um usuário"];
}

echo json_encode($return);
