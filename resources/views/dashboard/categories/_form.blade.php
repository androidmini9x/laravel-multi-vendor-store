@if($errors->any())
<div class="alert alert-danger">
    <h4>Error Occured!</h4>
    <ul>
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-group">
    <x-form.input label="Category Name" type="text" name="name" :value="$category->name" />
</div>
<div class="form-group">
    <label for="">Category Parent</label>
    <select class="form-control select-control" name="parent_id">
        <option value="">Primary Parent</option>
        @foreach($parents as $parent)
        <option value="{{ $parent->id }}" @selected($parent->id == old('parent_id', $category->parent_id))>{{ $parent->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <x-form.textarea name="description" :value="old('description', $category->description)" />
</div>
<div class="form-group">
    @if ($category->image)
    <div>
    <img src="{{ asset('storage/' . $category->image) }}" alt="" height="90">
    </div>
    @endif
    <x-form.input label="Category Image" type="file" name="image" accept="image/*" />
</div>
<div class="form-group">
    <label for="">Category Status</label>
    <div>
        <x-form.radio name="status" :checked="$category->status" :options="['active' => 'Active', 'archived' => 'Archived']" />
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Save</button>
</div>