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