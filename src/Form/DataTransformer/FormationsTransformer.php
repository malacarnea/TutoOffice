<?php
// src/Form/DataTransformer/FormationsTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\Formations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FormationsTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (Formations) to a string (number).
     *
     * @param  Formations|null $formation
     * @return string
     */
    public function transform($formation)
    {
        if (null === $formation) {
            return '';
        }

        return $formation->getId();
    }

    /**
     * Transforms a string (number) to an object (formation).
     *
     * @param  string $idFormation
     * @return Formation|null
     * @throws TransformationFailedException if object (formation) is not found.
     */
    public function reverseTransform($idFormation)
    {
        // no issue number? It's optional, so that's ok
        if (!$idFormation) {
            return;
        }

        $formation = $this->entityManager
            ->getRepository(Formations::class)
            // query for the issue with this id
            ->find($idFormation)
        ;

        if (null === $formation) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $idFormation
            ));
        }

        return $formation;
    }
}
