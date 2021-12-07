<?php

    require_once("connection.php");

    class Artist extends DB {
        /**
         * Retrieves the Artists whose name includes a certain text
         * 
         * @param   text upon which to execute the search
         * @return  an array with artists information
         */
        function search($searchText) {
            $query = <<<'SQL'
                SELECT ArtistId, Name
                FROM artist
                WHERE Name LIKE ?
                ORDER BY Name;
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['%' . $searchText . '%']);                

            $this->disconnect();

            return $stmt->fetchAll();                
        }
    }
?>