<?php

class DB_driver
{
    public $__conn;
    public $localhost = "localhost";
    public $user = "root";
    public $pass = "";
    public $DbName = "webtechshop";

    public function connect()
    {
        if (!$this->__conn) {
            $this->__conn = mysqli_connect($this->localhost, $this->user, $this->pass, $this->DbName);

            if (!$this->__conn) {
                die("Lỗi kết nối: " . mysqli_connect_error());
            }

            mysqli_set_charset($this->__conn, "utf8mb4");
        }
    }

    public function dis_connect()
    {
        if ($this->__conn) {
            mysqli_close($this->__conn);
            $this->__conn = null;
        }
    }

    public function insert($table, $data)
    {
        $this->connect();

        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->__conn->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL: " . $this->__conn->error);
        }

        $types = str_repeat('s', count($data));
        $stmt->bind_param($types, ...array_values($data));
        $result = $stmt->execute();

        $stmt->close();
        return $result;
    }

    public function update($table, $data, $where, $params = [])
    {
        $this->connect();

        $setValues = implode(" = ?, ", array_keys($data)) . " = ?";
        $sql = "UPDATE $table SET $setValues WHERE $where";
        $stmt = $this->__conn->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL: " . $this->__conn->error);
        }

        $types = str_repeat('s', count($data)) . (count($params) > 0 ? str_repeat('s', count($params)) : '');
        $stmt->bind_param($types, ...array_merge(array_values($data), $params));
        $result = $stmt->execute();

        $stmt->close();
        return $result;
    }

    public function remove($table, $where, $params = [])
    {
        $this->connect();

        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $this->__conn->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL: " . $this->__conn->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function get_list($sql, $params = [])
    {
        $this->connect();

        $stmt = $this->__conn->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL: " . $this->__conn->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        return $data;
    }

    public function get_row($sql, $params = [])
    {
        $this->connect();

        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi SQL: " . $this->__conn->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();
        return $row ?: false;
    }
}

?>
