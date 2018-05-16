<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Uloc\Bundle\AppBundle\Helpers\Sluggable;

/**
 * @ORM\MappedSuperclass()
 * Class FormEntity.
 */
abstract class FormEntity
{

    /**
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     * @var string
     */
    private $slug;


    /**
     * @ORM\Column(name="is_published", type="boolean", nullable=true)
     * @var bool
     */
    private $isPublished = false;

    /**
     * @ORM\Column(name="date_added", type="datetime", nullable=true)
     * @var null|\DateTime
     */
    private $dateAdded = null;

    /**
     * @ORM\Column(name="created_by", type="integer", nullable=true)
     * @var null|int
     */
    private $createdBy;

    /**
     * @ORM\Column(name="created_by_user", type="string", nullable=true)
     * @var null|string
     */
    private $createdByUser;

    /**
     * @ORM\Column(name="date_modified", type="datetime", nullable=true)
     * @var null|\DateTime
     */
    private $dateModified;

    /**
     * @ORM\Column(name="modified_by", type="integer", nullable=true)
     * var null|int.
     */
    private $modifiedBy;

    /**
     * @ORM\Column(name="modified_by_user", type="string", nullable=true)
     * @var null|string
     */
    private $modifiedByUser;

    /**
     * @ORM\Column(name="checked_out", type="datetime", nullable=true)
     * @var null|\DateTime
     */
    private $checkedOut;

    /**
     * @ORM\Column(name="checked_out_by", type="integer", nullable=true)
     * @var null|int
     */
    private $checkedOutBy;

    /**
     * @ORM\Column(name="checked_out_by_user", type="string", nullable=true)
     * @var null|string
     */
    private $checkedOutByUser;

    /**
     * @ORM\Column(name="ordering", type="smallint", nullable=true)
     * @var null|int
     */
    private $order = 0;

    /**
     * @var array
     */
    protected $changes = [];

    /**
     * @var bool
     */
    protected $new = false;

    /**
     * @var
     */
    public $deletedId;


    /**
     * Clear dates on clone.
     */
    public function __clone()
    {
        $this->dateAdded = null;
        $this->dateModified = null;
        $this->checkedOut = null;
        $this->isPublished = false;
        $this->changes = [];
    }


    /**
     * Set dateAdded.
     *
     * @param \DateTime $dateAdded
     *
     * @return $this
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded.
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set dateModified.
     *
     * @param \DateTime $dateModified
     *
     * @return $this
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified.
     *
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Set checkedOut.
     *
     * @param \DateTime $checkedOut
     *
     * @return $this
     */
    public function setCheckedOut($checkedOut)
    {
        $this->checkedOut = $checkedOut;

        return $this;
    }

    /**
     * Get checkedOut.
     *
     * @return \DateTime
     */
    public function getCheckedOut()
    {
        return $this->checkedOut;
    }

    /**
     * Set createdBy.
     *
     * @param Usuario $createdBy
     *
     * @return $this
     */
    public function setCreatedBy($createdBy = null)
    {
        if ($createdBy != null && !$createdBy instanceof Usuario) {
            $this->createdBy = $createdBy;
        } else {
            $this->createdBy = ($createdBy != null) ? $createdBy->getId() : null;
            if ($createdBy != null) {
                $this->createdByUser = $createdBy->getUsername();
            }
        }

        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set modifiedBy.
     *
     * @param Usuario $modifiedBy
     *
     * @return mixed
     */
    public function setModifiedBy($modifiedBy = null)
    {
        if ($modifiedBy != null && !$modifiedBy instanceof Usuario) {
            $this->modifiedBy = $modifiedBy;
        } else {
            $this->modifiedBy = ($modifiedBy != null) ? $modifiedBy->getId() : null;

            if ($modifiedBy != null) {
                $this->modifiedByUser = $modifiedBy->getUsername();
            }
        }

        return $this;
    }

    /**
     * Get modifiedBy.
     *
     * @return int
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Set checkedOutBy.
     *
     * @param Usuario $checkedOutBy
     *
     * @return mixed
     */
    public function setCheckedOutBy($checkedOutBy = null)
    {
        if ($checkedOutBy != null && !$checkedOutBy instanceof Usuario) {
            $this->checkedOutBy = $checkedOutBy;
        } else {
            $this->checkedOutBy = ($checkedOutBy != null) ? $checkedOutBy->getId() : null;

            if ($checkedOutBy != null) {
                $this->checkedOutByUser = $checkedOutBy->getUsername();
            }
        }

        return $this;
    }

    /**
     * Get checkedOutBy.
     *
     * @return int
     */
    public function getCheckedOutBy()
    {
        return $this->checkedOutBy;
    }

    /**
     * Set isPublished.
     *
     * @param bool $isPublished
     *
     * @return $this
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get isPublished.
     *
     * @return bool
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        if ($this->new) {
            return true;
        }

        $id = $this->getId();

        return (empty($id)) ? true : false;
    }

    /**
     * Set this entity as new in case it has to be saved prior to the events.
     */
    public function setNew()
    {
        $this->new = true;
    }

    /**
     * @return string
     */
    public function getCheckedOutByUser()
    {
        return $this->checkedOutByUser;
    }

    /**
     * @return string
     */
    public function getCreatedByUser()
    {
        return $this->createdByUser;
    }

    /**
     * @return string
     */
    public function getModifiedByUser()
    {
        return $this->modifiedByUser;
    }

    /**
     * @param mixed $createdByUser
     */
    public function setCreatedByUser($createdByUser)
    {
        $this->createdByUser = $createdByUser;
    }

    /**
     * @param mixed $modifiedByUser
     */
    public function setModifiedByUser($modifiedByUser)
    {
        $this->modifiedByUser = $modifiedByUser;
    }

    /**
     * @param mixed $checkedOutByUser
     */
    public function setCheckedOutByUser($checkedOutByUser)
    {
        $this->checkedOutByUser = $checkedOutByUser;
    }

    /**
     * @return int|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int|null $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @param string $slug
     */
    public function setSlugAuto($stringToSlug)
    {
        $this->slug = Sluggable::slugify($stringToSlug);
    }

}
