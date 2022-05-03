<?php
include_once "./server/server.php";

// filter only "page" gets and sanitize for only integer numbers
$page = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

if (!empty($page)) {
  // returns quantity of user's number
  $qt_user_pg = 10;
  $pagination = $page * $qt_user_pg - $qt_user_pg;

  // query users specs from usuarios, limited to 10.
  $user_query = "SELECT id, nome, email FROM usuarios ORDER BY id DESC LIMIT $pagination, $qt_user_pg";
  // prepares result from connection for execution
  $result_query = $conn->prepare($user_query);
  // execute
  $result_query->execute();

  $dados = "<table class='table table-dark'>
    <tbody class='listar-usuario'>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>EMAIL</th>
                <th>AÇÕES</th>
            </tr>
        </thead>";
  while ($user_row = $result_query->fetch(PDO::FETCH_ASSOC)) {
    extract($user_row);
    $dados .= "<tr>
    <td>$id</td>
    <td>$nome</td>
    <td>$email</td>
    <td>Ações - $page</td
    </tr>";
  }

  $dados .= "</tbody>
</table>";

  //Pagination - Sums quantity of pages
  $query_page = "SELECT COUNT(id) AS num_result FROM usuarios";
  $result_page = $conn->prepare($query_page);
  $result_page->execute();
  $row_page = $result_page->fetch(PDO::FETCH_ASSOC);

  //Page quantity
  $pg_qt = ceil($row_page['num_result'] / $qt_user_pg);

  $max_links = 2;
  $dados .= '<nav aria-label="Page navigation example"<ul class="pagination justify-content-center">';

  $dados .= "<li class='page-item'><a href='#' class='page-link' onclick='list_user(1)'>Primeira pagina</a></li>";

  for ($prev_page = $page - $max_links; $prev_page <= $page - 1; $prev_page++) {
    if ($prev_page >= 1) {
      $dados .=  "<li class='page-item'><a class='page-link' onclick='list_user($prev_page)' href='#'>$prev_page</a></li>";
    }
  }

  $dados .= "<li class='page-item'><a class='page-link' href='#'>$page</a></li>";

  for ($page_after = $page + 1; $page_after <= $page + $max_links; $page_after++) {
    if ($page_after <= $pg_qt) {
      $dados .= "<li class='page-item'><a class='page-link' href='#' onclick='list_user($page_after)'>$page_after</a></li>";
    }
  }

  $dados .= "<li class='page-item'><a class='page-link' href='#' onclick='list_user($pg_qt)'>Ultima</a></li>";
  $dados .=  '</ul></nav>';
} else {
  echo "<p>alert: nada retornado</p>";
}
echo "$dados";
