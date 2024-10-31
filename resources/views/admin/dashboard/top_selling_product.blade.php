
<div class="row">
    
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Top Selling Products for Current Month
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="file-export" class="table table-bordered text-nowrap table-striped w-100">
                        <thead>
                            <tr>
                                <th style="width: 10%;">#</th>
                                <th>Product Info</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topProducts as $key => $agreementProduct)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $agreementProduct->product->name ." - ". $agreementProduct->product->sale_price }}</td>
                                    <td>{{ floor($agreementProduct->total_quantity) }}</td>
                                    <td>{{ number_format($agreementProduct->total_price,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Top Selling Categories for Current's Month 
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap table-striped w-100">
                        <thead>
                            <tr>
                                <th style="width: 10%;">#</th>
                                <th>Category Name</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topCategories as $key => $top_category)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $top_category->name ." - ". $top_category->name }}</td>
                                    <td>{{ floor($top_category->total_quantity_sold) }}</td>
                                    <td>{{ number_format($top_category->total_amount_sold,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>