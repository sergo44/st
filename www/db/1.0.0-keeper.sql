create database st_db default charset utf8;
grant all privileges on st_db.* to 'st_user'@'%' identified by 'st_pass';
flush privileges ;

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