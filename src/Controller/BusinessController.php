<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query;

use App\Entity\Company;
use App\Entity\Category;
use App\Entity\CompanyCategory;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use App\Form\CompanyType;

class BusinessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/business/{id}", name="business")
     */
    public function show(int $id): Response
    {
        $categories = [];
        $company = $this->entityManager->getRepository(Company::class)->findOneBy(['id' => $id]);

        $query = $this->entityManager->getRepository(CompanyCategory::class)
            ->createQueryBuilder('o')
            ->select('o.id_category')
            ->where('o.id_company = :search')
            ->setParameter('search', "{$id}")
            ->getQuery();
    
        $data = $query->getResult();

        foreach ($data as $category){
            $categories[] = $category['id_category'];
        }

        $query = $this->entityManager->getRepository(Category::class)
            ->createQueryBuilder('o')
            ->Where('o.id IN (:ids)')
            ->setParameter('ids', $categories)
            ->getQuery();

        $categories = $query->getResult();

        return $this->render('business/index.html.twig', [
            'company' => $company,
            'categories' => $categories,
            'controller_name' => 'BusinessController',
        ]);
    }

    /**
     * @Route("/new_company", name="new_company")
     */
    public function store(Request $request)
    {
        $data = $request->request->all();

        if ($data) {

            $company = new Company();
    
            $company->setName($data['company']['name']);
            $company->setPhone($data['company']['phone']);
            $company->setAddress($data['company']['address']);
            $company->setZipcode($data['company']['zip_code']);
            $company->setCity($data['company']['city']);
            $company->setDescription($data['company']['description']);
            $company->setstate($data['company']['state']);
    
            // $member->joinCategory($category);
            $this->entityManager->persist($company);

            $this->entityManager->flush();

            foreach ($data['company']['id'] as $category){

                $companyCategory = new CompanyCategory();

                $companyCategory->setIdCompany($company->getId());
                $companyCategory->setIdCategory($category);

                $this->entityManager->persist($companyCategory);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute('business', array('id' => $company->getId()));

        }

        $company = new Company();

        $form = $this->createForm(CompanyType::class, $company);

        $form->handleRequest($request);

        return $this->render('business/new_company.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
