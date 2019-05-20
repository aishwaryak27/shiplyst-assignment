<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as Uniqueness;

class User extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $fname;

    /**
     *
     * @var string
     */
    public $lname;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $confirm_password;

    /**
     *
     * @var string
     */
    public $gender;
    
    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field fname
     *
     * @param string $fname
     * @return $this
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }
    
     /**
     * Method to set the value of field lname
     *
     * @param string $lname
     * @return $this
     */
    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Method to set the value of field confirm password
     *
     * @param string $confirm_password
     * @return $this
     */
    public function setConfirmPassword($password)
    {
        $this->confirm_password = $password;

        return $this;
    }

    /**
     * Method to set the value of field gender
     *
     * @param string $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }
    
    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Returns the value of field confirm password
     *
     * @return string
     */
    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }

    /**
     * Returns the value of field gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Validations and business logic
     */
    public function validation()
    {

        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        $validator->add(
            'email',
            new Uniqueness(
                [
                    'model'   => $this,
                    'message' => 'Another user with same email already exists',
                    'cancelOnFail' => true,
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'fname' => 'fname', 
            'lname' => 'lname', 
            'email' => 'email', 
            'password' => 'password', 
            'confirm_password' => 'confirm_password', 
            'gender' => 'gender'
        );
    }
    
    public function initialize()
    {
        $this->setSchema("user");
        $this->setSource("user");
    }
    
    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }
    
    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }
    
    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
