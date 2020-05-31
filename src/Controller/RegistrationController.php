<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="inscription")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,  MailerInterface $mailer): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setActivationToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $valeurToken = $this->renderView('emails/activation.html.twig', ['token' => $user->getActivationToken()]);

            $message = (new Email())
                ->from('mr.gateaux.pro@gmail.com')
                ->to($user->getEmail())
                ->subject('Activation du compte')
                ->html($valeurToken)
            ;

            $mailer->send($message);

            $this->addFlash('compteAActiv', 'Vous avez reçu un email pour activer votre compte');
            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            "nav_activ" => 'inscription'
            ]);
    }



    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UsersRepository $usersRepo){
        $user = $usersRepo->findOneBy(['activation_token' => $token]);

        if(!$user){
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('compteActiv', 'Votre compte est maintenent activé');

        return $this->redirectToRoute('login');
    }
}
