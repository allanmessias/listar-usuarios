<?php
include_once "./server/server.php";

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($data["nome"])) {
  $return = ["erro" => true, "msg" => "Necessário preencher o nome"];
} elseif (empty($data["email"])) {
  $return = ["erro" => true, "msg" => "Necessário preencher e-mail"];
} else {
  $query_user = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
  $reg_user = $conn->prepare($query_user);
  $reg_user->bindParam(":nome", $data["nome"]);
  $reg_user->bindParam(":email", $data["email"]);

  $reg_user->execute();

  if ($reg_user->rowCount()) {
    $return = ["erro" => false, "msg" => "Usuario cadastrado com sucesso"];
  } else {
    $return = ["erro" => true, "msg" => "Usuario não cadastrado"];
  }
}
echo json_encode($return);
