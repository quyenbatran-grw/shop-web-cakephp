<div class="content mt-3">
    <?php
    use App\Model\Table\OrdersTable;

    if(!empty($order)) {
        if($order['payment_status'] == OrdersTable::PREPARING && $order['payment_type'] == OrdersTable::BANKING) {
            $message = __('Làm ơn quét mã QR dưới đây để hoàn thành thanh toán với nội dung sau <br><span class="text-danger">ĐH{0} {1}</span>.', $order['order_number'], $order['order_name']);
        } else if($order['payment_status'] == OrdersTable::PREPARING && $order['payment_type'] != OrdersTable::BANKING) {
            $message = __('Bạn cũng có thể thực hiện thanh toán bằng cách quét mã QR dưới đây với nội dung sau <br><span class="text-danger">ĐH{0} {1}</span>.', $order['order_number'], $order['order_name']);
        }
    ?>
    <div class="text-center"><?=__(MSG_0004, $message)?></div>
    <img src="/img/noImage.svg" class="d-block w-100 fix-img-size" alt="">
    <?php } ?>

    <div class="d-flex flex-row justify-content-center">
        <div class="row">
            <?=$this->Html->link('Tiếp tục mua hàng', ['controller' => 'Pages', 'action' => 'display'],
            [
                'class' => 'mt-3',
            ]);?>
        </div>
    </div>


</div>
