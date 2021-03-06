<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\UserBundle\Model\UserInterface;
use App\Controller\UserSpecial;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 *     collectionOperations={
 *     "get"={"method"="GET", "access_control"="is_granted('ROLE_ADMIN')"},
 *     "post"={"method"="POST", "access_control"="is_granted('ROLE_ADMIN') or object == user"},
 *     "currentUserSession"={
 *          "method"="POST",
 *          "_format"="json",
 *          "name"="get_current_user_session",
 *          "path"="/current/user",
 *          "controller"=UserSpecial::class
 *     }
 *
 * },
 *     itemOperations={
 *     "get"={"method"="GET", "access_control"="is_granted('ROLE_ADMIN') or object == user"},
 *     "currentUser"={
 *          "method"="get",
 *          "_format"="json",
 *          "name"="current_user",
 *          "path"="/user/{id}/current",
 *          "controller"=UserSpecial::class,
 *          "access_control"="is_granted('ROLE_ADMIN') or object == user"
 *     },
 *     "put"={"method"="PUT", "access_control"="is_granted('ROLE_ADMIN') or object == user"},
 *     "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_ADMIN')"},
 * },
 *     attributes={
 *     "normalization_context"={"groups"={"user", "user-read"}},
 *     "denormalization_context"={"groups"={"user", "user-write"}}
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Groups({"user"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user"})
     */
    protected $fullname;

    /**
     * @Groups({"user-write"})
     */
    protected $plainPassword;

    /**
     * @Groups({"user"})
     */
    protected $username;

    public function __construct()
    {
        parent::__construct();
        $this->roles = array('ROLE_USER');
    }

    public function setFullname(?string $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function isUser(?UserInterface $user = null): bool
    {
        return $user instanceof self && $user->id === $this->id;
    }
}
