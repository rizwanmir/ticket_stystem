<?php
class ticket {
    private $db;
    function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function create($eventId, $seatNumber, $seatLocation, $price) {
        try {
            $stmt = $this->db->prepare("INSERT INTO seats(eventId, seatNumber, seatLocation, price) 
            VALUES(:eventId, :seatNumber, :seatLocation, :price)");
            $stmt->bindParam(":eventId", $eventId);
            $stmt->bindParam(":seatNumber", $seatNumber);
            $stmt->bindParam(":seatLocation", $seatLocation);
            $stmt->bindParam(":price", $price);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getID($seatId) {
        $stmt = $this->db->prepare("SELECT * FROM seats WHERE seatId=:seatId");
        $stmt->execute(array(":seatId"=>$seatId));
        $editRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }
    
    public function update($seatId, $eventId, $seatNumber, $seatLocation, $price) {
        try {
            $stmt = $this->db->prepare("UPDATE seats SET seatId=:seatId, eventId=:eventId, seatNumber=:seatNumber, seatLocation=:seatLocation, price=:price WHERE seatId=:seatId");
            $stmt->bindparam(":seatId",$seatId);
            $stmt->bindparam(":eventId",$eventId);
            $stmt->bindparam(":seatNumber",$seatNumber);
            $stmt->bindparam(":seatLocation",$seatLocation);
            $stmt->bindparam(":price",$price);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    public function delete($seatId) {
        $stmt = $this->db->prepare("DELETE FROM seats WHERE seatId=:seatId");
        $stmt->bindparam(":seatId", $seatId);
        $stmt->execute();
        return true;
    }
    
}