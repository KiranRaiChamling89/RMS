<?php
    session_start();
    class Database {
        private $host = 'localhost';
        private $user = 'root';
        private $password = '';
        private $database = 'rms';

        public function getConnection() {
            $con = new mysqli($this->host, $this->user, $this->password, $this->database);

            return ($con->connect_error) ? 0 : $con;
        }
    }
?>