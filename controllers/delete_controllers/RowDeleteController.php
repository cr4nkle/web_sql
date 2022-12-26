<?php

class RowDeleteController extends BaseController {
    public function post(array $context)
    {
        if(isset($_POST['record_number'])){
            $record_number = $_POST['record_number'];

            $sql =<<<EOL
DELETE FROM Student WHERE record_number = :record_number
EOL; 
        
            $query = $this->pdo->prepare($sql);
            $query->bindValue("record_number", $record_number);  
        }elseif(isset($_POST['grade_id'])){
            $grade_id = $_POST['grade_id'];
            $sql =<<<EOL
DELETE FROM Grades WHERE grade_id = :grade_id
EOL; 
        
            $query = $this->pdo->prepare($sql);
            $query->bindValue("grade_id", $grade_id);
        }
        
        $query->execute();
        header("Location: /");
        exit;
    }
}