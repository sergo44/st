<?php

namespace St\Catalog;

use PDO;
use St\CatalogObject;
use St\Db;
use St\IWriteDb;

class AddObject implements IWriteDb
{
    /**
     * Объект, который необходимо добавить
     * @var CatalogObject
     */
    protected CatalogObject $catalog_object;
    /**
     * Объект PDO который необходимо использовать
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор добавления объекта
     * @param CatalogObject $catalog_object
     * @param PDO|null $dbh
     */
    public function __construct(CatalogObject $catalog_object, ?PDO $dbh = null)
    {
        $this->catalog_object = $catalog_object;
        $this->dbh = $dbh ?? Db::getWritePDOInstance();
    }

    /**
     * Модель добавления объекта
     * @return $this
     */
    public function add(): AddObject
    {


        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            insert into catalog_objects
            (
                object_id,
                object_type,
                user_id,
                posted_datetime,
                last_modified_datetime,
                name,
                country_id,
                region_id,
                city_id,
                address_lines,
                description,
                lat,
                lon,
                include_foods,
                contact_phone,
                contact_email,
                web_site_url,
                start_price,
                status
            ) 
            values
            (
                :object_id,
                :object_type,
                :user_id,
                :posted_datetime,
                :last_modified_datetime,
                :name,
                :country_id,
                :region_id,
                :city_id,
                :address_lines,
                :description,
                :lat,
                :lon,
                :include_foods,
                :contact_phone,
                :contact_email,
                :web_site_url,
                :start_price,
                :status
            )   
        ");

        $sth->execute(array(
            ":object_id" => null,
            ":object_type" => $this->catalog_object->getObjectType(),
            ":user_id" => $this->catalog_object->getUserId(),
            ":posted_datetime" => $this->catalog_object->getPostedDatetime(),
            ":last_modified_datetime" => $this->catalog_object->getLastModifiedDatetime(),
            ":name" => $this->catalog_object->getName(),
            ":country_id" => $this->catalog_object->getCountryId(),
            ":region_id" => $this->catalog_object->getRegionId(),
            ":city_id" => $this->catalog_object->getCityId(),
            ":address_lines" => $this->catalog_object->getAddressLines(),
            ":description" => $this->catalog_object->getDescription(),
            ":lat" => $this->catalog_object->getLat(),
            ":lon" => $this->catalog_object->getLon(),
            ":include_foods" => $this->catalog_object->getIncludeFoods(),
            ":start_price" => $this->catalog_object->getStartPrice(),
            ":contact_phone" => $this->catalog_object->getContactPhone(),
            ":contact_email" => $this->catalog_object->getContactEmail(),
            ":web_site_url" => $this->catalog_object->getWebSiteUrl(),
            ":status" => $this->catalog_object->getStatus()
        ));

        $this->catalog_object->setObjectId($this->dbh->lastInsertId());

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
    public function addImage(string $directory, string $filename, int $x1, int $y1, int $x2, int $y2, int $ratio): AddObject
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            insert into catalog_objects_images
            (
                image_id, 
                object_id, 
                `primary`, 
                directory, 
                filename,
                x1,
                y1,
                x2,
                y2,
                ratio
            )
            values 
            (
                :image_id, 
                :object_id, 
                :primary, 
                :directory, 
                :filename,
                :x1,
                :y1,
                :x2,
                :y2,
                :ratio
            )
        ");


        $sth->execute(array(
            ":image_id" => null,
            ":object_id" => $this->catalog_object->getObjectId(),
            ":primary" => 0,
            ":directory" => $directory,
            ":filename" => $filename,
            ":x1" => $x1,
            ":y1" => $y1,
            ":x2" => $x2,
            ":y2" => $y2,
            "ratio" => $ratio
        ));

        return $this;
    }
}