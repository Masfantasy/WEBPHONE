<?php
class Vouchers{
    private $conn;
    public $voucher_id;
    public $code;
    public $discount_type;
    public $discount_value;
    public $min_order_value;
    public $end_date;
    public $customer_id;


    //connect db
        public function __construct($db) {
        $this->conn = $db;
    }
    //Danh sách toàn bộ voucher
    public function read() {
        $query = "SELECT * FROM vouchers WHERE NOW() BETWEEN start_date AND end_date AND voucher_id NOT IN (
        SELECT voucher_id FROM customer_vouchers WHERE customer_id = :customer_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmt->execute();
        return $stmt;
    }
    //Người dùng thu thập voucher
    public function create() {
        try{
            $query = "SELECT voucher_id FROM vouchers WHERE voucher_id=:voucher_id AND NOW() BETWEEN  start_date AND end_date";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':voucher_id',$this->voucher_id);
            $stmt->execute();
            if($stmt->rowCount() == 0){
                echo json_encode(['success' => false, 'message' => 'Voucher không hợp lệ hoặc đã hết hạn.']);
                return;
            }
            $query2 = "SELECT customer_id FROM customer_vouchers WHERE customer_id=:customer_id AND voucher_id=:voucher_id ";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':customer_id',$this->customer_id);
            $stmt2->bindParam(':voucher_id',$this->voucher_id);
            $stmt2->execute();
            if($stmt2->rowCount() > 0){
                echo json_encode(['success' => false, 'message' => 'Bạn đã thu thập voucher này']);
                return;
            }
            $query3 = "INSERT INTO customer_vouchers  (customer_id, voucher_id) VALUES (:customer_id, :voucher_id)";
            $stmt3 = $this->conn->prepare($query3);
            //clean data
            $this->voucher_id = htmlspecialchars(strip_tags($this->voucher_id));
            
            $stmt3->bindParam(':customer_id',$this->customer_id);
            $stmt3->bindParam(':voucher_id',$this->voucher_id);
            if($stmt3->execute()){
                return true;
            }else {
            return false;
        }
        }catch(PDOException $e){
        }
    }
    //Danh sách toàn bộ voucher của người dùng
    public function customer_vouchers() {
        $query = "
            SELECT 
                v.voucher_id, v.code, v.discount_type, v.discount_value, 
                v.min_order_value, v.end_date, c.is_used, c.used_at
            FROM customer_vouchers c
            JOIN vouchers v ON c.voucher_id = v.voucher_id
            WHERE c.customer_id = :customer_id
            AND c.is_used = 0
            AND CURDATE() BETWEEN DATE(v.start_date) AND DATE(v.end_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id', $this->customer_id);
        $stmt->execute();
        return $stmt;
    }
}
?>