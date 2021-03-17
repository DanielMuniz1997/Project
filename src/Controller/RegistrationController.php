<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;


class RegistrationController extends AbstractController
{
    private $passwordEncoder;
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request)
    {
        $errors = [];
        $data = $request->request->all();

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($data){

            if ($data['user']['password']['first'] != $data['user']['password']['second']){
                $errors[] = "password do not match";
            }

            else if ($form->isSubmitted() && $form->isValid()) {
                // Encode the new users password

                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

                if ($this->entityManager->getRepository(User::class)->findOneBy(['email' => $data['user']['email']]))
                    $errors[] = "Email já cadastrado";
                
                else {
                    // Set their role
                    $user->setRoles(['ROLE_USER']);

                    // Save
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();

                    return $this->redirectToRoute('app_login');
                } 

            }
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(), 'errors' => $errors
        ]);
    }
}