<?php

namespace App\Controller\Admin;

use App\Entity\FitnessRoom;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FitnessRoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FitnessRoom::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
