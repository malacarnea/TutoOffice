<?php
// src/Form/DataTransformer/ChaptersTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\Chapters;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TranschapterFailedException;

class ChaptersTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (Chapters) to a string (number).
     *
     * @param  Chapters|null $chapter
     * @return string
     */
    public function transform($chapter)
    {
        if (null === $chapter) {
            return '';
        }

        return $chapter->getId();
    }

    /**
     * Transforms a string (number) to an object (chapter).
     *
     * @param  string $idChapter
     * @return Chapter|null
     * @throws TranschapterFailedException if object (chapter) is not found.
     */
    public function reverseTransform($idChapter)
    {
        // no issue number? It's optional, so that's ok
        if (!$idChapter) {
            return;
        }

        $chapter = $this->entityManager
            ->getRepository(Chapters::class)
            // query for the issue with this id
            ->find($idChapter)
        ;

        if (null === $chapter) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TranschapterFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $idChapter
            ));
        }

        return $chapter;
    }
}
