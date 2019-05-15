<?php
/**
 * Class Member represents a member in the dating site
 *
 * The Member class represents a member with a name, age, gender, phone,
 * and other descriptions available to the user, you can retrieve their vlaues using their
 * corresponding getters and setters.
 *
 * @author Maria Gallardo <mgallardo3@mail.greenriver.edu>
 * @copyright 2019
 */
class Member
{
    public $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Member constructor with parameters to instantiate the Member class
     * @param $fname string that contains the name of the Member
     * @param $lname string that contains the last name of the Memver
     * @param $age int that contains the age
     * @param $gender string that contains the gender
     * @param $phone string that stores the phone number
     */
    function __construct($fname,$lname, $age,$phone,$gender)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_phone = $phone;
        $this->_gender = $gender;

    }

    /**
     * Returns the Member's first name
     * @return string, $_fname returns the first name
     */
    public function getFname()
    {
        return $this->_fname;

    }

    /**
     * Sets the Member's name
     * @param string $fname, contains the first name
     * @return void
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * Returns the Member's last name
     * @return string, $_lname returns the last name
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * Sets the Member's last name
     * @param string $lname, contains the last name
     * @return void
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * Returns the Member's age
     * @return int, $_age returns the age
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * Sets the Member's age
     * @param int $age, contains the age
     * @return void
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * Returns the Member's gender
     * @return string, $_gender returns the gender
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * Sets the Member's gender
     * @param string $gender, contains the gender
     * @return void
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * Returns the Member's phone number
     * @return string, $_phone returns the phone number
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Sets the Member's phone number
     * @param string $phone, contains the phone number
     * @return void
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Returns the Member's email
     * @return string, $_email returns the email
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets the Member's email
     * @param string $email, contains the email
     * @return void
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Returns the Member's state
     * @return string, $_state returns the state
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Sets the Member's state
     * @param string $state, contains the state
     * @return void
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * Returns the Member's seeking status
     * @return string, $_status returns the seeking status
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * Sets the Member's seeking status
     * @param string $seeking, contains the seeking status
     * @return void
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * Returns the Member's bio
     * @return string, $_bio returns the bio
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * Sets the Member's bio
     * @param string $bio, contains the bio
     * @return void
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }



}