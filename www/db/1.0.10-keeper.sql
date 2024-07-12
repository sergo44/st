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