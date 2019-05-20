<?php
use Phalcon\Http\Request;

// use form
use App\Forms\RegisterForm;

class UserController extends ControllerBase
{
   
    public $userModel;
    
    public function initialize()
    {
        $this->userModel = new User();
    }

    public function indexAction()
    {
	$this->tag->setTitle('Phalcon :: Register');
        $this->view->form = new RegisterForm();
    }
    
    public function addAction()
    {
	$form = new RegisterForm();

        // check request
        if (!$this->request->isPost()) {
            return $this->response->redirect('user');
        }

        $form->bind($_POST, $this->userModel);
        // check form validation
        if (!$form->isValid()) {
            foreach ($form->getMessages() as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => '',
                ]);
                return;
            }
        }

        # Doc :: https://docs.phalconphp.com/en/3.3/security
        $this->userModel->setPassword($this->security->hash($_POST['password']));

        
        # Doc :: https://docs.phalconphp.com/en/3.3/db-models#create-update-records
        if (!$this->userModel->save()) {
            foreach ($this->userModel->getMessages() as $m) {
                $this->flashSession->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => '',
                ]);
                return;
            }
        }

        /**
         * Send Email
         */
        // $params = [
        //     'name' => $this->request->getPost('name'),
        //     'link' => "http://localhost/_Phalcon/demo-app2/signup"
        // ];
        // $mail->send($this->request->getPost('email', ['trim', 'email']), 'signup', $params);

        $this->flashSession->success('Thanks for registering!');
        return $this->response->redirect('user');

        $this->view->disable();
    }
    
    public function viewAction(){
	// Fetch All User Articles
        $users = User::find();
	
	print_r($users);


        /**
         * Send Data in View Template
         * --------------------------------------------------------
         * $this->view->articlesdata = "Auth ID";
         * $this->view->setVars(['articlesdata' => "Auth ID"]);
         */
       // $this->view->articlesData = $articles;
    }

}

