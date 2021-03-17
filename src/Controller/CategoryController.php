<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;


class CategoryController extends AbstractController
{
    private $passwordEncoder;
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/new_category", name="new_category")
     */
    public function index(Request $request)
    {
        $errors = [];
        $success = "";

        $data = $request->request->all();

        $category = new Category();

        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($data){

            if ($form->isSubmitted() && $form->isValid()) {

                // Save
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();

                return $this->redirectToRoute('new_category');
            }
        }

        return $this->render('category/index.html.twig', [
            'form' => $form->createView(), 'errors' => $errors, 'categories' => $categories
        ]);
    }
}