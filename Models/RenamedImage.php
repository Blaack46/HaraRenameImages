<?php
//In der Klasse werden überwiedend Annotationen zur Konfiguration verwendet
//Namens Definition
namespace HaraRenameImages\Models;

//Nutzen folgende Klassen
use Doctrine\ORM\Mapping as ORM;
use Shopware\Components\Model\ModelEntity;
use Shopware\Models\Article\Image;

/**
 * @ORM\Entity()
 * @ORM\Table(name="hara_renamed_images")
 */
class RenamedImage extends ModelEntity
{
    /**
     * @var int
     * 
     * @ORM\Column(name="id", type"integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Shopware\Models\Article\Image")
     * @ORM\JoinColumn(name="article_img_id", referencedColumnName="id", unique=true)
     */
    protected $articleImage;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Image $articleImage
     */
    public function getArticleImage()
    {
        return $this->articleImage;
    }

    /**
     * @param Image $articleImage
     * 
     * @return RenamedImage
     */
    public function setArticleImage($articleImage)
    {
        $this->articleImage = $articleImage;

        return $this;
    }
}
