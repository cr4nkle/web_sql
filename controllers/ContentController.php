<?php
require_once "BaseTableTwigController.php";//добавить авторизацию для студентов и админа, студенту запретить редактировать записи(только свои)

class ContentController extends BaseTableTwigController {
    public $template = "table.twig";

    public function getContext(): array
    {
        $context = parent::getContext();
        if(!isset($_GET['table_type'])){

        }else{
            $table = $_GET['table_type'];
            $context['table_type'] = $table;
            if(strcmp("Grades", $table) == 0){
                $sql = <<<EOL
SELECT * FROM Grades
EOL;
            }else if(strcmp("Group", $table) == 0){
                $sql = <<<EOL
SELECT * FROM [Group]
EOL;
            }else if(strcmp("Student", $table) == 0){
                $sql = <<<EOL
SELECT * FROM Student
EOL;
            }else if(strcmp("Syllabus", $table) == 0){
                $sql = <<<EOL
SELECT * FROM Syllabus
EOL;
            }else if(strcmp("Subject", $table) == 0){
                $sql = <<<EOL
SELECT * FROM Subject
EOL;
            }else{
                header("/");
                exit;
            }
            // echo "<pre>";
            //     print_r($_GET['table_type']);
            // echo "</pre>";
            
            $query = $this->pdo->prepare($sql); 
            // $query->execute();        
            $context['horse_menu'] = $query->fetchAll();// send id
            $query = $this->pdo->prepare("SELECT COUNT(column_name)-1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :table_type");
            $query->bindValue("table_type", $table);
            $query->execute();   
            $context['count'] = $query->fetch();
            $query = $this->pdo->prepare("SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :table_type");
            $query->bindValue("table_type", $table);
            $query->execute();   
            $context['column_name'] = $query->fetchAll();

        }        

        return $context;
    }
}

