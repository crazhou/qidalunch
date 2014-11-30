-- 插入用户数据
insert into user(user_name, user_spell, user_sex, user_role, user_praise,create_date,update_date)
values 
('周华辉','zhh', 0, 0, 0, current_timestamp, current_timestamp),
('饶瑟','rs', 0, 0, 0, current_timestamp, current_timestamp),
('贺世英','hsy', 0, 0, 0, current_timestamp, current_timestamp),
('李威','lw', 0, 0, 0, current_timestamp, current_timestamp),
('汪航洋','why', 0, 0, 0, current_timestamp, current_timestamp),
('张进','zj', 0, 0, 0, current_timestamp, current_timestamp),
('张波','zb', 0, 0, 0, current_timestamp, current_timestamp),
('罗蓓','lb', 0, 0, 0, current_timestamp, current_timestamp);

TRUNCATE dish_menu;
INSERT INTO dish_menu(menu_name, menu_telephone, created_at, updated_at)
VALUES ('A菜单(饭饭之辈)', '61619026', CURRENT_TIMESTAMP , CURRENT_TIMESTAMP ),
('B菜单(赣湘木桶饭)', '86105551 26037722', CURRENT_TIMESTAMP , CURRENT_TIMESTAMP ),
('C菜单(鲜粉人家)', '86105550 26037712', CURRENT_TIMESTAMP , CURRENT_TIMESTAMP );