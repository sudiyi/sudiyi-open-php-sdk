<?php

/**
 *  回调基础类
 * @author yhs
 */
$post = json_decode(file_get_contents("php://input"), true);


/**
 * 速递易返回分为两种，一种是有result的（预约完箱格之后一般几秒会调用），一个是有status的（箱格有变化的时候就会通知）。所以要分别来判断；
 */

//返回有result表示预约之后返回的
if (isset($post['result'])) {
    $resv_order_no = $post['resv_order_no'];//预约订单的编号
    $result = $post['result'];//预约结果*
    $order_no = $post['order_no'];//第三方订单,为发起预约时传入的订单号
    $box_type = $post['box_type'];//实际取得的箱格的类型
    $box_no = $post['box_no'];//箱格序号
    $upgraded = $post['upgraded'];//是否进行了升箱
    $resv_code = $post['resv_code'];//预约码

    if ($result == 'success') {
        //TODO 如果预约成功
    } elseif ($result == 'fail') {
        //TODO 如果预约失败
    } elseif ($result == 'timeout') {
        //TODO 如果预约超时
    }
}

//返回有status的表示箱格状态有变化的
if (isset($post['status'])) {
    $resv_order_no = $post['resv_order_no'];//预约订单的编号
    $status = $post['status'];//订单的状态码
    $open_code = $post['open_code'];//开箱码
    
    if ($status == 5){
        //TODO 已投件，等待客户取件
    } elseif ($status == 6){
        //TODO 已取件，通知给相应人员
    } elseif ($status == 7){
        //TODO 客户预约超过保留时长仍未投件，预约箱格自动释放
    }
}
