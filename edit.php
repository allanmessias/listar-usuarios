<?php
include_once "./server/server.php";

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($data["id"])) {
  $return = ["erro" => true, "msg" => "Erro: tente mais tarde"];
} elseif (empty($data["nome"])) {
  $return = ["erro" => true, "msg" => "Necessário preencher o nome"];
} elseif (empty($data["email"])) {
  $return = ["erro" => true, "msg" => "Necessário preencher e-mail"];
} else {
  $query_edit_user =
    "UPDATE usuarios SET nome=:nome, email=:email WHERE id=:id";

  $edit_user = $conn->prepare($query_edit_user);
  $edit_user->bindParam(":nome", $data["nome"]);
  $edit_user->bindParam(":email", $data["email"]);
  $edit_user->bindParam(":id", $data["id"]);

  if ($edit_user->execute()) {
    $return = ["erro" => false, "msg" => "Usuário editado com sucesso!"];
  } else {
    $return = [
      "erro" => true,
      "msg" => "Erro: não foi possível editar, tente mais tarde",
    ];
  }
}

echo json_encode($return);
