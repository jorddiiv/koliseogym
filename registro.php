<?php
require_once("config.php");
class Registro {
    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(DSN, USER, PASS);     
        }catch(PDOException $e){
            die("Error" . $e->get_message());
        }
    }

    public function __destruct() {
        $this->conn = null;
    }

    public function registrarUsuario() {
        try {
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                if(isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["fecha_nac"]) 
                && isset($_POST["address"]) && isset($_POST["email"]) && isset($_POST["telephone"]) && isset($_POST["password"])) { 
                    $nombre = htmlspecialchars(trim($_POST["name"]));
                    $apellidos = htmlspecialchars(trim($_POST["lastname"]));
                    $fecha_nac = htmlspecialchars(trim($_POST["fecha_nac"]));
                    $direccion = htmlspecialchars(trim($_POST["address"]));
                    $email = htmlspecialchars(trim($_POST["email"]));
                    $telefono = htmlspecialchars(trim($_POST["telephone"]));
                    $contrasena = htmlspecialchars(trim($_POST["password"]));
                }
            }
            $query = "INSERT INTO clientes(Nombre, Correo_Electronico, password, Apellido, Fecha_Nacimiento, Direccion, Telefono) VALUES (:name, :email, :password, :lastname, :fecha_nac, :address, :telephone)";
            $stmt = $this->conn->prepare($query);
            if(!$stmt){
                echo "Error en la preparación";
                exit;
            }
            $stmt->bindParam(":name", $nombre);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $contrasena);
            $stmt->bindParam(":lastname", $apellidos);
            $stmt->bindParam(":fecha_nac", $fecha_nac);
            $stmt->bindParam(":address", $direccion);
            $stmt->bindParam(":telephone", $telefono);
            $stmt->execute();
            header("Location:login.html");
        }catch(PDOException$es) {
            die("Error" . $es->get_message());
        }
    }
}

$registro = new Registro();
$registro->registrarUsuario();