<?php
    class crudOperations{

        private $server = "localhost";  
        private $username = "root";
        private $password = "";
        private $db_name = "kandidtechnology";
        private $mysqli = "";
        private $result = "";
        
        public function __construct(){
            $this->mysqli = new mysqli($this->server,$this->username,$this->password,$this->db_name);
    
        }

        public function insert($tb_name, $values=array()){
            
            $tb_column = implode(',',array_keys($values));
            $tb_value = implode("','",$values);

            $insertQuery = "INSERT INTO $tb_name ($tb_column) VALUES('$tb_value')";
            $result = $this->mysqli->query($insertQuery);
            
           
        }
    }
?>