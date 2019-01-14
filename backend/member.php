<?php

class Member
{
    //Private members
    private $name;
    private $email;
    private $school;

    //constructor
    public function __construct($pName, $pEmail, $pSchool)
    {
        $this->name = $pName;
        $this->email = $pEmail;
        $this->school = $pSchool;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSchool()
    {
        return $this->school;
    }
} //Member
