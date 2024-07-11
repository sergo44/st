alter table catalog_objects
    add status enum ('Wait', 'Approved', 'Decline') null comment 'Статус отзыва в соответствии с CatalogObjectsStatusesEnum',
    add processed_user_id int unsigned null comment 'Пользователь, который выполнил проверку комментария и принял решение о принятии/отклонении комментария'
;

update catalog_objects set status = 'Approved' where 1;
update reviews set status = 'Approved' where 1;

alter table catalog_objects drop if exists publish_state;