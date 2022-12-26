<?php
require_once "BaseTableTwigController.php";

class SearchController extends BaseTableTwigController {
    public $template = "search.twig";

    public function getContext(): array
    {
        $context = parent::getContext();
        $context['header'] = 'Search';
        $record_number = isset($_SESSION["record_number"]) ? $_SESSION["record_number"] : '';
        $subject = isset($_GET['subject']) ? $_GET['subject'] : '';
        $grade = isset($_GET['grade']) ? $_GET['grade'] : '';
        $sql = <<<EOL
SELECT subject_name, grade
FROM Grades
WHERE (record_number = :record_number) 
and ((:subject = '' OR subject_name like(:temp_s)) and (:grade1 = '' OR grade = :grade)) 
EOL;
        $query = $this->pdo->prepare($sql);
        $query->bindValue("temp_s", "%$subject%");
        $query->bindValue("subject", $subject);
        $query->bindValue("grade", $grade);
        $query->bindValue("grade1", $grade);
        $query->bindValue("record_number", $record_number);       
        $query->execute();

        $context['objects'] = $query->fetchAll();
        $context['subject'] = $subject;
        $context['grade'] = $grade;

        return $context;
    }
}