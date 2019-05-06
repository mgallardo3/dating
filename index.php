<?php
/**
 * @athor by Maria Gallardo.
 * @version 1.0
 * File: index.php
 *
 * This file is the controller that routes the user to the home page
 */

//Start a session
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Required file
require_once('vendor/autoload.php');
require_once('model/validate-data.php');

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
    if(!empty($_POST))
    {
        //retrieve data
        //Get data from form
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

        if(validForm())
        {
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['age'] = $age;
            $_SESSION['gender'] = $gender;
            $_SESSION['phone'] = $phone;

            //Redirect to Summary
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
    if(!empty($_POST))
    {
        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $bio = $_POST['bio'];

        //store to F3 variables
        $f3->set('email',$email);
        $f3 ->set('state',$state);
        $f3 ->set('seeking',$seeking);
        $f3->set('bio',$bio);

        if(validProfile())
        {
            $_SESSION['email'] = $email;
            $_SESSION['state'] = $state;
            $_SESSION['seeking'] = $seeking;
            $_SESSION['bio'] = $bio;

            $f3->reroute('/interests');
        }
    }
    //display a view
    $view = new Template();
    echo $view-> render('views/profile.html');
});

//Add a post route
$f3->route('GET|POST /interests', FUNCTION($f3)
{
    if(!empty($_POST))
    {
        //store user information
        $interests= $_POST['interests'];

        //store to F3 variables
        $f3->set('interests',$interests);

        if(validateActivity())
        {
            $_SESSION['interests'] = implode(', ', $interests);
            $f3->reroute('/summary');

        }
    }

    //display a view
    $view = new Template();
    echo $view-> render('views/interests.html');
});

//Add a post route
$f3->route('GET|POST /summary', FUNCTION()
{
    //display a view
    $view = new Template();
    echo $view-> render('views/summary.html');
});


$f3 -> run();

