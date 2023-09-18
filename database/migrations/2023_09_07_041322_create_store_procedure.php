<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $data = 'CREATE PROCEDURE allocation_orders (IN productId INT, IN qty INT)
            BEGIN
                DECLARE done INT DEFAULT FALSE;
                DECLARE orderId INT;
                DECLARE quantity_allocations INT;
                DECLARE quantity_order INT;
                DECLARE quantity_product INT;
                DECLARE status_order INT;
                DECLARE product_id INT;

                /*Xác định các đơn hàng cần phân bổ và sắp xếp chúng theo ngày đặt hàng*/
                DECLARE productCursor CURSOR FOR
                    SELECT id, quantity
                    FROM orders
                    WHERE product_id = productId AND orders.`status` = 1
                    ORDER BY `date_order`;

                /*Khởi tạo trình xử lý ở cuối con trỏ*/
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

                /*Nhận số lượng tồn kho và id sản phẩm*/
                SELECT id, quantity INTO product_id, quantity_product FROM products WHERE id = productId;

                /* Tính tổng số lượng có sẵn + nhập hàng mới*/
                SET quantity_allocations = quantity_product + qty;

                OPEN productCursor;
                /* Lặp qua các đơn hàng đã đặt hàng*/
                read_loop: LOOP
                    /* Lấy thông tin đơn hàng*/
                    FETCH productCursor INTO orderId, quantity_order;

                        IF done OR quantity_allocations = 0 THEN
                            LEAVE read_loop;
                        END IF;

                        IF quantity_allocations >= quantity_order THEN
                            /*Đủ hàng: Cập nhật tình trạng, số lượng*/
                            SET status_order = 2;
                            SET quantity_allocations = quantity_allocations - quantity_order;
                            UPDATE orders SET status = status_order WHERE id = orderId;
                        END IF;

                    END LOOP read_loop;
                    CLOSE productCursor;

                    /*Cập nhật số lượng sản phẩm*/
                    UPDATE products SET quantity = quantity_allocations WHERE id = productId;

                    /*lấy những đơn hàng chưa đủ số lượng hàng để phân bổ*/
                    SELECT id AS insufficient_order_count_id  FROM orders where orders.`status`= 1 AND orders.`product_id` = productId;



            END;
        ';
        DB::unprepared($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS allocation_orders');
    }
};
