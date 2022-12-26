<?php
require_once "BaseTableTwigController.php";

class MarkCreateController extends BaseTableTwigController {
    public $template = "add_mark.twig";

    public function getContext(): array
    {
        $group_id = $_GET['group_id'];
        $sql = <<<EOL
SELECT * FROM Syllabus WHERE id = :group_id
EOL;
        $query = $this->pdo->prepare($sql);
        $query->bindValue("group_id",$group_id);
        $query->execute();
        $context['subjects'] =$query->fetchAll();
    
        return $context;
    }


    public function post(array $context) {
        $record_number = $_GET['record_number'];
        $mark = $_POST['mark'];
        $subject = $_POST['subject'];
        $sql = <<<EOL
        INSERT INTO Grades (grade, subject_name, record_number)
VALUES(:mark, :subject, :record_number) 
EOL;
        $query = $this->pdo->prepare($sql);
        
        $query->bindValue("mark", $mark);
        $query->bindValue("record_number", $record_number);
        $query->bindValue("subject", $subject);
        
        $query->execute();
        

        $this->get($context);
    }
}