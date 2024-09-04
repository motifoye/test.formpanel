<?php

class Order
{
    private $conn;
    private $table_name = "order";

    public $id;
    public $type;
    public $date_on;
    public $date_end;
    public $record_book;
    public $count;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
        $query = "INSERT INTO `$this->table_name` SET type=:type, date_on=:date_on, date_end=:date_end, record_book=:record_book, count=:count";
        $stmt = $this->conn->prepare($query);

        // преобразование спец символов 
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->record_book = htmlspecialchars(strip_tags($this->record_book));
        $this->date_on = htmlspecialchars(strip_tags($this->date_on));
        $this->date_end = htmlspecialchars(strip_tags($this->date_end));
        $this->count = htmlspecialchars(strip_tags($this->count));

        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":record_book", $this->record_book);
        $stmt->bindParam(":date_on", $this->date_on);
        $stmt->bindParam(":date_end", $this->date_end);
        $stmt->bindParam(":count", $this->count);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function get_orders($skip, $amount)
    {
        $query = "SELECT * FROM `$this->table_name` LIMIT $skip, $amount";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function get_orders_count() {
        $query = "SELECT count(id) FROM `$this->table_name`";
        return $this->conn->query($query)->fetch()[0];
    }

    function confirm($id) {
        $query = "UPDATE `$this->table_name` SET status = '1' WHERE id = '$id'";
        return $this->conn->exec($query);
    }
}
