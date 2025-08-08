<?php
class Donhang {
    private $conn;
    public $status;
    public $customer_id;
    public $order_id;
    public $name;
    public $order_date;
    public $product_id;
    public $img;
    public $quantity;
    public $price;
    public $voucher_id;
    public $discount_amount;
    public $delivery_type;
    public $receiver_name;
    public $receiver_phone;
    public $delivery_address;
    public $store_code;

    //connect db
    public function __construct($db) {
        $this->conn = $db;
    }
    //tạo đơn hàng
    public function create($cart_id) {
        try {
            $this->conn->beginTransaction();

            // Kiểm tra khách hàng tồn tại
            $query = "SELECT customer_id FROM customers WHERE customer_id=:customer_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':customer_id', $this->customer_id);
            $stmt->execute();
            if ($stmt->rowCount() == 0) { 
                $this->conn->rollBack();
                return false;
            }

            // Lấy sản phẩm trong giỏ hàng
            $query = "
                SELECT ci.product_id, ci.quantity, p.price
                FROM cartitems ci
                JOIN products p ON ci.product_id = p.product_id
                WHERE ci.cart_id = :cart_id
            ";
            $stmt3 = $this->conn->prepare($query);
            $stmt3->bindParam(':cart_id', $cart_id);
            $stmt3->execute();
            $items = $stmt3->fetchAll(PDO::FETCH_ASSOC);
            if (empty($items)) {
                $this->conn->rollBack();
                return false;
            }

            // Tính tổng tiền
            $total = 0;
            foreach ($items as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            $this->discount_amount = 0;
            if ($this->voucher_id) {
                // Kiểm tra voucher
                $query_voucher = "SELECT * FROM vouchers WHERE voucher_id = :voucher_id AND NOW() BETWEEN start_date AND end_date";
                $stmt_voucher = $this->conn->prepare($query_voucher);
                $stmt_voucher->bindParam(':voucher_id', $this->voucher_id);
                $stmt_voucher->execute();
                if ($stmt_voucher->rowCount() > 0) {
                    $voucher = $stmt_voucher->fetch(PDO::FETCH_ASSOC);

                    // Kiểm tra người dùng đã thu thập và chưa dùng
                    $query_check = "SELECT * FROM customer_vouchers 
                        WHERE customer_id = :customer_id AND voucher_id = :voucher_id AND is_used = 0";
                    $stmt_check = $this->conn->prepare($query_check);
                    $stmt_check->bindParam(':customer_id', $this->customer_id);
                    $stmt_check->bindParam(':voucher_id', $this->voucher_id);
                    $stmt_check->execute();

                    if ($stmt_check->rowCount() > 0 && $total >= $voucher['min_order_value']) {
                        // Tính giảm giá
                        if ($voucher['discount_type'] === 'percent') {
                            $this->discount_amount = $total * ($voucher['discount_value'] / 100);
                        } else {
                            $this->discount_amount = $voucher['discount_value'];
                        }

                        // Đánh dấu đã dùng voucher
                        $query_use = "UPDATE customer_vouchers 
                            SET is_used = 1, used_at = NOW() 
                            WHERE customer_id = :customer_id AND voucher_id = :voucher_id";
                        $stmt_use = $this->conn->prepare($query_use);
                        $stmt_use->bindParam(':customer_id', $this->customer_id);
                        $stmt_use->bindParam(':voucher_id', $this->voucher_id);
                        $stmt_use->execute();
                    }
                }
            }
            $total = $total - $this->discount_amount;

            // Insert đơn hàng với các trường giao nhận
            $query1 = "INSERT INTO orders
                (customer_id, status, total, voucher_id, discount_amount,
                 delivery_type, receiver_name, receiver_phone, delivery_address, store_code)
                VALUES
                (:customer_id, :status, :total, :voucher_id, :discount_amount,
                 :delivery_type, :receiver_name, :receiver_phone, :delivery_address, :store_code)";
            $stmt1 = $this->conn->prepare($query1);

            $this->status = htmlspecialchars(strip_tags($this->status));

            $stmt1->bindParam(':customer_id', $this->customer_id);
            $stmt1->bindParam(':status', $this->status);
            $stmt1->bindParam(':total', $total);
            $stmt1->bindParam(':voucher_id', $this->voucher_id);
            $stmt1->bindParam(':discount_amount', $this->discount_amount);

            $stmt1->bindParam(':delivery_type', $this->delivery_type);
            $stmt1->bindParam(':receiver_name', $this->receiver_name);
            $stmt1->bindParam(':receiver_phone', $this->receiver_phone);
            $stmt1->bindParam(':delivery_address', $this->delivery_address);
            $stmt1->bindParam(':store_code', $this->store_code);

            $stmt1->execute();
            $order_id = $this->conn->lastInsertId();

            // Lưu chi tiết đơn hàng
            foreach ($items as $item) {
                $query4 = "INSERT INTO orderdetails SET order_id=:order_id ,product_id=:product_id ,quantity=:quantity ,price=:price";
                $stmt4 = $this->conn->prepare($query4);
                $stmt4->bindValue(':order_id', $order_id);
                $stmt4->bindValue(':product_id', $item['product_id']);
                $stmt4->bindValue(':quantity', $item['quantity']);
                $stmt4->bindValue(':price', $item['price']);
                $stmt4->execute();
            }

            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
             $this->conn->rollBack();
    echo json_encode(['error' => $e->getMessage()]);
    return false;
        }
    }
    //show lich su don hang
    public function show() {
        $query = "SELECT order_id, order_date, status, total FROM orders WHERE customer_id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->customer_id);
        $stmt->execute();
        return $stmt;
    }
    //show chi tiet don hang
    public function Chitietdonhang() {
        $query = "SELECT o.order_id, o.status, o.order_date,
            od.product_id, p.name , p.img,
            od.quantity, od.price
          FROM orders o
          JOIN orderdetails od ON o.order_id = od.order_id
          JOIN products p ON od.product_id = p.product_id
          WHERE o.customer_id = :customer_id AND o.order_id =:order_id
          ORDER BY o.order_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmt->bindParam(':order_id',$this->order_id);
        $stmt->execute();
        return $stmt;
    }
    //update trang thai huy don
    public function update() {
        $query = "UPDATE orders SET status = 'Đã hủy' WHERE customer_id=:customer_id AND order_id=:order_id";
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->order_id = htmlspecialchars(strip_tags($this->order_id));

        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmt->bindParam(':order_id',$this->order_id);

        if ($stmt->execute()) {
        if ($stmt->rowCount() == 0) {
            return "not_found";
        } else {
            return true;
        }
    }
    return false;
}
    //update trang thai don hang boi admin
    public function updateStatusByAdmin() {
    $query = "UPDATE orders SET status = :status WHERE order_id = :order_id";
    $stmt = $this->conn->prepare($query);

    $this->status = htmlspecialchars(strip_tags($this->status));
    $this->order_id = htmlspecialchars(strip_tags($this->order_id));

    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':order_id', $this->order_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return $stmt->rowCount() > 0 ? true : "not_found";
    }
    return false;
}

}
?>