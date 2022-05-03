<?php
include_once "./server/server.php";

$user_query = "SELECT id, nome, email FROM usuarios limit 10";
$result_query = $conn->prepare($user_query);
$result_query->execute();

while ($user_row = $result_query->fetch(PDO::FETCH_ASSOC)) {
  extract($user_row);
  $dados .= "<tr>
  <td>$id</td>
  <td>$nome</td>
  <td>$email</td>
  <td>Ações</td
  </tr>";
}

echo "$dados";
