<?php

namespace application;

require_once('view/Messages.php');
require_once('view/LayoutView.php');
require_once('view/MainView.php');
require_once('view/DateTimeView.php');
require_once('controller/MainController.php');
require_once('model/API.php');
require_once('model/SearchPhrase.php');
require_once('model/JobsCollection.php');
require_once('model/Job.php');

class JobFinder {
    private $auth;
    private $layoutView;
    private $mainView;
    private $dtv;
    private $mc;
    private $authView;

    public function __construct ($mc) {
        $this->auth = $mc;
        $this->layoutView = new \application\view\LayoutView();
        $this->mainView = new \application\view\MainView();
        $this->dtv = new \application\view\DateTimeView();
        $this->mc = new \application\controller\MainController($this->mainView);
    }

    public function handleInput () {
        $this->authView = $this->getAuthView();
        
        if ($this->isLoggedIn()) {
            $this->mc->start();
        }
    }

    public function getOutput () {
        if ($this->isLoggedIn()) {
            return $this->layoutView->render($this->isLoggedIn(), $this->authView, $this->dtv, $this->mainView);
        } else {
            return $this->layoutView->render($this->isLoggedIn(), $this->authView, $this->dtv);
        }
    }

    private function isLoggedIn () {
        return $this->auth->getMainController()->isLoggedIn();
    }

    private function getAuthView () {
        return $this->auth->getMainController()->run();
    }
    
}