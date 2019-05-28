<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Hidden;
// Validation
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;

class RegisterForm extends Form
{
    public function initialize($user = NULL)
    {	
	$this->showPassowrd = false;
        /**
         * Fname
         */
        $fname = new Text('fname', [
            "class" => "form-control",
            // "required" => true,
            "placeholder" => "Enter Full Name"
        ]);

        // form name field validation
        $fname->addValidator(
            new PresenceOf(['message' => 'The first name is required'])
        );
	
	/**
         * Lname
         */
        $lname = new Text('lname', [
            "class" => "form-control",
            // "required" => true,
            "placeholder" => "Enter Full Name"
        ]);

        // form name field validation
        $fname->addValidator(
            new PresenceOf(['message' => 'The last name is required'])
        );

        /**
         * Email Address
         */
        $email = new Text('email', [
            "class" => "form-control",
            // "required" => true,
            "placeholder" => "Enter Email Address"
        ]);
	
	$id = new Hidden('id', [
            "class" => "form-control"
        ]);

        // form email field validation
        $email->addValidators([
            new PresenceOf(['message' => 'The email is required']),
            new Email(['message' => 'The e-mail is not valid']),
        ]);

        /**
         * New Password
         */
        $password = new Password('password', [
            "class" => "form-control",
            // "required" => true,
            "placeholder" => "Your Password"
        ]);
        if(NULL == $user){
	    
	    $password->addValidators([
		new PresenceOf(['message' => 'Password is required']),
		new StringLength(['min' => 5, 'message' => 'Password is too short. Minimum 5 characters.']),
		new Confirmation(['with' => 'confirm_password', 'message' => 'Password doesn\'t match confirmation.']),
	    ]);
	}


        /**
         * Confirm Password
         */
        $passwordNewConfirm = new Password('confirm_password', [
            "class" => "form-control",
            // "required" => true,
            "placeholder" => "Confirm Password"
        ]);

        if(NULL == $user){
	   
	    $passwordNewConfirm->addValidators([
		new PresenceOf(['message' => 'The confirmation password is required']),
	    ]);
	}
	
	/**
         * Gender
         */
       // $gender = new Text('gender', [
          //  "class" => "form-control",
            // "required" => true,
         //   "placeholder" => "Gender"
      //  ]);
	$selected_gender = [];
	if($user){
	    
	    $selected_gender = ['value'=>$user->gender];
	    
	}
	
	$gender = new Select(
	    'gender', 
	    [	'' => 'Select One',
		'f' => 'Female',
		'm' => 'Male'
	    ],
	$selected_gender);

        // form email field validation
        $gender->addValidators([
            new PresenceOf(['message' => 'Gender is required'])
        ]);


        /**
         * Submit Button
         */
	$btn_text = 'Register';
	if(NULL != $user){
	    $btn_text = 'Update';
	}
        $submit = new Submit('submit', [
            "value" => $btn_text,
            "class" => "btn btn-primary",
        ]);

        $this->add($fname);
	$this->add($lname);
        $this->add($email);
	if(!$user){
	$this->showPassowrd = true;
        $this->add($password);
        $this->add($passwordNewConfirm);
	}else{
	    $this->add($id);
	}
	$this->add($gender);
        $this->add($submit);
    }
}