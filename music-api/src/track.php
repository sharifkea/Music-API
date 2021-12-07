<?php

    require_once("connection.php");
    require_once("todb.php");

    class Track extends DB {
        
        function search($searchText) {
            $query = <<<'SQL'
                SELECT *
                FROM track_all
                WHERE Name LIKE ?
                ORDER BY Name;
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['%' . $searchText . '%']);                

            $this->disconnect();

            return $stmt->fetchAll();                
        }
        function with_id($id) {
            $query = <<<'SQL'
                SELECT *
                FROM track_all
                WHERE TrackId = ?
                ORDER BY Name;
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);                

            $this->disconnect();

            return $stmt->fetchAll();                
        }
        function with_alb_id($albumId) {
            $query = <<<'SQL'
                SELECT *
                FROM track_all
                WHERE albumId = ?
                ORDER BY Name;
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$albumId]);                

            $this->disconnect();

            return $stmt->fetchAll();
            //return 'i m in';                
        }
        
        function add($data) {
            $newID=0;
           
            $query = <<<'SQL'
                INSERT INTO track (Name, AlbumId, MediaTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice) VALUES (?, ?, ?, ?,?, ?, ?, ?);
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$data['Name'], $data['AlbumId'], $data['MediaTypeId'], $data['GenreId'],$data['Composer'],$data['Milliseconds'],$data['Bytes'],$data['UnitPrice']]);

            $newID = $this->pdo->lastInsertId();

            $this->disconnect();

            return $newID;
        }
                       
           
        function update($data) {
            $query = <<<'SQL'
                update track 
                set Name=?, 
                    AlbumId=?, 
                    MediaTypeId=?, 
                    GenreId=?, 
                    Composer=?, 
                    Milliseconds=?, 
                    Bytes=?,
                    UnitPrice=? 
                    WHERE TrackId=?;
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$data['Name'], $data['AlbumId'], $data['MediaTypeId'], $data['GenreId'],$data['Composer'],$data['Milliseconds'],$data['Bytes'],$data['UnitPrice'],$data['TrackId']]);

            $this->disconnect();

            return true;

        }

        function delete($id) {            
            
            $query = <<<'SQL'
                DELETE FROM track 
                WHERE TrackId = ?;
            SQL;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);

            $return = true;
            $this->disconnect();

            return $return;
        }
    }
?>