<?php

declare(strict_types=1);

namespace App\Auth;

use Slim\App;
use App\Model\User;
use Odan\Session\PhpSession;
use Psr\Container\ContainerInterface;

class Auth
{
    protected User $user;
    protected PhpSession $session;

    public function __construct(protected ContainerInterface $container)
    {
        $this->container = $container;
        $this->user = $container->get(User::class);
        $this->session = $container->get(PhpSession::class);
    }

    /**
     * Make a attempt di login
     */
    public function attempt(String $email, String $password) : bool
    {

        if (!$this->user->userExist($email))
            return false;

        $user = $this->user->getUser($email, $password);

        if (password_verify($password, $user['password'])) {
            
            $this->session->start();

            $this->session->replace([
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ]);
             
            return true;
        } else 
            return false;
    }

    /**
     * Make the logout of the user
     */

     public function signOut() :void
     {
        $this->session->destroy();
     }

     // check if the user is already login
     public function check() :bool
     {
        if(!$this->session->getName() === 'user')
            return false;

        return true;
     }

     //return the setted session
     public function get_session() : PhpSession
     {      
            return $this->session;
     }
}