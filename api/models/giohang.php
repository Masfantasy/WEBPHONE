<?php
class Giohang {
    private $conn;

    //question properties
    public $cart_id;
    public $id;
    public $customer_id;
    public $create_at;
    public $product_id;
    public $quantity;
    //connect db
    public function __construct($db) {
        $this->conn = $db;
    }
    //create cart
    public function create() {
        try{
            $this->conn->beginTransaction();
            $query = "SELECT customer_id FROM customers WHERE customer_id=:customer_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':customer_id',$this->customer_id);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
            $this->conn->rollBack();
            return false;
            }
            // Kiểm tra cart_id đã tồn tại chưa
            $checkCart = "SELECT cart_id FROM carts WHERE cart_id = :cart_id";
            $checkStmt = $this->conn->prepare($checkCart);
            $checkStmt->bindParam(':cart_id', $this->cart_id);
            $checkStmt->execute();

            if ($checkStmt->rowCount() == 0) {
                $query1 = "INSERT INTO carts (customer_id) VALUES (:customer_id)";
                $stmt1 = $this->conn->prepare($query1);
                //clean data
                $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));

                $stmt1->bindParam(':customer_id',$this->customer_id);
                if ($stmt1->execute()) {
                    $this->cart_id = $this->conn->lastInsertId(); // lưu cart_id mới tạo
                } else {
                    return false;
                }
            }
            
            $query2 = "SELECT product_id FROM products WHERE product_id=:product_id";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':product_id',$this->product_id);
            $stmt2->execute();
        
            if ($stmt2->rowCount() == 0) {
            $this->conn->rollBack();
            // Trả về thông báo lỗi nếu trùng
            echo json_encode(["message"=>"Không tồn tại mặt hàng"]);
            return false;
            }
            $query3 = "SELECT quantity FROM cartitems WHERE cart_id = :cart_id AND product_id = :product_id";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':cart_id', $this->cart_id);
            $stmt3->bindParam(':product_id', $this->product_id);
            $stmt3->execute();

            if ($stmt3->rowCount() > 0) {
            // 👉 Nếu đã tồn tại, cập nhật số lượng
            $existing = $stmt3->fetch(PDO::FETCH_ASSOC);
            $newQty = $existing['quantity'] + $this->quantity;
            $update = "UPDATE cartitems SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id";
            $stmtUpdate = $this->conn->prepare($update);
            $stmtUpdate->bindParam(':quantity', $newQty);
            $stmtUpdate->bindParam(':cart_id', $this->cart_id);
            $stmtUpdate->bindParam(':product_id', $this->product_id);
            $stmtUpdate->execute();
        } else {
            // 👉 Nếu chưa có, thêm mới
            $insertItem = "INSERT INTO cartitems (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)";
            $stmtInsert = $this->conn->prepare($insertItem);
            $stmtInsert->bindParam(':cart_id', $this->cart_id);
            $stmtInsert->bindParam(':product_id', $this->product_id);
            $stmtInsert->bindParam(':quantity', $this->quantity);
            $stmtInsert->execute();
        }

        $this->conn->commit();
        return true;
            
        }catch(PDOException $e){
            $this->conn->rollBack();
            return false;
        }  
    }
    //show gio hang
    public function show() {
        $query = "SELECT * FROM carts 
        JOIN cartitems ON carts.cart_id = cartitems.cart_id
        JOIN products ON cartitems.product_id = products.product_id Where carts.customer_id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->customer_id);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
        exit();
        }
        return $stmt;
    }
    //update so luong
    public function update() {
        $query = "UPDATE cartitems JOIN carts ON carts.cart_id = cartitems.cart_id SET cartitems.quantity=:quantity WHERE customer_id=:customer_id AND cartitems.id=:id";
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmt->bindParam(':id',$this->id);
        $stmt->bindParam(':quantity',$this->quantity);
        if ($stmt->execute()) {
        return true;
    }
    return false;
    }
    //delete
    public function delete() {
        $query = "DELETE FROM cartitems WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bind data
        $stmt->bindParam(':id',$this->id);
        if($stmt->execute()){
            return true;
        }
    }
    //get product id
    public function GetProductID(){
        $query = "SELECT product_id FROM cartitems as ci JOIN carts as c ON ci.cart_id=c.cart_id WHERE customer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->customer_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //get cart id
    public function GetCartID(){
        $query = "SELECT cart_id FROM carts WHERE customer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->customer_id);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cart['cart_id'] ?? null;
    }
    //get cart items
    public function GetCartItems($cart_id) {
        $query = "
            SELECT ci.product_id, ci.quantity, p.price 
            FROM cartitems ci
            JOIN products p ON ci.product_id = p.product_id
            WHERE ci.cart_id = ?
            ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$cart_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //delete cart items
    public function DeleteCart($cart_id) {
        $query = "DELETE FROM cartitems  WHERE cart_id=:cart_id";
        $stmt = $this->conn->prepare($query);
        //clean data
        //bind data
        $stmt->bindParam(':cart_id',$cart_id);
        if($stmt->execute()){
            return true;
        }
    }

    public function countItems($customer_id) {
    // Lấy cart_id theo customer_id
    $sql = "SELECT cart_id FROM carts WHERE customer_id = :customer_id LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->execute();
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($cart) {
        $cart_id = $cart['cart_id'];
        // Lấy tổng số lượng sản phẩm
        $sql2 = "SELECT SUM(quantity) AS total FROM cartitems WHERE cart_id = :cart_id";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->bindParam(':cart_id', $cart_id);
        $stmt2->execute();
        $result = $stmt2->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    return 0;
}
}
?>