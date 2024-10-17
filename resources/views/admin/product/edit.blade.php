<!-- Modal -->
<div class="modal fade" 
     id="productEditModal-{{ $product->id }}" 
     data-bs-backdrop="static" 
     tabindex="-1"
     data-bs-keyboard="false"
     tabindex="-1" 
     aria-labelledby="productEditModalLabel-{{ $product->id }}" 
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.product.update', $product->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="productEditModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="productName"
                            name="name" value="{{ $product->name }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="salePrice" class="form-label">Sale Price</label>
                        <input type="text" class="form-control @error('sale_price') is-invalid @enderror" id="salePrice"
                            name="sale_price" value="{{ $product->sale_price }}" required>
                        @error('sale_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="stockPrice" class="form-label">Stock Name</label>
                        <input type="text" class="form-control @error('stock_price') is-invalid @enderror" id="stockPrice"
                            name="stock_price" value="{{ $product->stock_price }}" required>
                        @error('stock_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <select class="js-example-basic-single" name="category_id" id="editCategorySelect">
                                <option value="" disabled>Select Product's Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update Product</button>
                </div>
            </form>
        </div>

    </div>
</div>
