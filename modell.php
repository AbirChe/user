
<?php 
    Class Model{
 
        private $server = "localhost";
        private $username = "root";
        private $password = "";
        private $db = "minprojet";
        private $conn;
 
        public function __construct(){
            try {
                 
                $this->conn = new mysqli($this->server,$this->username,$this->password,$this->db);
            } catch (Exception $e) {
                echo "connection failed" . $e->getMessage();
            }
        }
 
        public function insert(){
 
            if (isset($_POST['submit'])) {
                if (isset($_POST['nom'])&& isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['id_user']) ) {
                    if (!empty($_POST['nom'])&& !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['id_user']) ) {
                         
                        $nom = $_POST['nom'];
                        $prenom = $_POST['prenom'];
                        $email = $_POST['email'];
                        $id_user = $_POST['id_user'];

                       
                        
                        
 
                        $query = "INSERT INTO etudiants (nom,prenom,email,id_user) VALUES ('$nom','$prenom','$email','$id_user')";
                        if ($sql = $this->conn->query($query)) {
                            echo "<script>alert('records added successfully');</script>";
                            echo "<script>window.location.href = 'index.php';</script>";
                        }else{
                            echo "<script>alert('failed');</script>";
                            echo "<script>window.location.href = 'index.php';</script>";
                        }
 
                    }else{
                        echo "<script>alert('empty');</script>";
                        echo "<script>window.location.href = 'index.php';</script>";
                    }
                }
            }
        }
 
        public function fetch(){
            $data = null;
 
            $query = "SELECT * FROM etudiants";
            if ($sql = $this->conn->query($query)) {
                while ($row = mysqli_fetch_assoc($sql)) {
                    $data[] = $row;
                }
            }
            return $data;
        }
 
        public function delete($id){
 
            $query = "DELETE FROM etudiants where id = '$id'";
            if ($sql = $this->conn->query($query)) {
                return true;
            }else{
                return false;
            }
        }
 
        public function fetch_single($id){
 
            $data = null;
 
            $query = "SELECT * FROM etudiants WHERE id = '$id'";
            if ($sql = $this->conn->query($query)) {
                while ($row = $sql->fetch_assoc()) {
                    $data = $row;
                }
            }
            return $data;
        }
 
        public function edit($id){
            
            $data = null;
 
            $query = "SELECT * FROM etudiants WHERE id = '$id'";
            if ($sql = $this->conn->query($query)) {
                while($row = $sql->fetch_assoc()){
                    $data = $row;
                }
            }
            return $data;
        }
 
        public function update($data){
 
            $query = "UPDATE etudiants SET nom='$data[nom]', prenom='$data[prenom]', email='$data[email]', id_user='$data[id_user]' WHERE id='$data[id] '";
 
            if ($sql = $this->conn->query($query)) {
                return true;
            }else{
                return false;
            }
        }
    }
 ?>