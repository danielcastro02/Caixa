<?php
    class conexao {
               
        public function getConexao(){
         
           $con = new PDO('mysql:host=localhost;dbname=igreja','igreja','Class.7ufo');
            return $con;
          
        }
    }