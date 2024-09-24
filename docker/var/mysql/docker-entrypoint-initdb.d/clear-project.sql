/*
create database st_db default charset utf8;
grant all privileges on st_db.* to 'st_user'@'%' identified by 'st_pass';
flush privileges ;
*/

drop table if exists users;
create table users
(
    user_id int unsigned not null primary key auto_increment comment 'Идентификатор пользователя',
    name tinytext comment 'Имя пользователя',
    login tinytext comment 'Логин пользователя',
    timezone tinytext comment 'Часовой пояс пользователя (например Asis/Irkutsk)',
    email tinytext comment 'Адрес электронной почты',
    phone tinytext comment 'Номер телефона пользователя',
    password_hash tinytext not null comment 'Хеш пароля',
    user_role enum('Guest', 'Editor', 'Administrator', 'Owner') not null comment 'Роль пользователя',
    index (user_id),
    unique index idx_login(`login`)
) engine InnoDB comment 'База данных содержит таблицу пользователей'
;

drop table if exists countries;
create table countries
(
    country_id int unsigned not null primary key auto_increment comment 'Идентификатор страны',
    code char(2) not null comment 'А2 rод страны (в соответствии с ISO 3166-1)',
    name tinytext not null comment 'Название страны'
) engine InnoDB comment 'Таблица стран для адреса объекта'
;

insert into countries values (null, 'RU', 'Россия');

drop table if exists regions;
create table regions
(
    region_id int unsigned not null primary key auto_increment comment 'Идентификатор региона',
    country_id int unsigned not null comment 'Владелец страны региона',
    name tinytext not null comment 'Наименование региона',
    index(country_id)
) engine InnoDB comment 'Таблица содержит регионы страны'
;

insert into regions values (null, 1, 'Иркутская область');
insert into regions values (null, 1, 'Республика Бурятия');

drop table if exists cities;
create table cities
(
    city_id int unsigned not null primary key auto_increment comment 'Идентификатор населенного пункта',
    country_id int unsigned not null comment 'Идентификатор страны, к которой принадлежит город',
    region_id int unsigned not null comment 'Идентификатор региона, к которому принадлежит город',
    name tinytext not null comment 'Наименование города'
) engine InnoDB comment 'Таблица содержит наименование городов (населенных пунктов)'
;

insert into cities values (null, 1, 1, 'г. Иркутск');
insert into cities values (null, 1, 1, 'Листвянка');
insert into cities values (null, 1, 1, 'остров Ольхон');
insert into cities values (null, 1, 2, 'Максимиха');

drop table if exists objects;
drop table if exists catalog_objects;
create table catalog_objects
(
    object_id int unsigned not null primary key auto_increment comment 'Идентификатор объекта',
    object_type enum('Hotel', 'Guest_House', 'Hostel', 'Apartment', 'Camping') comment 'Тип объекта (отель, гостевой дом, хостел, апартаменты, кемпинг)',
    user_id int unsigned not null comment 'Идентификатор пользователя, который кому принадлежит объект',
    name tinytext not null comment 'Наименование объекта',
    country_id int unsigned not null comment 'Идентификатор страны',
    region_id int unsigned not null comment 'Идентификатор региона',
    city_id int unsigned not null comment 'Идентификатор города',
    address_lines tinytext not null comment 'Адрес объекта (строкой)',
    description text not null comment 'Описание объекта',
    lat decimal(11, 8) null comment 'Широта объекта',
    lon decimal(11, 8) null comment 'Долгота объекта',
    include_food text not null comment 'Включение питания',
    contact_phone tinytext not null comment 'Контактный номер телефона',
    contact_email tinytext not null comment 'Контактный адрес электронный почты',
    web_site_url tinytext null comment 'Адрес веб сайта',
    index user_id_idx(`user_id`),
    index country_id_idx(`country_id`),
    index city_id_idx(`city_id`)
) engine InnoDB comment 'Таблица объектов каталога'
;

alter table countries add index countries_name_idx(name(16));
alter table regions add index country_named_idx(country_id, name(16));

create table catalog_objects_images
(
    `image_id` int unsigned not null primary key auto_increment comment 'Идентификатор изображения',
    `object_id` int unsigned not null comment 'Идентификатор объекта',
    `primary` smallint not null default '0' comment 'Признак, что фотография является основной',
    `directory` tinytext not null comment 'Директория, где храниться оригинал фотографии',
    `filename` tinytext not null comment 'Имя файла',
    `x1` int unsigned not null comment 'Координата X1',
    `y1` int unsigned not null comment 'Координата Y1',
    `x2` int unsigned not null comment 'Координата X2',
    `y2` int unsigned not null comment 'Координата Y2',
    `ratio` tinytext not null comment 'Отношение сторон'
) engine InnoDB comment 'Таблица хранит фотографии'
;

