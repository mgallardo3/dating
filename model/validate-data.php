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