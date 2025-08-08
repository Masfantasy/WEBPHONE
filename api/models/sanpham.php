<?php
class Sanpham {
    private $conn;

    //question properties
    public $product_id;
    public $name;
    public $company;
    public $img;
    public $price;
    public $screen;
    public $os;
    public $camera;
    public $camera_front;
    public $cpu;
    public $ram;
    public $rom;
    public $microUSB;
    public $battery;
    //connect db
    public function __construct($db) {
        $this->conn = $db;
    }
    //get data
    public function read() {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    //show data
    public function show() {
        $query = "SELECT * FROM products JOIN productdetails ON products.product_id = productdetails.product_id Where products.product_id=? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->product_id);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
        echo json_encode(["message" => "ID sản phẩm không tồn tại"]);
        exit();
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->company = $row['company'];
        $this->img = $row['img'];
        $this->price = $row['price'];
        $this->screen = $row['screen'];
        $this->os = $row['os'];
        $this->camera = $row['camera'];
        $this->camera_front = $row['camera_front'];
        $this->cpu = $row['cpu'];
        $this->ram = $row['ram'];
        $this->rom = $row['rom'];
        $this->microUSB = $row['microUSB'];
        $this->battery = $row['battery'];
    }
    // //search
    // public function search($keyword = '', $company = '', $min_price = 0, $max_price = PHP_INT_MAX){
    //     $query = "SELECT * FROM products WHERE 1=1";
    //     $params = [];

    //     if (!empty($keyword)) {
    //         $query .= " AND name LIKE ?";
    //         $params[] = "%$keyword%";
    //     }
    //     if (!empty($company)) {
    //         $query .= " AND company = ?";
    //         $params[] = $company;
    //     }

    //     $query .= " AND price >= ? AND price <= ?";
    //     $params[] = $min_price;
    //     $params[] = $max_price;

    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute($params);

    //     return $stmt;
    // }
    public function search($keyword, $company = '', $min_price = 0, $max_price = PHP_INT_MAX) {
    $sql = "SELECT * FROM products WHERE name LIKE :kw AND price BETWEEN :min AND :max";
    if ($company !== '') {
        $sql .= " AND company = :company";
    }
    $stmt = $this->conn->prepare($sql);
    $kw = '%' . $keyword . '%';
    $stmt->bindParam(':kw', $kw);
    $stmt->bindParam(':min', $min_price);
    $stmt->bindParam(':max', $max_price);
    if ($company !== '') {
        $stmt->bindParam(':company', $company);
    }
    $stmt->execute();
    return $stmt;
}
    //create
    public function create() {
        try{
            $this->conn->beginTransaction();
            $query = "SELECT product_id FROM products WHERE product_id=:product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':product_id',$this->product_id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
            // Trả về thông báo lỗi nếu trùng
            echo json_encode(["Mã sản phẩm đã tồn tại"]);
            return false;
            }
            $query1 = "INSERT INTO products  SET product_id=:product_id, name=:name ,company=:company ,img=:img ,price=:price";
            $stmt1 = $this->conn->prepare($query1);
            //clean data
            $this->product_id = htmlspecialchars(strip_tags($this->product_id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->company = htmlspecialchars(strip_tags($this->company));
            $this->img = htmlspecialchars(strip_tags($this->img));
            $this->price = htmlspecialchars(strip_tags($this->price));
            

            $stmt1->bindParam(':product_id',$this->product_id);
            $stmt1->bindParam(':name',$this->name);
            $stmt1->bindParam(':company',$this->company);
            $stmt1->bindParam(':img',$this->img);
            $stmt1->bindParam(':price',$this->price);
            $stmt1->execute();

            $query2 = "INSERT INTO productdetails  SET product_id=:product_id ,screen=:screen ,os=:os ,camera=:camera ,camera_front=:camera_front ,cpu=:cpu ,ram=:ram ,rom=:rom, microUSB=:microUSB ,battery=:battery";
            $stmt2 = $this->conn->prepare($query2);

            //clean data
            $this->product_id = htmlspecialchars(strip_tags($this->product_id));
            $this->screen = htmlspecialchars(strip_tags($this->screen));
            $this->os = htmlspecialchars(strip_tags($this->os));
            $this->camera = htmlspecialchars(strip_tags($this->camera));
            $this->camera_front = htmlspecialchars(strip_tags($this->camera_front));
            $this->cpu = htmlspecialchars(strip_tags($this->cpu));
            $this->ram = htmlspecialchars(strip_tags($this->ram));
            $this->rom = htmlspecialchars(strip_tags($this->rom));
            $this->microUSB = htmlspecialchars(strip_tags($this->microUSB));
            $this->battery = htmlspecialchars(strip_tags($this->battery));
            
            $stmt2->bindParam(':product_id',$this->product_id);
            $stmt2->bindParam(':screen',$this->screen);
            $stmt2->bindParam(':os',$this->os);
            $stmt2->bindParam(':camera',$this->camera);
            $stmt2->bindParam(':camera_front',$this->camera_front);
            $stmt2->bindParam(':cpu',$this->cpu);
            $stmt2->bindParam(':ram',$this->ram);
            $stmt2->bindParam(':rom',$this->rom);
            $stmt2->bindParam(':microUSB',$this->microUSB);
            $stmt2->bindParam(':battery',$this->battery);
            $stmt2->execute();
            $this->conn->commit();
            echo json_encode("Thêm sản phẩm thành công");
            return true;
        }catch (PDOException $e){
            $this->conn->rollBack();
            echo json_encode("Thêm sản phẩm thất bại");
            return false;
        }
        
    }
    //update
    public function update() {
        try{
            $this->conn->beginTransaction();
            $query1 = "UPDATE products  SET name=:name ,company=:company ,img=:img ,price=:price WHERE product_id=:product_id";
            $stmt1 = $this->conn->prepare($query1);
            //clean data
            $this->product_id = htmlspecialchars(strip_tags($this->product_id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->company = htmlspecialchars(strip_tags($this->company));
            $this->img = htmlspecialchars(strip_tags($this->img));
            $this->price = htmlspecialchars(strip_tags($this->price));
            

            $stmt1->bindParam(':product_id',$this->product_id);
            $stmt1->bindParam(':name',$this->name);
            $stmt1->bindParam(':company',$this->company);
            $stmt1->bindParam(':img',$this->img);
            $stmt1->bindParam(':price',$this->price);
            $stmt1->execute();


            $query2 = "UPDATE productdetails  SET screen=:screen ,os=:os ,camera=:camera ,camera_front=:camera_front ,cpu=:cpu ,ram=:ram ,rom=:rom, microUSB=:microUSB ,battery=:battery WHERE product_id=:product_id";
            $stmt2 = $this->conn->prepare($query2);

            //clean data
            $this->product_id = htmlspecialchars(strip_tags($this->product_id));
            $this->screen = htmlspecialchars(strip_tags($this->screen));
            $this->os = htmlspecialchars(strip_tags($this->os));
            $this->camera = htmlspecialchars(strip_tags($this->camera));
            $this->camera_front = htmlspecialchars(strip_tags($this->camera_front));
            $this->cpu = htmlspecialchars(strip_tags($this->cpu));
            $this->ram = htmlspecialchars(strip_tags($this->ram));
            $this->rom = htmlspecialchars(strip_tags($this->rom));
            $this->microUSB = htmlspecialchars(strip_tags($this->microUSB));
            $this->battery = htmlspecialchars(strip_tags($this->battery));
            
            $stmt2->bindParam(':product_id',$this->product_id);
            $stmt2->bindParam(':screen',$this->screen);
            $stmt2->bindParam(':os',$this->os);
            $stmt2->bindParam(':camera',$this->camera);
            $stmt2->bindParam(':camera_front',$this->camera_front);
            $stmt2->bindParam(':cpu',$this->cpu);
            $stmt2->bindParam(':ram',$this->ram);
            $stmt2->bindParam(':rom',$this->rom);
            $stmt2->bindParam(':microUSB',$this->microUSB);
            $stmt2->bindParam(':battery',$this->battery);
            $stmt2->execute();
            $this->conn->commit();
            echo json_encode("Sửa thông tin sản phẩm thành công");
            return true;
            
        }catch(PDOException $e){
            $this->conn->rollBack();
            echo json_encode("Sửa thông tin sản phẩm thất bại");
            return false;
        }
        
    }
    //delete
    public function delete() {
        $query = "DELETE FROM products WHERE product_id=:product_id";
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        //bind data
        $stmt->bindParam(':product_id',$this->product_id);
        if($stmt->execute()){
            return true;
        }
    }
}
?>