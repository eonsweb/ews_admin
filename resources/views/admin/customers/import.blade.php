<div class="modal fade" id="customerImportModal" data-bs-backdrop="static" tabindex="-1" data-bs-keyboard="false" aria-labelledby="customerImportModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form action="{{ route('admin.customers.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success ">
                    <h5 class="modal-title text-white" id="customerImportModalLabel">Import Customers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Import Guide</h6>
                    <p class="text-muted mb-3">
                        Please ensure your <span class="text-success">excel</span> file contains the following columns:
                    </p>
                    <ul class="text-success">
                        <li><strong>Name</strong>: The name of the customer.</li>
                        <li><strong>Phone</strong>: The Phone of the customer.</li>
                        <li><strong>Address</strong>: The Address of the customer.</li>
                    </ul>

                    <div class="mb-3">
                        <label for="file" class="form-label">Import Batch Customers</label>
                        <input class="form-control @error('file') is-invalid @enderror" name="file" type="file"
                            accept=".xlsx, .xls, .csv" id="file">
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
