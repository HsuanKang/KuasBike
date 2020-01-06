<?php
function open_db (){
    $db_host="db.mis.kuas.edu.tw";
    $db_name="s1105137216";
    $db_user="s1105137216";
    $db_password="R224416945";
    $dsn="mysql:host=$db_host;dbname=$db_name;charset=utf8";
    try{
        $conn=new PDO($dsn,$db_user,$db_password);
        return $conn;
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

}
?>