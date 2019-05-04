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
$f3->route('GET|POST /profile', FUNCTION()
{
    //Store the fields from personal-information using a SESSION
    $_SESSION['fname'] = $_POST['fname'];
    $_SESSION['lname']= $_POST['lname'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['phone'] = $_POST['phone'];

    //display a view
    $view = new Template();
    echo $view-> render('views/profile.html');
});

//Add a post route
$f3->route('POST /interests', FUNCTION()
{
    //Store the fields from profile page using the SESSION
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['state']= $_POST['state'];
    $_SESSION['seeking'] = $_POST['seeking'];
    $_SESSION['biography'] = $_POST['biography'];

    //display a view
    $view = new Template();
    echo $view-> render('views/interests.html');
});

//Add a post route
$f3->route('POST /summary', FUNCTION()
{
    //Store the fields from interests page in an 'interests' array in SESSION
    $_SESSION['interests'] = $_POST['interest'];

    //check if interests were selected
    if(isset($_SESSION['interests']))
    {
        $stringInterests ='';

        //Loop through interests, concatenate values to a string
        foreach ($_SESSION['interests'] as $interest)
        {
            $stringInterests .= $interest .=" ";
        }
        //store string of Interests back into SESSION
        $_SESSION['interests'] = $stringInterests;
    }

    //display a view
    $view = new Template();
    echo $view-> render('views/summary.html');
});


$f3 -> run();

