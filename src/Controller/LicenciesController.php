<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;


class LicenciesController extends AbstractController
{
    #[Route('/licencies/{id?}', name: 'app_licencies')]
    public function index(Connection $connection, Request $request): Response
    {

        $id = $request->query->get('id');

        $categories = $connection->fetchAllAssociative('SELECT * FROM categories');

        $sql = '
            SELECT * FROM licencies ORDER BY licencie_id DESC
        ';
        $licencies = $connection->fetchAllAssociative($sql);

   

        if($id != null){
            $sql = '
                SELECT * FROM licencies
                WHERE categorie_id = :id
                ORDER BY id DESC
            ';


            $resultSet = $connection->executeQuery($sql, ['id' => $id]);

            $licencies = $resultSet->fetchAllAssociative();

        }

        return $this->render('licencies/index.html.twig', [
            'licencies' => $licencies,
            'categories' => $categories,

        ]);
    }
}
