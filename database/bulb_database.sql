drop table if exists `energy_saving_bulb`;
drop table if exists `non_energy_saving_bulb`;
drop table if exists `bulb_relationship`;
drop table if exists `user`;
drop table if exists `supplier`;
drop table if exists `supplier_admin`;
drop table if exists `supplier_rating`;
drop table if exists `order`;
drop table if exists `order_supplier`;
drop table if exists `order_item`;

create table `energy_saving_bulb` (
    `id` int(10) not null primary key auto_increment,
    `short_name` varchar(255) not null,
    `full_name` varchar(255) null,
    `wattage` varchar(255) null,
    `voltage` varchar(255) null,
    `fitting_cap` varchar(255) null,
    `finish` varchar(255) null,
    `length_mm` int(10) null,
    `diameter` int(10) null,
    `rated_life_hrs` int(10) null,
    `energy_rating` varchar(255) null,
    `lumen_out` int(10) null,
    `to_be_banned` int(1) null,
    `colour_temp` varchar(255) null,
    `dimmable` int(1) null,
    `typical_price` varchar(255) null,
    `beam_angle_degrees` int(10) null,
    `intensity` varchar(255) null,
    `no_leds` int(10) null
);

create table `non_energy_saving_bulb` (
    `id` int(10) not null primary key auto_increment,
    `short_name` varchar(255) not null,
    `full_name` varchar(255) null,
    `wattage` varchar(255) null,
    `voltage` varchar(255) null,
    `fitting_cap` varchar(255) null,
    `finish` varchar(255) null,
    `length_mm` int(10) null,
    `diameter` int(10) null,
    `rated_life_hrs` int(10) null,
    `energy_rating` varchar(255) null,
    `lumen_out` int(10) null,
    `to_be_banned` int(1) null,
    `colour_temp` varchar(255) null,
    `dimmable` int(1) null,
    `typical_price` varchar(255) null,
    `beam_angle_degrees` int(10) null,
    `intensity` varchar(255) null,
    `no_leds` int(10) null
);

create table `bulb_relationship` (
    `energy_saving_bulb_id` int(10) not null,
    `non_energy_saving_bulb_id` int(10) not null
);

create table `user` (
    `id` int(10) not null primary key auto_increment,
    `forename` varchar(255) null,
    `surname` varchar(255) null,
    `email_address` varchar(255) not null,
    `password_hash` varchar(255) not null,
    `admin` int(1) null default '0'
);

create table `supplier` (
    `id` int(10) not null primary key auto_increment,
    `name` varchar(255) not null,
    `description` varchar(512) null,
    `email_address` varchar(255) not null
);

create table `supplier_admin` (
    `supplier_id` int(10) not null,
    `user_id` int(10) not null
);

create table `supplier_rating` (
    `supplier_id` int(10) not null,
    `user_id` int(10) not null,
    `rating` int(10) not null
);

# This should maybe have datetimes on all entries. But then maybe all tables should?
create table `order` (
    `id` int(10) not null primary key auto_increment,
    `user_id` int(10) not null
);

create table `order_supplier` (
    `order_id` int(10) not null,
    `supplier_id` int(10) not null
);

create table `order_item` (
    `order_id` int(10) not null,
    `energy_saving_bulb_id` int(10) not null
);
