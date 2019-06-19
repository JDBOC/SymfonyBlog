<?php
namespace App\Security;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;


class ArticleVoter extends Voter {

    private $security;

    function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if ($attribute !== 'edit') {
            return false;
        }

        if (!$subject instanceof Article) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /* @var Article $article */
        $article = $subject;
        switch ($attribute) {
            case 'edit':
                if ($this->security->isGranted('ROLE_ADMIN') ||
                    ($this->security->isGranted('ROLE_AUTHOR') &&
                        $user == $article->getAuthor())) {
                    return true;
                }
                return false;
        }

        throw new \LogicException('This code should not be reached!');


    }
}