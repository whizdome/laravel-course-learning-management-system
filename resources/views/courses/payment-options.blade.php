     <?php 
                        if($course->discount_price AND $course->discount_price > 0){
                             $finalPrice = $course->discount_price;
                        }else {
                             $finalPrice = $course->actual_price;  
                            }
                        ?>
                        <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                                <div class="row" style="margin-bottom:40px;">
                                <div class="col-md-8 col-md-offset-2">
                                    <p>
                                        <div>
                                            <span style="font-size: 38px; font-weight: bold;">
                                                ₦{!! number_format($course->discount_price) !!}</span> 

                                            <span style="font-size: 18px; text-decoration:line-through" class="ml-3 text-muted"
                                            >₦{!! number_format($course->actual_price) !!}</span> 

                                            

                                        </div>
                                    </p>

                                    @if(Auth::check())
                                     <input type="hidden" name="email" value="{{ Auth::user()->email }}"> {{-- required --}}
                                    @else 
                                          <!-- Actual Price Field -->
                                        <div class="form-group col-sm-12">
                                         
                                             <input class="form-control" type="email" name="email" value="" placeholder="Enter valid email" required="required"> {{-- required --}}
                                    
                                        </div>                   

                                       

                                    @endif

                                    <input type="hidden" name="orderID" value="{{ $course->id }}">
                                    <input type="hidden" name="amount" value="{{ $finalPrice*100 }}"> {{-- required in kobo --}}
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="metadata" value="{{ json_encode($array = ['course_id' => $course->id,'customer_email'=> $course->user['email'] ]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
                                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                                    <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> {{-- required --}}
                                    {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> {{-- employ this in place of csrf_field only in laravel 5.0 --}}


                                    <p>
                                    <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
                                    <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                                    </button>
                                    <div class="text-center">
                                            24-hour money-back guarantee.
                                    </div>
                                    </p>
                                </div>
                                </div>
                        </form>
