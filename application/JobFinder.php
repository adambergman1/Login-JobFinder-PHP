<?php

namespace application;

# View
require_once('view/Messages.php');
require_once('view/LayoutView.php');
require_once('view/JobFinderView.php');
require_once('view/DateTimeView.php');

# Controller
require_once('controller/MainController.php');

# Model
require_once('model/API.php');
require_once('model/SearchPhrase.php');
require_once('model/JobsCollection.php');
require_once('model/Job.php');

class JobFinder {
    private $auth;
    private $layoutView;
    private $jobView;
    private $dtv;
    private $mc;
    private $authView;

    public function __construct (\login\controller\MainController $mainController) {
        $this->auth = $mainController;
        $this->layoutView = new \application\view\LayoutView();
        $this->jobView = new \application\view\JobFinderView();
        $this->dtv = new \application\view\DateTimeView();
        $this->mc = new \application\controller\MainController($this->jobView);
    }

    public function handleInput () : void {
        $this->authView = $this->getAuthView();
        
        if ($this->isLoggedIn()) {
            $this->mc->start();
        }
    }

    public function getOutput () : void {
        if ($this->isLoggedIn()) {
            $this->layoutView->render($this->isLoggedIn(), $this->authView, $this->dtv, $this->jobView);
        } else {
            $this->layoutView->render($this->isLoggedIn(), $this->authView, $this->dtv);
        }
    }

    private function isLoggedIn () : bool {
        return $this->auth->isLoggedIn();
    }

    private function getAuthView () : \login\view\View {
        return $this->auth->run();
    }
}