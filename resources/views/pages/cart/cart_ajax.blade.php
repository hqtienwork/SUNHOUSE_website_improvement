@extends('layout')
@section('content')

	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Giỏ hàng của bạn</li>
				</ol>
			</div>
			  @if(session()->has('message'))
                    <div class="alert alert-success">
                        {!! session()->get('message') !!}
                    </div>
                @elseif(session()->has('error'))
                     <div class="alert alert-danger">
                        {!! session()->get('error') !!}
                    </div>
                @endif
			<div class="table-responsive cart_info">

				<form action="{{url('/update-cart')}}" method="POST">
					@csrf
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
						<td class="image" style="width: 8%;">Hình ảnh</td>
							<td class="description">Tên sản phẩm</td>
							<td class="description" style="width: 5%;">Số lượng tồn</td>
							<td class="price">Giá sản phẩm</td>
							<td class="quantity">Số lượng</td>
							<td class="total" style="width: 12%; text-align: right;">Thành tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@if(Session::get('cart')==true)
						@php
								$total = 0;
						@endphp
						@foreach(Session::get('cart') as $key => $cart)
							@php
								$subtotal = $cart['product_price']*$cart['product_qty'];
								$total+=$subtotal;
							@endphp

						<tr>
							<td class="cart_product" style="width: 10%; text-align:center">
								<img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
							</td>
							<td class="cart_description product-name">
								<h4><a href=""></a></h4>
								<p>{{$cart['product_name']}}</p>
							</td>

							<td class="cart_description product-stock" style="width: 5%; text-align: center;">
								<h4><a href=""></a></h4>
								<p>{{$cart['product_quantity']}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
							</td>
							<td class="cart_quantity custom-quantity">
								<div class="cart_quantity_button">
									<input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  >
								</div>
							</td>
							<td class="cart_total" style="text-align: right;">
								<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}}đ
								</p>
							</td>
							<td class="cart_delete" style="width: 6%; text-align: center; vertical-align: middle;">
								<a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}" style="display: inline-block; padding: 6px 10px; background: #f8f8f8; border-radius: 4px;">
									<i class="fa fa-times" style="color: #db2128; font-size: 16px;"></i>
								</a>
							</td>
						</tr>
						
						@endforeach
						<tr>
							<td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="check_out btn btn-default btn-sm"></td>
							<td><a class="btn btn-default check_out" href="{{url('/del-all-product')}}">Xóa tất cả</a></td>
							<td>
								@if(Session::get('coupon'))
	                          	<a class="btn btn-default check_out" href="{{url('/unset-coupon')}}">Xóa mã khuyến mãi</a>
								@endif
							</td>

							<td>
								@if(Session::get('customer_id'))
	                          	<a class="btn btn-default check_out" href="{{url('/checkout')}}">Đặt hàng</a>
	                          	@else 
	                          	<a class="btn btn-default check_out" href="{{url('/dang-nhap')}}">Đặt hàng</a>
								@endif
							</td>

							
							<td colspan="3" style="text-align:right; vertical-align:top;">
								<div style="display:inline-block; text-align:right;">
									<p><strong>Tổng tiền hàng:</strong> {{number_format($total,0,',','.')}}đ</p>
									{{-- Nếu có mã giảm giá --}}
									@if(Session::get('coupon'))
										@foreach(Session::get('coupon') as $key => $cou)
											@php
												if($cou['coupon_condition']==1){
													$coupon_desc = "-".$cou['coupon_number']."%";
													$coupon_value = ($total * $cou['coupon_number']) / 100;
												}else{
													$coupon_desc = "-".number_format($cou['coupon_number'],0,',','.')."đ";
													$coupon_value = $cou['coupon_number'];
												}
											@endphp
											<p><strong>Voucher từ Shop:</strong> {{ $coupon_desc }}</p>
											@php $total -= $coupon_value; @endphp
										@endforeach
									@endif
									<hr>
									<p style="font-family: 'Roboto', sans-serif; font-weight: bold; font-size: 18px; color: #db2128; text-align: right;">
    									Tổng tiền cuối: {{number_format(max($total, 0),0,',','.')}}đ
									</p>
								</div>
							</td>
						{{-- 	<li>Thuế <span></span></li>
							<li>Phí vận chuyển <span>Free</span></li> --}}
							
							
						</td>
						</tr>
						@else 
						<tr>
							<td colspan="5"><center>
							@php 
							echo 'Làm ơn thêm sản phẩm vào giỏ hàng';
							@endphp
							</center></td>
						</tr>
						@endif
					</tbody>

					

				</form>
					@if(Session::get('cart'))
					<tr><td>

							<form method="POST" action="{{url('/check-coupon')}}">
								@csrf
									<input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá"><br>
	                          		<input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá">
	                          	
                          		</form>
                          	</td>
					</tr>
					@endif

				</table>

			</div>
		</div>
	</section> <!--/#cart_items-->



@endsection