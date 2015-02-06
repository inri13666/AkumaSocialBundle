<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/6/15
 * Time  : 7:54 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Model;


class SocialUserModel
{
    protected $id;
    protected $email;
    protected $firstName;
    protected $lastName;
    protected $social;

    public function getId()
    {
        return $this->id;
    }

    public function setId($_)
    {
        $this->id = $_;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($_)
    {
        $this->email = $_;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($_)
    {
        $this->firstName = $_;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($_)
    {
        $this->lastName = $_;
        return $this;
    }

    public function getSocial()
    {
        return $this->social;
    }

    public function setSocial($_)
    {
        $this->social = $_;
        return $this;
    }
}