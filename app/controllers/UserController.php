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

    public function indexAction($id = NULL)
    { 
	if(NULL != $id ){ 
	    $user = User::findFirst($id);
	    $this->view->form = new RegisterForm($user);
	}else{
	    $this->tag->setTitle('Phalcon :: Register');
	    $this->view->form = new RegisterForm();
	}
    }
    
    public function addAction()
    {	$user = NULL;
    
	if($_POST['id']){
	    $user = User::findFirst($_POST['id']);
	}
	
	$form = new RegisterForm($user);

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
                    'action'     => "index",
			'params' =>[$_POST['id']]
                ]);
                return;
            }
        }

        # Doc :: https://docs.phalconphp.com/en/3.3/security
	if(NULL == $_POST['id']){
	    $this->userModel->setPassword($this->security->hash($_POST['password']));
	    $this->userModel->setConfirmPassword($this->security->hash($_POST['password']));
	}else{
	    $this->userModel->setPassword($user->getPassword());
	    $this->userModel->setConfirmPassword($user->getConfirmPassword());
	}

        
        # Doc :: https://docs.phalconphp.com/en/3.3/db-models#create-update-records
	if ( NULL == $_POST['id'] && !$this->userModel->save() || $_POST['id'] && !$this->userModel->update() ) {
           foreach ($this->userModel->getMessages() as $m) {
                $this->flashSession->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => "index",
			'params' =>[$_POST['id']]
                ]);
                return;
            }
        }

        $this->flashSession->success('Thanks for update!');
        return $this->response->redirect('user/view');

        $this->view->disable();
    }
    
    public function viewAction(){
	// Fetch All User Articles
        $users = User::find();
	
	$this->view->users = $users;
    }
    

}

