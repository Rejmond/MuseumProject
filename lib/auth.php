<?php

defined('MUSEUM_INTERNAL') || die;

class User {

    private $admin;
        
    public function __construct() {
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            $this->admin = true;
        }
    }
    
    public function authorise($password) {
        global $CONFIG;
        if ($password == $CONFIG->password) {
            $this->admin = true;
            $_SESSION['admin'] = true;
            return true;
        }
        return false;
    }

    public function logout() {
        $this->admin = false;
        unset($_SESSION['admin']);
    }

    public function is_admin() {
        return $this->admin;
    }

}
