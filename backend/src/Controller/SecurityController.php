<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use App\Helper\ResponseHandler;
use App\Repository\UserRepository;
use App\Repository\ProfileRepository;
use Domain\UseCase\User\RegisterUser;
use Domain\Validator\Entity\UserValidator;
use Domain\Request\User\RegisterUserRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error) {
            $this->addFlash('error_login', 'Identifiants incorrects');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/register', methods:['POST', 'GET'], name: 'app_register')]
    public function register(Request $request, UserRepository $userRepository, ProfileRepository $profileRepository): Response
    {
        if ($request->isMethod('GET')) {
            return $this->render('security/register.html.twig');
        }

        $registerUser = new RegisterUser(new UserValidator(), $userRepository, $profileRepository);

        $request = new RegisterUserRequest(
            username: $request->request->get('username'),
            email: $request->request->get('email'),
            password: $request->request->get('password'),
            role: ['ROLE_USER']
        );

        $response = ResponseHandler::handle($registerUser->execute($request));
        if ($response->getStatusCode() === 200) {
            $this->addFlash('success', 'Votre compte a bien été créé, vous pouvez vous connecter');
            return $this->redirectToRoute('admin_users_login');
        }
 
        foreach ($response->getErrors() as $input => $output) {
            $this->addFlash('error_' . $input, $output);
        }
        return $this->redirectToRoute('app_register');
    }
}