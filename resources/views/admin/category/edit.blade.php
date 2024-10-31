<!-- Modal -->
<div class="modal fade" 
     id="categoryEditModal-{{ $category->id }}" 
     data-bs-backdrop="static" 
     tabindex="-1"
     data-bs-keyboard="false"
     tabindex="-1" 
     aria-labelledby="categoryEditModalLabel-{{ $category->id }}" 
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.category.update', $category->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryEditModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="categoryName"
                            name="name" value="{{ $category->name }}" value="{{old($category->name)}}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Category Description</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="3">{{$category->description}}</textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update Category</button>
                </div>
            </form>
        </div>

    </div>
</div>
