<?php

namespace App\Controller\Admin;

use App\Entity\Progress;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProgressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Progress::class;
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
