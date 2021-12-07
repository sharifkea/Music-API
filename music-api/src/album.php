<?php

    require_once("connection.php");

    class Album extends DB {
        /**
         * Retrieves the Artists whose name includes a certain text
         * 
         * @param   text upon which to execute the search
         * @return  an array with artists information
         */
        function search($searchText) {
            $query = <<<'SQL'
                SELECT *
                FROM album
                WHERE Title LIKE ?
                ORDER BY Title;
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['%' . $searchText . '%']);                

            $this->disconnect();

            return $stmt->fetchAll();                
        }
        function with_art_id($artistId) {
            $query = <<<'SQL'
                SELECT *
                FROM album
                WHERE ArtistId = ?
                ORDER BY Title;
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$artistId]);                

            $this->disconnect();

            return $stmt->fetchAll();                
        }
    }
?>