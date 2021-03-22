<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CRUDUserController extends CRUDController
{
    public function disableAction($id, EntityManagerInterface $entityManager)
    {
        /** @var User $user */
        $user = $this->admin->getSubject();

        if (!$user || $user->isDisabled()) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $user->setDisabled(true);

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->redirectToList();
    }
}