@if(!isset($orderDetail))
    @eval($orderDetail['product_id'] =null)
    @eval($orderDetail['qty'] =null )
    @eval($orderDetail['uom_id'] =null )
    @eval($orderDetail['price'] =null )
    @eval($orderDetail['product_name'] =null )
@endif
    {!! Form::hidden('orderDetail['.$orderDetails_count.'][id]', $id) !!}
    {!! Form::hidden('orderDetail['.$orderDetails_count.'][order_id]', $order_id) !!}
<div class="form-group">
    <div class="col-sm-6">
    {!! Form::hidden('orderDetail['.$orderDetails_count.'][product_id]', $orderDetail['product_id'], ['class' => 'form-control']) !!}
    {!! Form::text('product_name', $orderDetail['product_name'], ['class' => 'form-control','readonly'=>'readonly']) !!}
    </div>
    <div class="col-sm-2">
    {!! Form::text('orderDetail['.$orderDetails_count.'][qty]', $orderDetail['qty'], ['class' => 'form-control','placeholder'=>'Quantity']) !!}
    </div>
    <div class="col-sm-2">
    {!! Form::select('orderDetail['.$orderDetails_count.'][uom_id]', $uomList, $orderDetail['uom_id'], ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-2">
    {!! Form::text('orderDetail['.$orderDetails_count.'][price]', $orderDetail['price'], ['class' => 'form-control','placeholder'=>'Price']) !!}
    </div>
</div>
