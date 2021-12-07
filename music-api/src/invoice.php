<?php

    require_once("connection.php");

    class Invoice extends DB {
        
        function get($id) {
            
            $query = <<<'SQL'
                SELECT *
                FROM invoice 
                WHERE InvoiceId = ?;
            SQL;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);                
            $results = $stmt->fetch();

            // Director data
            $query = <<<'SQL'
                SELECT ta.TrackId as TrackId,ta.Name as TrackName,il.UnitPrice as UnitPrice,il.Quantity as Quantity 
                FROM invoiceline il JOIN  track ta ON il.TrackId=ta.TrackId
                
                WHERE il.InvoiceId = ?;
            SQL;

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            $results['Tracks'] = $stmt->fetchAll();
            $this->disconnect();

            return $results;  

           
        }
        function with_cus_id($id) {
            
            $query = <<<'SQL'
                SELECT InvoiceId
                FROM invoice 
                WHERE CustomerId = ?;
            SQL;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);                

            $this->disconnect();

            return $stmt->fetchAll();  

           
        }
        function add($data) {
            try {
                $this->pdo->beginTransaction();

                $query = <<<'SQL'
                    INSERT INTO invoice (CustomerId,InvoiceDate,BillingAddress,BillingCity,BillingState,BillingCountry,BillingPostalCode,Total) VALUES (?,?,?,?,?,?,?,?);
                SQL;

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$data['CustomerId'],$data['InvoiceDate'],$data['BillingAddress'],$data['BillingCity'],$data['BillingState'],$data['BillingCountry'],$data['BillingPostalCode'],$data['Total']]);

                $newID = $this->pdo->lastInsertId();

                // invoiceline
                if (isset($data['TrackId'])) {
                    for($x = 0; $x < count($data['TrackId']); $x++) {
                        $query = <<<'SQL'
                            INSERT INTO invoiceline (InvoiceId,TrackId,UnitPrice,Quantity) VALUES (?,?,?,?);
                        SQL;
                        $stmt = $this->pdo->prepare($query);
                        $stmt->execute([$newID,$data['TrackId'][$x],$data['UnitPrice'][$x],$data['Quantity'][$x]]);
                    }
                }
                $this->pdo->commit();
                
            } catch (Exception $e) {
                $newID = -1;
                $this->pdo->rollBack();
                debug($e);
            }

            $this->disconnect();

            return $newID;
        
        }
    }
?>
