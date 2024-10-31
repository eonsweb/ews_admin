<!-- Modal -->
<div class="modal fade" id="customerEditModal-{{ $customer->id }}" data-bs-backdrop="static" tabindex="-1" data-bs-keyboard="false"
    aria-labelledby="customerEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.customer.update',$customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header ">
                    <h5 class="modal-title" id="customerNewModalLabel">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="customerName" class="form-label">Customer Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="customerName"
                            name="name" value="{{ old('name',$customer->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone',$customer->phone) }}" required>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" cols="30" rows="3" 
                        >{{ old('address', $customer->address) }}
                        </textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="id_type" class="form-label">ID Type<span class="text-secondary">(optional)</span></label>
                        <input type="text" class="form-control @error('id_type') is-invalid @enderror" id="id_type"
                            name="id_type" value="{{ old('id_type',$customer->id_type)}}">
                        @error('id_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="id_number" class="form-label">ID Number<span class="text-secondary">(optional)</span></label>
                        <input type="text" class="form-control @error('id_number') is-invalid @enderror" id="id_number"
                            name="id_number" value="{{ old('id_number',$customer->id_number)}}">
                        @error('id_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="mb-3">
                        <label for="image" class="form-label">Upload Customer Image</label>
                        <input class="form-control @error('image') is-invalid @enderror " name="image" type="file" id="image">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Save Customer</button>
                </div>
            </form>
        </div>

    </div>
</div>




