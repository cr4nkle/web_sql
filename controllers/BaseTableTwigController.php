<?php

class BaseTableTwigController extends TwigBaseController{
    
    public function getContext(): array
    {
        $context = parent::getContext();
        if($_SESSION['role'] == 'admin'){

        }else{
            $group_id = isset($_SESSION["group_id"]) ? $_SESSION["group_id"] : ''; 
            $sql = <<<EOL
SELECT subject_name FROM Syllabus WHERE id = :group_id
EOL;
            $query = $this->pdo->prepare($sql); 
            $query->bindValue("group_id", $group_id);
            $query->execute();   
            $context['subjects'] = $query->fetchAll();
        }

        
        return $context;
    }
}