<?php

    require_once("connection.php");

    class Admin extends DB {
        /**
         * Retrieves the Admin Password
         *
         * @return  an array with password
         */
        function fetch_pass() {
            $query = <<<'SQL'
                SELECT *
                FROM admin;
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();                

            $this->disconnect();

            return $stmt->fetchAll();                
        }
    }
?>