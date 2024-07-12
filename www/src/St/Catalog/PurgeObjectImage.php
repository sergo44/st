<?php

namespace St\Catalog;

use PDO;
use St\Db;
use St\Fs;
use St\Image;
use St\IWriteDb;
use St\Result;

class PurgeObjectImage implements IWriteDb
{
    /**
     * Изображение, которое необходимо удалить
     * @var Image
     */
    protected Image $image;
    /**
     * Объект PDO для работы с базой данных
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * Конструктор объекта
     * @param Image $image
     * @param PDO|null $dbh
     */
    public function __construct(Image $image, ?PDO $dbh = null)
    {
        $this->image = $image;
        $this->dbh = $dbh ?? Db::getWritePDOInstance();
    }

    /**
     * Выполняет чистку данных
     * @param Result $result
     * @return Result
     */
    public function purge(Result $result): Result
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"DELETE FROM catalog_objects_images where image_id = :image_id");
        $sth->execute(array(
            ":image_id" => $this->image->getImageId()
        ));

        Fs::purge_thumbs($this->image->getDirectory(), $this->image->getFilename());

        $this->image->setImageId(null);

        return $result;
    }
}