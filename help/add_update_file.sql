ALTER TABLE `erp_enter_using_stock_items`
ADD COLUMN `product_id` int(11) NULL AFTER `id`;

ALTER TABLE `erp_enter_using_stock`
ADD COLUMN `is_return` tinyint(1) NULL AFTER `total_using_cost`;

ALTER TABLE erp_sales
ADD COLUMN shipping_percent decimal(25, 0) NULL AFTER shipping;
