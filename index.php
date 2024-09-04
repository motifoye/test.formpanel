<?php
include_once "config/database.php";
include_once "objects/order.php";
include_once "objects/types.php";

$database = new Database();
$db = $database->get_connection();
$order = new Order($db);

require_once "lheader.php";
?>

<div class="container align-content-center" style="min-height: 100dvh;">

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" oninput="out.value=counter.value"
        class="needs-validation m-auto" novalidate style="max-width: 710px; min-width: 410px">

        <div class="bg-s d-flex flex-column gap-4 p-5 rounded">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $order->type = $_POST["type"];
                $order->record_book = $_POST["record"];
                $order->date_on = $_POST["date_on"];
                $order->date_end = $_POST["date_end"];
                $order->count = $_POST["counter"];

                if ($order->create()){
                    header("Location: /panel.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert">Не удалось добавить запись</div>';
                }
            }
            ?>
            <select name="type" class="form-select" aria-label="Вид">
                <?php 
                foreach ($type_names as $num => $name){
                    echo "<option value='$num'>$name</option>";
                }
                ?>
            </select>
            <div class="input-group">
                <input type="text" name="record" class="form-control" placeholder="Зачетная книга" pattern="[0-9]{12}" required>
                <div class="invalid-feedback">
                    Номер из 12 цифр
                </div>
            </div>
            <div class="d-flex gap-3">
                <input type="text" name="date_on" class="form-control" placeholder="Начало периода" onfocus="this.type='date'" onblur="this.type='text'" required>
                <input type="text" name="date_end" class="form-control" placeholder="Конец периода" onfocus="this.type='date'" onblur="this.type='text'" required>
            </div>
            <div class="input-group">
                <label for="counter">Выберите количество:</label>
                <input type="range" name="counter" class="form-range counter" value="1" min="1" max="5">
                <output id="out">1</output>
            </div>
            <input type="submit" id="send" class="btn btn-primary m-auto">
        </div>
    </form>
</div>


<?php require_once "lfooter.php"; ?>