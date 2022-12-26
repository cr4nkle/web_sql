<?php
require_once "BaseTableTwigController.php";

class MarkController extends BaseTableTwigController {
    public $template = "mark.twig";

    public function getContext(): array
    {
        $context = parent::getContext();  
        $record_number = isset($_SESSION["record_number"]) ? $_SESSION["record_number"] : $_GET['record_number']; 
        $sql = <<<EOL
SELECT * FROM Grades WHERE record_number = :record_number
EOL;
        $query = $this->pdo->prepare($sql); 
        $query->bindValue("record_number", $record_number);
        $query->execute();   
        $context['marks'] = $query->fetchAll();
        $context['header'] = 'My marks';    
        
        return $context;
    }
}