<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\ResetPassType;
use Symfony\Component\Mime\Email;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            "nav_activ" => 'login',
            'footer_activ' => 'no']);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('Déconnecter');
    }

    /**
     * @Route("/mdp-oublier", name="app_forgoten_password")
     */
    public function mdpForget(Request $request, UsersRepository $usersRepo, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator){
        
        $form = $this->createForm(ResetPassType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $donnees = $form->getData();

            $user = $usersRepo->findOneByEmail($donnees['email']);

            if(!$user){
                $this->addFlash('notAdress', 'Cette adresse email n\'a pas de compte associé à MR-GATEAUX.com');
                return $this->redirectToRoute('app_forgoten_password');
            }

            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            }catch(\Exception $e){
                $this->addFlash('warning', 'une erreur est survenue : ' . $e->getMessage());
                return $this->redirectToRoute('login');
            }

            $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new Email())
            ->from('mr.gateaux.pro@gmail.com')
            ->to($user->getEmail())
            ->subject('TEST SUBJECT')
            ->text('Test TEXT')
            ->html('Voici un lien pour modifier votre mot de passe : </br><a href="'.$url.'">Créer un nouveau mot de passe</a>')
            ;

        $mailer->send($message);

        $this->addFlash('newEmail' , 'Un email de réinisialisation de mot de passe vous a été envoyé');
        return $this->redirectToRoute('login');
        }

        return $this->render('security/mdpForget.html.twig', ['emailForm' => $form->createView()]);

    }

    /**
     * @Route("/reset-pass/{token}", name="app_reset_password")
     */
    public function resetPassword($token, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['reset_token' => $token]);

        if(!$user){
            $this->addFlash('token', 'token inconu');
            return $this->redirectToRoute('login');
        }

        if($request->isMethod('POST')){
            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Mot de passe modifié avec succés');
            return $this->redirectToRoute('login');
        }else{
            return $this->render('security/resetPass.html.twig',[
                'token' => $token
            ]);
        }
    }
}
