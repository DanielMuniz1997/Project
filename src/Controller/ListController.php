<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Company;
use App\Entity\CompanyCategory;
use App\Form\CompanyType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ListController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list", name="list")
     */
    public function index(Request $request)
    {
        $data = $request->request->all();
        $error = null;
        $companies = [];

        if (isset($data['form']['search'])){

            $search = $data['form']['search'];

            # Search
            $query = $this->entityManager->getRepository(Company::class)->createQueryBuilder('o')
            ->select('o')
            ->where('o.name LIKE :search')
            ->orWhere('o.address LIKE :search')
            ->orWhere('o.city LIKE :search')
            ->orWhere('o.phone LIKE :search')
            ->orWhere('o.zip_code LIKE :search')
            ->setParameter('search', "%{$search}%")
            ->getQuery();
    
            $companies = $query->getResult();

            if(!$companies)
                $error = "Nenhuma empresa encontrada";
        }

        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('list'))
        ->setMethod('POST')
        ->add('search', TextType::class)
        ->getForm();

        return $this->render('list/index.html.twig', [
            'form' => $form->createView(),
            'companies' => $companies, 
            'error' => $error
        ]);
    }
}