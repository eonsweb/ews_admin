

<!-- Modal -->
<div class="modal fade" id="productNewModal" data-bs-backdrop="static" tabindex="-1" data-bs-keyboard="false"
    aria-labelledby="productNewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="productNewModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="productName"
                            name="name" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <select class="js-example-basic-single @error('category_id') is-invalid @enderror" name="category_id">
                                <option  selected="" disabled="">Select Product's Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>



                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Product Image : Optional</label>
                        <input class="form-control @error('image') is-invalid @enderror " name="image"
                            type="file" id="image">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Save Product</button>
                </div>
            </form>
        </div>

    </div>
</div>
