<?php

declare(strict_types=1);

namespace Modules\Dashboard;

use App\Auth\Auth;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class Login
{
    protected Twig $twig;
    protected Auth $auth;

    public function __construct(protected ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig = $container->get(Twig::class);
        $this->auth = $container->get(Auth::class);
    }

    public function __invoke(Request $request, Response $response) :Response
    {

        $email = $request->getParsedBody()['email'];
        $password = $request->getParsedBody()['password'];

        #validate form
        if (empty($email) || empty($password)) 
            return $this->twig->render($response, 'index.twig', [
                'message' => "I campi email e password sono obbligatori!"
            ]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return $this->twig->render($response, 'index.twig', [
                'message' => "L'email inserita non è valida"
            ]);

        # attempt the login
        $auth = $this->auth->attempt($email, $password);
        
        $session = array();

        if(!$auth)
            return $this->twig->render($response, 'index.twig', [
                'message' => "L'email o la password sono errati"
            ]);
        else {
            $session = $this->auth->get_session();
        }

        return $this->twig->render($response, 'dashboard.twig', [
            'name' => $session->get('name')
        ]);
    }

}