<?php

class LogoutController extends BaseTableTwigController{

    public function getContext(): array
    {
        $context = parent::getContext();
        $_SESSION['is_logged'] = false;
        $_SESSION["role"] = null;
        $_SESSION["record_number"] = null;
        $_SESSION["group_id"] = null;
        header("Location: /");
        exit;
        return $context;
    }   

}