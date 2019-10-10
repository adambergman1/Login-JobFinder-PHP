<?php

namespace application;

require_once('view/LayoutView.php');
require_once('view/MainView.php');
require_once('view/DateTimeView.php');
require_once('controller/MainController.php');
require_once('model/API.php');

class JobFinder {
    private $auth;
    private $layoutView;
    private $mainView;
    private $dtv;

    public function __construct ($mc) {
        $this->auth = $mc;
        
        $this->layoutView = new \application\view\LayoutView();
        $this->mainView = new \application\view\MainView();
        $this->dtv = new \application\view\DateTimeView();
    }

    public function start () {
        $view = $this->auth->getMainController()->run();
        $isLoggedIn = $this->auth->getMainController()->isLoggedIn();

        if ($isLoggedIn) {
            new \application\controller\MainController($this->mainView);
            return $this->layoutView->render($isLoggedIn, $view, $this->dtv, $this->mainView);
        } else {
            return $this->layoutView->render($isLoggedIn, $view, $this->dtv);
        }

    }
}