<?php

class LoginController extends BaseTableTwigController{
    public $template = "login.twig";

    public function getContext(): array
    {
        $context = parent::getContext();
        
        return $context;
    }

    public function post(array $context) {
        $record_number = $_POST['login'];
        $password = $_POST['password'];
        
        if($record_number == 'admin'){
            if($password == 'admin'){
                $_SESSION["is_logged"] = true;
                $_SESSION["role"] = 'admin';
                header("Location: /");
                exit;
            }
        }else{
$sql = <<<EOL
SELECT * FROM Student
    WHERE record_number = :record_number
EOL;
            $query =$this->pdo->prepare($sql);
            $query->bindValue("record_number", $record_number);
            $query->execute();
            $data = $query->fetch(); 
            $valid_password = $data['password']; 
            if($valid_password == $password){
                $_SESSION["is_logged"] = true;
                $_SESSION["role"] = 'student';
                $_SESSION["record_number"] = $record_number;
                $_SESSION["group_id"] = $data['id'];
                header("Location: /");
                exit;
            }
        }
        
        
        
    }

    

}