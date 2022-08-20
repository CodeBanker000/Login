<?php

declare(strict_types=1);

namespace App\Model;

use Medoo\Medoo;

class User 
{

    public function __construct(protected Medoo $db)
    {
        $this->db = $db;
    }

    // read all users
    public function readAllUsers () : array
    {
        $medoo = $this->db;

        return $medoo->select('users', '*');
    }

    // read all users
    public function getUser (String $email) : array
    {
        $medoo = $this->db;

        return $medoo->get('users', '*', [
            'email' => $email
        ]);
    }

    // Check if user exist
    public function userExist(String $email) : bool
    {
        $medoo = $this->db;

        return $medoo->has('users', [
            'email' => $email
        ]);
    }

}