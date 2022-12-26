<?php
require_once "BaseTableTwigController.php";

class MainController extends BaseTableTwigController {
    public $template = "main.twig";

    public function getContext(): array
    {
        $context = parent::getContext();  
        if($_SESSION['role'] == 'admin'){
            $cure_page = isset($_GET['page']) ? $_GET['page'] : '';
        $limit = 100;
        $start = 0;
        $sql = <<<EOL
SELECT count(*) from Student
EOL;
        $query = $this->pdo->query($sql);
        $count_all = $query->fetch();
        $sql = <<<EOL
SELECT * 
FROM Student_info
ORDER BY record_number
  OFFSET cast(:start as int) ROWS FETCH NEXT cast(:limit as int) ROWS ONLY
EOL;
        if($cure_page != ''){
            $start = $limit*$cure_page-$limit; 
        }        
        $query = $this->pdo->prepare($sql);
        $query->bindValue("start",$start);
        $query->bindValue("limit",$limit);
        
        $query->execute();
        $context['students'] = $query->fetchAll();
        

        $navi = new PaginateNavigationBuilder( "/?page={page}" );
        $navi->tpl = "{page}";
        $nav = $navi->build( $limit, $count_all[0] , $cure_page ); 
        $context['nav'] = $nav;
        }
        $context['header'] = 'My subject';
        return $context;
    }
}