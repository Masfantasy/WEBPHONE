<?php
class Khachhang {
    private $conn;

    //question properties
    public $customer_id;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $username;
    public $password;
    public $is_active;
    //connect db
    public function __construct($db) {
        $this->conn = $db;
    }
    //read data
    public function read() {
        $query = "SELECT * FROM customers";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    //show data
    public function show() {
        $query = "SELECT * FROM customers Where customer_id=? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->customer_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->address = $row['address'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->is_active = $row['is_active'];
    }
    //create
    public function create() {
        $query = "INSERT INTO customers SET name=:name ,email=:email ,phone=:phone ,address=:address ,username=:username ,password=:password ,is_active=:is_active";
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));

        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':phone',$this->phone);
        $stmt->bindParam(':address',$this->address);
        $stmt->bindParam(':username',$this->username);
        $stmt->bindParam(':password',$this->password);
        $stmt->bindParam(':is_active',$this->is_active);

        if($stmt->execute()){
            return true;
        }
        $error = $stmt->errorInfo();  // ✅ Lấy thông tin lỗi đúng cách
            printf("Error: %s\n", $error[2]);     // ✅ In thông báo lỗi chính xác

    }
    //update
    public function update() {
        $query = "UPDATE customers SET name=:name ,email=:email ,phone=:phone ,address=:address ,is_active=:is_active WHERE customer_id=:customer_id";
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));



        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':phone',$this->phone);
        $stmt->bindParam(':address',$this->address);
        $stmt->bindParam(':is_active',$this->is_active);

        if($stmt->execute()){
            return true;
        }
        $error = $stmt->errorInfo();  // ✅ Lấy thông tin lỗi đúng cách
            printf("Error: %s\n", $error[2]);     // ✅ In thông báo lỗi chính xác

    }
    //delete
    public function delete() {
        $query = "DELETE FROM customers WHERE customer_id=:customer_id";
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        //bind data
        $stmt->bindParam(':customer_id',$this->customer_id);


        if($stmt->execute()){
            return true;
        }
        $error = $stmt->errorInfo();  // ✅ Lấy thông tin lỗi đúng cách
            printf("Error: %s\n", $error[2]);     // ✅ In thông báo lỗi chính xác

    }
    //login
    public function login($username, $password) {
        $query = "SELECT * FROM customers WHERE username = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra tài khoản tồn tại và mật khẩu đúng
        if (!$row || $row['password'] !== $password) {
            return false; // Đăng nhập thất bại
        }

        // Gán dữ liệu vào thuộc tính của đối tượng
        $this->customer_id = $row['customer_id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->address = $row['address'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->is_active = $row['is_active'];

        return true; // Đăng nhập thành công
    }
}
?>