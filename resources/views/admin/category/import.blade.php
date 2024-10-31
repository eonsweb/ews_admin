<div class="modal fade" id="categoryImportModal" data-bs-backdrop="static" tabindex="-1" data-bs-keyboard="false" aria-labelledby="categoryImportModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form action="{{ route('admin.categories.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success ">
                    <h5 class="modal-title text-white" id="categoryImportModalLabel">Import Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Import Guide</h6>
                    <p class="text-muted mb-3">
                        Please ensure your <span class="text-success">excel</span> file contains the following columns:
                    </p>
                    <ul>
                        <li><strong>Name</strong>: The name of the category.</li>
                        <li><strong>Description<span class="text-primary">(optional)</span></strong>: A brief description of the category.</li>
                        <li><strong>Image Path <span class="text-primary">(optional)</span></strong>: The file path or URL of the category image.</li>
                    </ul>

                    <div class="mb-3">
                        <label for="file" class="form-label">Import Batch Categories</label>
                        <input class="form-control @error('file') is-invalid @enderror" name="file" type="file"
                            accept=".xlsx, .xls, .csv" id="file">
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
