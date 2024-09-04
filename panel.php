<?php
include_once "config/database.php";
include_once "objects/order.php";
include_once "objects/types.php";

$database = new Database();
$db = $database->get_connection();
$order = new Order($db);

// определение страницы
$page = isset($_GET["p"]) ? $_GET["p"] : 1;
$orders_limit = 12;
$skip = $orders_limit * ($page - 1);
$total_pages = ceil($order->get_orders_count() / $orders_limit);

// запрос нужных записей
$stmt = $order->get_orders($skip, $orders_limit);
$pages = $stmt->rowCount();

require_once 'lheader.php';
?>
<div class="container align-content-center" style="max-width: 1100px; min-width: 700px; min-height: 100dvh;">

  <!-- Таблица -->
  <div class="d-flex flex-column gap-3 p-5 rounded bg-s">
    <div class="row pb-4">
      <div class="col">Вид</div>
      <div class="col">Период</div>
      <div class="col">Зачетная книга</div>
      <div class="col">Количество</div>
      <div class="col"></div>
    </div>
    <!-- <br> -->
    <!-- Список записей -->
    <?php
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($r);
      echo "
      <div class='row rounded bg-t'>
        <div class='col'><span>$type_names[$type]</span></div>
        <div class='col'><span>$date_on - $date_end</span></div>
        <div class='col'>$record_book</div><div class='col'>$count</div>
        <div class='col bg-s'>";
          if ($status){
            echo "<a confirm-id='{$id}' class='btn btn-primary confirmed'>Принято</a>";
          } else {
            echo "<a confirm-id='{$id}' class='btn btn-primary btn-confim'>Принять</a>";
          }
      echo "</div></div>";
    }
    ?>
    <!-- Страницы -->
    <div class="d-flex gap-2 m-auto mt-2 pt-4">
      <?php

      if ($page > 1) {
        echo "<a href='{$_SERVER['PHP_SELF']}?p=" . $page - 1 . "' class='btn btn-change text-primary'>&lt;</a>";
      }

      for ($i = 1; $i <= $total_pages; $i++) {
        if ($page == $i) {
          echo "<a class='btn bg-btn act'>$i</a>";
        } else {
          echo "<a href='{$_SERVER['PHP_SELF']}?p=$i' class='btn bg-btn'>$i</a>";
        }
      }

      if ($page < $total_pages) {
        echo "<a href='{$_SERVER['PHP_SELF']}?p=" . $page + 1 . "' class='btn btn-change text-primary'>&gt;</a>";
      }

      ?>
    </div>


  </div><!-- Таблица -->
</div>


<?php require_once 'lfooter.php'; ?>