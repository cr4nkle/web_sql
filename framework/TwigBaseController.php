<?php

class TwigBaseController extends BaseController {
    public $template = "404.twig";
    protected \Twig\Environment $twig; 
    
    public function getContext() : array
    {
        $context = parent::getContext();        

        return $context;
    }
    
    public function get(array $context) {
        echo $this->twig->render($this->template, $context);
    }
}
