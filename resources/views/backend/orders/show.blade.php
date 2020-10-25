@extends('layouts.backend')
@section('title','Order | View ')

@section('head_title','Orders')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('orders.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Order</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('orders.show', $order->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">View</span>
        </a>
    </li>   
@endsection

@section('content')
<div class="container col-md-12" id="product-order">
    <div class="card">
        <div class="container">
            <div class="row">
                <div class="col-xl-4"></div>
                <div class="col-xl-4 card-title text-center mt-4 h3">Order Detail</div>
                <div class="col-xl-4 m--align-right">
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" v-on:click="edit()" v-if="edit_mode == false"><i class="fa fa-edit"></i></a>
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" v-on:click="cancel()" v-if="edit_mode == true && is_loading == false"><i class="fa fa-times"></i></a>
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" v-on:click="save()" v-if="edit_mode == true && is_loading == false"><i class="fa fa-check"></i></a>
                    <a class="mt-3 buttonload btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" v-if="is_loading == true"><i class="fas fa-sync fa-spin"></i></a>
                </div>
            </div>
            <form>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>No</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>#{{$order->order_no}}</strong></div>
                </div> 
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Ordered at</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$order->created_at->format('d/M/Y h:i A')}}</strong></div>
                </div> 
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Status</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5" v-if="edit_mode == false"><strong><span class="badge badge-pill badge-info">@{{order_status}}</span></strong></div>
                    <div class="col-sm-4 h5" v-if="edit_mode == true">
                        <select v-model="selected_order_status" class="form-control" id="exampleFormControlSelect1">
                            <option v-for="option in order_statuses" v-bind:value="option.id">
                                @{{ option.name }}
                              </option>
                          </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Customer Name</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><a href="{{route('users.show', $order->user->id)}}"><strong>{{$order->user->name}}</strong></a></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Total Item</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$order->item_count}}</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Product Cost</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{number_format($order->total_amount)}}</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Delivery Cost</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5" v-if="edit_mode == false"><strong>@{{formatPrice(delivery_cost)}}</strong></div>
                    <div class="col-sm-4 h5" v-if="edit_mode == true">
                        <input v-on:keyup="delivery_keyup" type="number" v-model="delivery_cost" class="form-control" placeholder="Enter Delivery Cost" required>
                    </div>
                </div>
                <div class="row mb-2" style="color: blue">
                    <div class="col-sm-3 h5"><strong>Total Amount</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5" v-if="edit_mode == false"><strong>@{{formatPrice(total_amount)}}</strong></div>
                    <div class="col-sm-4 h5" v-if="edit_mode == true">
                        <input type="number" v-model="total_amount" class="form-control" placeholder="Enter Total Amount" disabled>
                    </div>
                </div>
                <div class="row mb-2" style="color: green">
                    <div class="col-sm-3 h5"><strong>Pay Amount</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5" v-if="edit_mode == false"><strong>@{{formatPrice(pay_amount)}}</strong></div>
                    <div class="col-sm-4 h5" v-if="edit_mode == true">
                        <input v-on:keyup="pay_keyup" type="number" v-model="pay_amount" class="form-control" placeholder="Enter Pay Amount" required>
                    </div>
                </div>
                <div class="row mb-2" style="color: red">
                    <div class="col-sm-3 h5"><span><strong>Remain Amount</strong></span></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5" v-if="edit_mode == false"><strong>@{{formatPrice(remain_amount)}}</strong></div>
                    <div class="col-sm-4 h5" v-if="edit_mode == true">
                        <input type="number" v-model="remain_amount" class="form-control" placeholder="Enter Remain Amount" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 h5"><strong>Remark</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5" v-if="edit_mode == false"><i>@{{remark}}</i></div>
                    <div class="col-sm-4 h5" v-if="edit_mode == true">
                        <input type="text" v-model="remark" class="form-control" placeholder="Enter Remark">
                    </div>
                </div>
                <br>
                <h4>Order Items</h4>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-font">
                            <th class="align-middle text-center">#</th>
                            <th class="align-middle text-center">Product Image</th>
                            <th class="align-middle text-center">Product Name</th>
                            <th class="align-middle text-center">Quantity</th>
                            <th class="align-middle text-center">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->order_items as $key=>$item)
                            <tr>
                                <td class="align-middle text-center">{{$key+1}}</td>
                                <td class="align-middle text-center">
                                    @if(is_file(\Storage::path('public/uploads/product_imgs/thumbnail/'.$item->item->image)))
                                        <img src="{{url(\Storage::url('uploads/product_imgs/thumbnail/'.$item->item->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="100" height="100">
                                    @else
                                        <img src="{{asset('/images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150"> 
                                    @endif
                                </td>
                                <td class="align-middle text-center">{{$item->item->infos->where('language_id',1)->first()->name}}</td>
                                <td class="align-middle text-center">{{$item->quantity}}</td>
                                <td class="align-middle text-center">{{$item->sub_total}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            


        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#product-order',
            data: {
                message: 'Hello Vue!',
                edit_mode: false,
                order_status: {!! json_encode($order->order_status->name) !!},
                selected_order_status: {!! json_encode($order->order_status_id) !!},
                order_statuses: {!! json_encode($order_statuses) !!},
                product_cost: {!! json_encode($order->total_amount) !!},
                delivery_cost: {!! json_encode($order->delivery_cost) !!},
                total_amount: {!! json_encode($order->total_net) !!},
                pay_amount: {!! json_encode($order->pay_amount) !!},
                remain_amount: {!! json_encode($order->remain_amount) !!},
                remark: {!! json_encode($order->remark) !!},
                base_url: {!!json_encode(url('/'))!!},
                is_loading: false,
            },
            mounted() {
                this.getTotalAmount();
            },
            methods: {
                formatPrice(value) {
                    let val = (value/1).toFixed(0).replace(',', '.')
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                },
                
                getTotalAmount(){
                    this.total_amount = parseFloat(this.delivery_cost)+parseFloat(this.product_cost);
                },

                edit: function(){
                    this.edit_mode = true;
                },

                cancel: function(){
                    this.remark = {!! json_encode($order->remark) !!};
                    this.delivery_cost = {!! json_encode($order->delivery_cost) !!};
                    this.pay_amount = {!! json_encode($order->pay_amount) !!};
                    this.remain_amount = {!! json_encode($order->remain_amount) !!};
                    this.total_amount = {!! json_encode($order->total_net) !!};
                    this.selected_order_status = {!! json_encode($order->order_status_id) !!};
                    this.edit_mode = false;
                },

                delivery_keyup: function(event){
                    // if(this.delivery_cost == '')
                    // {
                    //     this.delivery_cost = 0;
                    // }
                    this.total_amount = parseFloat(this.product_cost) + parseFloat(this.delivery_cost);
                    this.remain_amount = this.total_amount - this.pay_amount;
                },

                pay_keyup: function(){
                    // if(this.pay_amount == '')
                    // {
                    //     this.pay_amount = 0;
                    // }

                    this.remain_amount = this.total_amount - this.pay_amount;
                },

                save: function(){
                    if(this.delivery_cost == '' || this.pay_amount == '' )
                    {
                        alert('Please fill all field');
                    }
                    else{
                        this.is_loading = true;
                        axios
                        .put(this.base_url+'/admin/orders/update/show/'+ {!! json_encode($order->id) !!},
                        {
                            delivery_cost: this.delivery_cost,
                            pay_amount: this.pay_amount,
                            remain_amount: this.remain_amount,
                            remark: this.remark,
                            order_status_id: this.selected_order_status,
                        }
                        )
                        .then(response => {
                            if(response.data.status == 200)
                            {
                                this.remark = response.data.data.remark;
                                this.delivery_cost = response.data.data.delivery_cost;
                                this.pay_amount = response.data.data.pay_amount;
                                this.remain_amount = response.data.data.remain_amount;
                                this.total_amount = response.data.data.total_net;
                                this.order_status = response.data.order_status;
                                this.is_loading = false;
                                this.edit_mode = false;
                            }
                        })
                    }
                    
                    
                }
            },
        })
    </script>
@endsection