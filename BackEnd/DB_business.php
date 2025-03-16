<?php
require_once("DB_driver.php");

class DB_business extends DB_driver
{
    protected $_table_name = '';
    protected $_key = '';

    // Hàm Khởi Tạo
    function __construct()
    {
        parent::connect();
    }

    // hàm set table_name và key
    function setTable($tenBang, $khoaChinh)
    {
        $this->_table_name = $tenBang;
        $this->_key = $khoaChinh;
    }

    // Hàm ngắt kết nối
    function __destruct()
    {
        parent::dis_connect();
    }

    // Hàm thêm mới
    function add_new($data)
    {
        return parent::insert($this->_table_name, $data);
    }

    // Hàm xóa theo id
    function delete_by_id($id)
    {
        $where = $this->_key . " = ?";
        return $this->remove($this->_table_name, $where, [$id]);
    }
    


    // Hàm cập nhật theo id
    function update_by_id($data, $id)
    {
        $where = $this->_key . " = ?";
        return $this->update($this->_table_name, $data, $where, [$id]);
    }    


    // hàm select theo id
    function select_by_id($select, $id)
    {
        $sql = "SELECT $select FROM " . $this->_table_name . " WHERE " . $this->_key . " = ?";
        return $this->get_row($sql, [$id]);
    }
    
    // hàm get all
    function select_all()
    {
        $sql = "select * from " . $this->_table_name;
        return $this->get_list($sql);
    }
}
