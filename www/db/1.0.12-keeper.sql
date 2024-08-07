drop table if exists sights;

create table sights
(
    sight_id int unsigned not null primary key auto_increment comment 'Идентификатор достопримечательности',
    user_id int unsigned not null comment 'Идентификатор пользователя, который создал объект',
    country_id int unsigned not null comment 'Идентификатор страны локации',
    region_id int unsigned not null comment 'Идентификатор региона локации',
    city_id int unsigned not null comment 'Идентификатор города локации (населенного пункта)',
    name tinytext not null comment 'Наименование достопримечательности',
    created_datetime_utc datetime not null comment 'Дата и время создания (в UTC)',
    lat decimal(11,8) not null comment 'Широта объекта',
    lon decimal(11,8) not null comment 'Долгота объекта',
    description text not null comment 'Описание объекта',
    operating_mode text null comment 'Условия и режим работы',
    price text null comment 'Стоимость посещения достопримечательности',
    contact_phone tinytext null comment 'Контактный телефон',
    contact_email tinytext null comment 'Контактный адрес электронной почты',
    web_site_url tinytext null comment 'Адрес веб сайта',
    status enum ('Wait', 'Approved', 'Decline') not null comment 'Статус в соответствии с SightStatusEnum',
    index country_id_idx(country_id),
    index region_id_idx(region_id),
    index city_id_idx(city_id)
)
    default charset utf8mb4
    engine InnoDB
    comment 'Таблица содержит основную информацию по объектам Достопримечательность'
;

drop table if exists sights_images;
create table sights_images
(
    sight_image_id int unsigned not null primary key auto_increment comment 'Идентификатор изображения',
    sight_id int unsigned not null comment 'Идентификатор достопримечательности',
    main int unsigned not null comment 'Признак главного изображения',
    directory tinytext not null comment 'Директория, где находится изображение',
    filename tinytext not null comment 'Название файла изображения',
    x1 int unsigned not null comment 'Координата x1',
    y1 int unsigned not null comment 'Координата y1',
    x2 int unsigned not null comment 'Координата x2',
    y2 int unsigned not null comment 'Координата y2',
    ratio tinytext not null comment 'Соотношение (ratio)'
)
    engine InnoDB
    charset utf8mb4
    comment 'Таблица содержит загруженные изображения для достопримечательностей'
;
