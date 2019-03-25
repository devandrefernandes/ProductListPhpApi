<?php
include_once '../Config/Defines.php';
include_once '../Config/Connect.php';

/**
 * Description of Class
 *
 * @author André Fernandes
 */

class ProductClass {
	//ATRIBUTOS DA CLASSE
    private $instance;
    private $product;
    private $title;
    private $description;
    private $url;
    private $page;
    private $limit;

	public function __set($atrib, $value) {
        $this->$atrib = $value;
    }

    public function __get($atrib) {
        return $this->$atrib;
    }

    function __construct() {
        $pdo = Connection::getInstance();
    }

	public static function getInstance() { 
		if (!isset(self::$instance)) 
			self::$instance = new Connection(); 
		return self::$instance; 
    }
    
    public function getConnection() {
        return Connection::getInstance();
    }

    function FindAll(){
        try {
            $sql = "SELECT 
                        p.IdProduct, 
                        p.Title, 
                        p.Description, 
                        p.Url
                    FROM Product p 
                    ORDER BY p.Title ASC 
                    LIMIT :start, :limit";
            $query = $this->getConnection()->prepare($sql);
            $query->bindValue(':start', $this->__get('start'), PDO::PARAM_INT);
            $query->bindValue(':limit', $this->__get('limit'), PDO::PARAM_INT);
            $query->execute();
                    
            $array = array();
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['IdProduct'];
                $array[$i]['title'] = $linha['Title'];
                $array[$i]['description'] = $linha['Description'];
                $array[$i]['url'] = $linha['Url'];
            }
            return $array;
        } catch (PDOException $e) {
            return "Error!: " . $e->getMessage();
        }
    }

    function FindCountAll(){
        try {
            $sql = "SELECT count(p.IdProduct) AS countAll FROM Product p";
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
                    
            $row = $query->fetch(PDO::FETCH_ASSOC);
            
            return $row['countAll'];
        } catch (PDOException $e) {
            return "Error!: " . $e->getMessage();
        }
    }

    function FindById(){
        try {
            $sql = "SELECT 
                        p.IdProduct, 
                        p.Title, 
                        p.Description, 
                        p.Url
                    FROM Product p 
                    WHERE p.IdProduct = :product
                    ORDER BY p.Title ASC";
            $query = $this->getConnection()->prepare($sql);
            $query->bindValue(':product', $this->__get('product'), PDO::PARAM_INT);
            $query->execute();
            
            $array = array();
            for ($i = 0; $linha = $query->fetch(PDO::FETCH_ASSOC); $i++) {
                $array[$i]['id'] = $linha['IdProduct'];
                $array[$i]['title'] = $linha['Title'];
                $array[$i]['description'] = $linha['Description'];
                $array[$i]['url'] = $linha['Url'];
            }
            return $array;
        } catch (PDOException $e) {
            return "Error!: " . $e->getMessage();
        }
    }

    function Create() {
        try {
            $sql = "INSERT INTO Product 
                        (Title, Description, Url) 
                    VALUES 
                        (:title, :description, :url);";
            $query = $this->getConnection()->prepare($sql);
            $query->bindValue(':title', $this->__get('title'), PDO::PARAM_STR);
            $query->bindValue(':description', $this->__get('description'), PDO::PARAM_STR);
            $query->bindValue(':url', $this->__get('url'), PDO::PARAM_STR);
            $query->execute();
            
            $product = $this->getConnection()->lastInsertId();
            $this->__set('product', $product);
            $array = $this->FindById();
            return $array;
        } catch (PDOException $e) {
            return "Error!: " . $e->getMessage();
        }
    }

    function Update() {
        try {
            $sql = "UPDATE Product SET 
                        Title = :title, 
                        Description = :description, 
                        Url = :url
                    WHERE IdProduct = :idProduct;";
            $query = $this->getConnection()->prepare($sql);
            $query->bindValue(':title', $this->__get('title'), PDO::PARAM_STR);
            $query->bindValue(':description', $this->__get('description'), PDO::PARAM_STR);
            $query->bindValue(':url', $this->__get('url'), PDO::PARAM_STR);
            $query->bindValue(':idProduct', $this->__get('product'), PDO::PARAM_INT);
            $query->execute();
            
            $array = $this->FindById();
            return $array;
        } catch (PDOException $e) {
            return "Error!: " . $e->getMessage();
        }
    }

    function Delete() {
        try {
            $sql = "DELETE FROM Product WHERE IdProduct = :idProduct;";
            $query = $this->getConnection()->prepare($sql);
            $query->bindValue(':idProduct', $this->__get('product'), PDO::PARAM_INT);
            $query->execute();
            
            $array = array();
            $array['return'] = 'success';

            return $array;
        } catch (PDOException $e) {
            return "Error!: " . $e->getMessage();
        }
    }
}