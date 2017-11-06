<?php
/**
 * Created by PhpStorm.
 * User: triangle
 * Date: 17.10.11
 * Time: 18.39
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;


    /**
     * @ORM\Column(type="string")
     */
    private $phone;

    /**
     * @ORM\Column(type="string")
     */
    private $legal_entity_code;

    /**
     * @ORM\Column(type="string")
     */
    private $company_name;


    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * @param mixed $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }

    /**
     * @return mixed
     */
    public function getLegalEntityCode()
    {
        return $this->legal_entity_code;
    }

    /**
     * @param mixed $legal_entity_code
     */
    public function setLegalEntityCode($legal_entity_code)
    {
        $this->legal_entity_code = $legal_entity_code;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}