alter table catalog_objects change include_food include_foods text not null comment 'Включение питания';
alter table catalog_objects add start_price int not null comment 'Цена размещения (от)';
update catalog_objects set start_price = '2000' where 1;

drop table if exists catalog_objects_hotel_rooms;
create table catalog_objects_hotel_rooms
(
    hotel_room_id int unsigned not null primary key auto_increment comment 'Идентификатор комнаты (номера)',
    object_id int unsigned not null comment 'Идентификатор объекта, к которому принадлежит комната (номер)',
    image tinytext null comment 'Изображение, которое добавлено к номеру',
    name tinytext not null comment 'Наименование комнаты (номера)',
    description text not null comment 'Описание комнаты (номера)',
    price decimal(10,2) comment 'Цена комнаты (номера)',
    index idx_object_id(`object_id`)
) engine InnoDB comment 'Таблица содержит информацию о комнатах (номерах) отелей';

drop table if exists reviews;

create table reviews
(
    review_id int unsigned not null primary key auto_increment comment 'Идентификатор отзыва',
    user_id int unsigned not null comment 'Идентификатор пользователя, который создал отзыв',
    object_id int unsigned not null comment 'Идентификатор объекта каталога, к которому принадлежит отзыв',
    publish_datetime_utc datetime not null comment 'Дата и время создания отзыва в формате UTC',
    rest_period tinytext not null comment 'Период отдыха',
    mark smallint unsigned not null comment 'Оценка, которую поставил пользователь (от 1 до 5)',
    review_text text not null comment 'Текст отзыва',
    status enum('Wait', 'Approved', 'Decline') comment 'Статус отзыва в соответствии с ReviewStatusesEnum',
    processed_user_id int unsigned null default null comment 'Пользователь, который выполнил проверку комментария и принял решение о принятии/отклонении комментария',
    index (`user_id`),
    index(`object_id`),
    index(`status`),
    index(`processed_user_id`)
)
    engine InnoDB
    charset utf8mb4
    comment 'Таблица содержит отзыв на объекты каталога'
;

drop table if exists reviews_images;

create table reviews_image
(
    review_image_id int unsigned not null primary key auto_increment comment 'Идентификатор изображения',
    review_id int unsigned not null comment 'Идентификатор отзыва',
    directory tinytext not null comment 'Директория, относительно public/ где располагается изображение',
    filename tinytext not null comment 'Название файла, под котором в директории сохранено изображения'
)
    engine InnoDB
    charset utf8mb4
    comment 'Таблица содержит загруженные изображения пользователей к отзывам'
;

alter table catalog_objects
    add status enum ('Wait', 'Approved', 'Decline') null comment 'Статус отзыва в соответствии с CatalogObjectsStatusesEnum',
    add processed_user_id int unsigned null comment 'Пользователь, который выполнил проверку комментария и принял решение о принятии/отклонении комментария'
;

update catalog_objects set status = 'Approved' where 1;
update reviews set status = 'Approved' where 1;

alter table catalog_objects drop if exists publish_state;

alter table catalog_objects drop if exists posted_datetime;
alter table catalog_objects drop if exists last_modified_datetime;


alter table catalog_objects
    add posted_datetime datetime not null comment 'Дата публикации (UTC)' after user_id
;

alter table catalog_objects
    add last_modified_datetime datetime not null comment 'Дата последнего редактирования. В случае первичной публикации устанавливать дату публикации' after posted_datetime
;

alter table catalog_objects
    add index idx_status(status, last_modified_datetime)
;

update catalog_objects set posted_datetime = UTC_TIMESTAMP(), last_modified_datetime = UTC_TIMESTAMP() where 1;

update cities set name = 'Горячинск' where city_id = '4';

insert into cities
( city_id, country_id, region_id, name )
values
    (null, 1, 2, 'Аршан')

;

insert into cities
( city_id, country_id, region_id, name )
values
    (null, 1, 2, 'Теплые озера')

;

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


alter table reviews drop if exists  object_type;
alter table reviews
    add object_type enum('Object', 'Sight') not null
        comment 'Тип объекта (object - размещение, sight - достопримечательность)'
        after object_id
;

alter table users add registered_datetime_utc datetime not null comment 'Дата и время регистрации в UTC';
update users set registered_datetime_utc = NOW() where 1;

alter table users add email_confirmed smallint unsigned not null comment 'Признак, что адрес электронной почты подтвержден';
update users set email_confirmed = '0' where 1;

alter table users add email_confirmation_code varchar(10) null default null comment 'Код подтверждения адреса электронной почты';

alter table users add email_confirmation_code_sent smallint unsigned not null comment 'Признак, что на почту отправлено письмо с кодом подтверждения';
update users set email_confirmation_code_sent = '0' where 1;