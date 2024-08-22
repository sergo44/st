<?php

namespace St\Sights;

use PDO;
use St\Db;
use St\Fs;

class PurgeSightImage
{
    /**
     * Изображение, которое необходимо удалить
     * @var SightImage
     */
    protected SightImage $image;
    /**
     * Объект PDO
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * Конструктор класса
     * @param SightImage $image
     * @param PDO|null $dbh
     */
    public function __construct(SightImage $image, ?PDO $dbh = null)
    {
        $this->image = $image;
        $this->dbh = $dbh ?? Db::getWritePDOInstance();
    }

    public function purge(): self
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"DELETE FROM sights_images where sight_image_id = :sight_image_id");
        $sth->execute(array(
            ":sight_image_id" => $this->image->getSightImageId()
        ));

        // @todo Не всегда удаляет
        Fs::purge_thumbs($this->image->getDirectory(), $this->image->getFilename());

        $this->image->setSightImageId(null);

        return $this;
    }
}