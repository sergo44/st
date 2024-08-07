<?php

namespace St\Sights;

use PDO;
use St\Db;
use St\IWriteDb;

class SightStore implements IWriteDb
{
    /**
     * Объект для сохранения
     * @var Sight
     */
    protected Sight $sight;
    /**
     * Объект PDO
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param Sight $sight
     * @param PDO|null $dbh
     */
    public function __construct(Sight $sight, ?PDO $dbh =  null)
    {
        $this->sight = $sight;
        $this->dbh = $dbh ?? Db::getWritePDOInstance();
    }

    /**
     * Добавление объекта в базу данных
     * @return SightStore
     */
    public function add(): SightStore
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            INSERT INTO sights
            (
             sight_id, 
             user_id,
             country_id,
             region_id,
             city_id, 
             name, 
             created_datetime_utc, 
             lat, 
             lon,
             description,
             operating_mode,
             price, 
             contact_phone,
             contact_email, 
             web_site_url, 
             status
                
            )
            VALUES
            (
            :sight_id, 
            :user_id,
            :country_id,
            :region_id,
            :city_id,
            :name,
            :created_datetime_utc,
            :lat,
            :lon,
            :description,
            :operating_mode,
            :price,
            :contact_phone,
            :contact_email,
            :web_site_url,
            :status
            )
        ");

        $sth->execute(array(
            ":sight_id" => null,
            ":user_id" => $this->sight->getUserId(),
            ":country_id" => $this->sight->getCountryId(),
            ":region_id" => $this->sight->getRegionId(),
            ":city_id" => $this->sight->getCityId(),
            ":name" => $this->sight->getName(),
            ":created_datetime_utc" => $this->sight->getCreatedDatetimeUtc(),
            ":lat" => $this->sight->getLat(),
            ":lon" => $this->sight->getLon(),
            ":description" => $this->sight->getDescription(),
            ":operating_mode" => $this->sight->getOperatingMode(),
            ":price" => $this->sight->getPrice(),
            ":contact_phone" => $this->sight->getContactPhone(),
            ":contact_email" => $this->sight->getContactEmail(),
            ":web_site_url" => $this->sight->getWebSiteUrl(),
            ":status" => $this->sight->getStatus()
        ));

        $this->sight->setSightId( (int)$this->dbh->lastInsertId() );

        return $this;
    }

    public function addImage( SightImage $image): SightStore
    {

        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            INSERT INTO sights_images
            (
                sight_id,
                main,
                directory, 
                filename, 
                x1,
                y1,
                x2,
                y2,
                ratio
            )
            VALUES 
            (
                :sight_id,
                :main,
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
            ":sight_id" => $image->getSightId(),
            ":main" => $image->getMain(),
            ":directory" => $image->getDirectory(),
            ":filename" => $image->getFilename(),
            ":x1" => $image->getX1(),
            ":y1" => $image->getY1(),
            ":x2" => $image->getX2(),
            ":y2" => $image->getY2(),
            ":ratio" => $image->getRatio()
        ));

        $image->setSightImageId($this->dbh->lastInsertId());

        return $this;
    }
}