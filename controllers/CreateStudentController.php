<?php
require_once "BaseTableTwigController.php";

class CreateStudentController extends BaseTableTwigController {
    public $template = "add_student.twig";

    public function getContext(): array
    {
        $sql = <<<EOL
SELECT id, code, DATEPART(yy,[group].[year]) as [year], number FROM [Group]
EOL;
        $query = $this->pdo->query($sql);
        $context['groups'] =$query->fetchAll();
        return $context;
    }

    public function post(array $context) {
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $date = $_POST['date'];
        $group_id = $_POST['group_id'];
        
        $sql = <<<EOL
exec CreateStudent :name, :gender, :group_id, :date
EOL;

        // подготавливаем запрос к БД
        $query = $this->pdo->prepare($sql);
        // привязываем параметры
        $query->bindValue("name", $name);
        $query->bindValue("gender", $gender);
        $query->bindValue("date", $date);
        $query->bindValue("group_id", $group_id);
        
        $query->execute();
        

        $this->get($context);
    }
}