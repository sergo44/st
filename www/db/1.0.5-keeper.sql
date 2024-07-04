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