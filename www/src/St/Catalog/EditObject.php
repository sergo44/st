<?php

namespace St\Catalog;

use PDO;
use St\CatalogObject;
use St\Db;
use St\IWriteDb;


class EditObject implements IWriteDb
{
    /**
     * Объект каталога
     * @var CatalogObject
     */
    protected CatalogObject $object;
    /**
     * Объект PDO для работы с базой данных
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * @param CatalogObject $object
     * @param PDO|null $dbh
     */
    public function __construct(CatalogObject $object, ?PDO $dbh = null)
    {
        $this->object = $object;
        $this->dbh = $dbh ?? Db::getWritePDOInstance();
    }

    /**
     * Обновление информации об объекте в базе данных
     * @return $this
     */
    public function update(): EditObject
    {

        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            UPDATE catalog_objects
            SET
                object_type = :object_type,
                user_id = :user_id, 
                name = :name,
                country_id = :country_id, 
                region_id = :region_id, 
                city_id = :city_id, 
                address_lines = :address_lines,
                description = :description,
                lat = :lat,
                lon = :lon,
                include_foods = :include_foods,
                contact_phone = :contact_phone, 
                contact_email = :contact_email,
                web_site_url = :web_site_url, 
                start_price = :start_price, 
                status = :status, 
                processed_user_id = :processed_user_id
            WHERE 
                object_id = :object_id
                
        ");

        $sth->execute(array(
            ":object_type" => $this->object->getObjectType(),
            ":user_id" => $this->object->getUserId(),
            ":name" => $this->object->getName(),
            ":country_id" => $this->object->getCountryId(),
            ":region_id" => $this->object->getRegionId(),
            ":city_id" => $this->object->getCityId(),
            ":address_lines" => $this->object->getAddressLines(),
            ":description" => $this->object->getDescription(),
            ":lat" => $this->object->getLat(),
            ":lon" => $this->object->getLon(),
            ":include_foods" => $this->object->getIncludeFoods(),
            ":contact_phone" => $this->object->getContactPhone(),
            ":contact_email" => $this->object->getContactEmail(),
            ":web_site_url" => $this->object->getWebSiteUrl(),
            ":start_price" => $this->object->getStartPrice(),
            ":status" => $this->object->getStatus(),
            ":processed_user_id" => $this->object->getProcessedUserId(),
            ":object_id" => $this->object->getObjectId()
        ));


        return $this;
    }

    /**
     * Добавление изображения
     * @param string $directory
     * @param string $filename
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @param int $ratio
     * @return $this
     */
    public function addImage(string $directory, string $filename, int $x1, int $y1, int $x2, int $y2, int $ratio): EditObject
    {
        (new AddObject($this->object, $this->dbh))
            ->addImage($directory, $filename, $x1, $y1, $x2, $y2, $ratio)
        ;

        return $this;
    }
}