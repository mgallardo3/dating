<?php
/**
 * Created by PhpStorm.
 * User: homefolder
 * Date: 2019-05-04
 * Time: 11:42
 */

function validForm()
{
    global $f3;
    $isValid = true;

    if (!validFname($f3->get('fname')))
    {
        $isValid = false;
        $f3->set("errors['fname']", "Enter a valid name");
    }

    if (!validLname($f3->get('lname')))
    {
        $isValid = false;
        $f3->set("errors['lname']", "Enter a valid Last name");
    }

    if (!validAge($f3->get('age')))
    {
        $isValid = false;
        $f3->set("errors['age']", "Enter a valid age, must be at least 18");
    }

    if (!validPhone($f3->get('phone')))
    {
        $isValid = false;
        $f3->set("errors['phone']", "Enter a phone number using the following format: 
        222-333-4444");
    }
    return $isValid;
}

function validProfile()
{
    global $f3;
    $isValid = true;

    if(!validEmail($f3->get('email')))
    {
        $isValid = false;
        $f3->set("errors['email']",'Enter a valid email');
    }

    if(!validState($f3->get('state'), $f3->get('states')))
    {
        $isValid = false;
        $f3->set("errors['state']" , "Not a valid state");
    }

    return $isValid;
}


function validFname($fname)
{
    return !empty($fname) && ctype_alpha($fname);
}

function validLname($lname)
{
    return !empty($lname) && ctype_alpha($lname);
}

function validAGe($age)
{
    return !empty($age) && ctype_digit($age) &&(($age>=18)&&($age <=118));
}

function validPhone($phone)
{
    return !empty($phone)&& $phone[3] == "-" && $phone[7] == "-" && strlen($phone) == 12;
}

function validEmail($email)
{
    return (!empty($email) && strpos($email, '@') && !strpos($email, " "));

}

function validState($state,$array)
{
    return in_array($state, $array);
}

function validateActivity()
{
    //retrieve the information and store it from variables
    global $f3;
    $array = $f3->get('interests');
    $outdoor = $f3->get('outdoor');
    $indoor = $f3->get('indoor');
    $isValid = true;

    //return true if array is empty
    if(empty($f3->get('interests')))
    {
        $isValid = true;
    }
    else
    {
        //Make sure activities are valid
        foreach ($array as $activity)
        {
            //if the activity is not in the list return false
            if (!in_array($activity , $outdoor) && !in_array($activity , $indoor))
            {
                $isValid = false;
                $f3->set("errors['interests']","Enter only valid activities");
            }
        }
    }
    return $isValid;
}
