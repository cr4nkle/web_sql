<?php
require_once "BaseTableTwigController.php";

class UserController extends BaseTableTwigController {
    public $template = "user.twig";

    public function getContext(): array
    {
        $context = parent::getContext();
        $record_number = isset($_SESSION["record_number"]) ? $_SESSION["record_number"] : $_GET['record_number'];
        $sql = <<<EOL
SELECT * FROM Student_Info WHERE record_number = :record_number
EOL;
        $query = $this->pdo->prepare($sql); 
        $query->bindValue("record_number", $record_number);
        $query->execute(); 
        $data =  $query->fetchAll();
        $context['students'] = $data[0];
        $context['header'] = 'My profile';

        return $context;
    }

    public function post(array $context) {
        $record_number = isset($_SESSION["record_number"]) ? $_SESSION["record_number"] : '';
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $date = $_POST['date'];
        
        $sql = <<<EOL
UPDATE Student
SET student_full_name = :name, sex = :gender, date_of_birth = :date
WHERE record_number = :record_number 
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("record_number", $record_number);
        $query->bindValue("name", $name);
        $query->bindValue("gender", $gender);
        $query->bindValue("date", $date);                
        $query->execute();

        $context = $this->getContext();

        $this->get($context);
    }

    
    
}

