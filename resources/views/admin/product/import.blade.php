<!-- Modal -->
<div class="modal fade" id="productImportModal" data-bs-backdrop="static" tabindex="-1" data-bs-keyboard="false" 
    aria-labelledby="productImportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.products.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="productImportModalLabel">Import Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="image" class="form-label">Import Batch Products</label>
                        <input class="form-control @error('file') is-invalid @enderror " name="file" type="file"
                            accept=".xlsx, .xls, .csv" id="image">
                        @error('file')
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
