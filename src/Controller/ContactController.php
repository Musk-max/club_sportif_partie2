<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    #[Route('/contact/{id?}', name: 'app_contact')]
    public function index(Connection $connection, Request $request): Response
    {
        $id = $request->query->get('id');

        $categories = $connection->fetchAllAssociative('SELECT * FROM categories');$sql = '
        SELECT * FROM contacts ORDER BY contact_id DESC
    ';
      $contacts = $connection->fetchAllAssociative($sql);
      if($id != null){
        $sql = '
            SELECT * FROM contacts
            WHERE contact_id = :id
            ORDER BY id DESC
        ';


        $resultSet = $connection->executeQuery($sql, ['id' => $id]);

        $contacts = $resultSet->fetchAllAssociative();

    }

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
            'categories' => $categories,
        ]);
    }
}
