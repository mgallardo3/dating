<?php
/**
 * @athor by Maria Gallardo.
 * @version 1.0
 * File: index.php
 *
 * This file is the controller that routes the user to the home page
 */


//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Required file
require_once('vendor/autoload.php');
require_once('model/validate-data.php');

//Start a session
session_start();

//Instantiate Fat-Free
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Create states array
$f3->set('states',array('WASHINGTON','OREGON','IDAHO','MONTANA','WYOMING','ALASKA'));

//Create indoor activities
$f3->set('indoor', array('tv','movies','cooking','board games','puzzles','reading','playing cards',
    'video games'));

//Create outdoor activities array
$f3->set('outdoor', array('hiking','biking','swimming','collecting','walking','climbing'));

//instantiate database object, connection
$db = new Database();

//Define a default route
$f3->route('GET /', FUNCTION()
{
    //display a view
    $view = new Template();
    echo $view-> render('views/home.html');
});

//Add a post route
$f3->route('GET|POST /personal-information', FUNCTION($f3)
{
    //if a request has being submitted
    if(!empty($_POST)) {
        //retrieve data
        //Get data from form
        $premium = $_POST['premium'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];

        //Add data to hive
        $f3->set('fname', $fname);
        $f3->set('lname', $lname);
        $f3->set('age', $age);
        $f3->set('gender',$gender);
        $f3->set('phone', $phone);

        if(validForm()) {
            if(!empty($premium)){

                //create a premium user
               $_SESSION['user'] = new PremiumMember($fname,$lname,$age,$phone,$gender);


            } else {
                //Create a regular user
                $_SESSION['user'] = new Member($fname,$lname,$age,$phone,$gender);

            }
            $f3->reroute('/profile');
        }
    }
    //display a view
    $view = new Template();
    echo $view-> render('views/personal_info.html');
});

//Add a post route
$f3->route('GET|POST /profile', FUNCTION($f3)
{
    if(!empty($_POST)) {

        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $bio = $_POST['bio'];

        //store to F3 variables
        $f3->set('email',$email);
        $f3 ->set('state',$state);
        $f3 ->set('seeking',$seeking);
        $f3->set('bio',$bio);

        if(validProfile()) {
            $_SESSION['user']->setEmail($email);
            $_SESSION['user']->setState($state);
            $_SESSION['user']->setSeeking($seeking);
            $_SESSION['user']->setBio($bio);

            //if class member is premium go to interests
            if ($_SESSION['user'] instanceof PremiumMember) {

                $f3->reroute('/interests');

            } else {
                //else (member is not premium) reroute to the summary
                $f3->reroute('/summary');
            }
        }
    }

    $view = new Template();
    echo $view-> render('views/profile.html');
});

//Add a post route
$f3->route('GET|POST /interests', FUNCTION($f3)
{
    if(!empty($_POST)) {
        //store user information
        $indoor= $_POST['indoor'];
        $outdoor= $_POST['outdoor'];
        $interests='';


        //check if both interests are set, store into one variable for the validate-data
        if(!empty($indoor) && !empty($outdoor)) {
            $interests = array_merge($indoor,$outdoor);

            //store the information into the member object
            $_SESSION['user']->setInDoorInterests(($indoor));
            $_SESSION['user']->setOutDoorInterests(($outdoor));

        } else if(!empty($indoor)){
            $interests = $indoor;
            $_SESSION['user']->setInDoorInterests(($indoor));
            $_SESSION['user']->setOutDoorInterests("");


        } else if(!empty($outdoor)){
            $interests = $outdoor;
            $_SESSION['user']->setOutDoorInterests(($outdoor));
            $_SESSION['user']->setInDoorInterests("");
        }
        else
        {
            $_SESSION['user']->setOutDoorInterests("");
            $_SESSION['user']->setInDoorInterests("");

        }
        //store to F3 variables
        $f3->set('interests',$interests);

        //if data is valid proceed to save data
        if(validateActivity()) {

            $f3->reroute('/summary');
        }
    }

    //display a view
    $view = new Template();
    echo $view-> render('views/interests.html');
});

//Add a post route
$f3->route('GET|POST /summary', FUNCTION($f3)
{
    global $db;
    $member =$_SESSION['user'];

    //add member to F3
    $f3->set('member',$member);

    //insert the new user to the database
    $db->insertMembers();

    //display a view
    $view = new Template();
    echo $view-> render('views/summary.html');
});

$f3->route('GET /admin', FUNCTION($f3)
{
    //retrieve members from database
    global $db;
    $members = $db->getMembers();

    $f3->set("db",$db);
    $f3->set('members',$members);

    //display a view
    $view = new Template();
    echo $view-> render('views/admin.html');
});

$f3 -> run();

