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
    <x-form.input label="Product Name" type="text" name="name" :value="$product->name" />
</div>
<div class="form-group">
    <label for="">Product Parent</label>
    <select class="form-control select-control" name="category_id">
        <option value="">Primary Parent</option>
        @foreach(\App\Models\Category::all() as $category)
        <option value="{{ $category->id }}" @selected($category->id == old('category_id', $product->category_id))>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <x-form.textarea name="description" :value="old('description', $product->description)" />
</div>
<div class="form-group">
    @if ($product->image)
    <div>
    <img src="{{ asset('storage/' . $product->image) }}" alt="" height="90">
    </div>
    @endif
    <x-form.input label="Product Image" type="file" name="image" accept="image/*" />
</div>

<div class="form-group">
    <x-form.input label="Tags" type="text" name="tags" :value="$tags" />
</div>
<div class="form-group">
    <x-form.input label="Price" type="text" name="price" :value="$product->price" />
</div>
<div class="form-group">
    <x-form.input label="Compare Price" type="text" name="compare_price" :value="$product->compare_price" />
</div>
<div class="form-group">
    <label for="">Product Status</label>
    <div>
        <x-form.radio name="status" :checked="$product->status" :options="['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived']" />
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Save</button>
</div>

@push('style')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@push('javascript')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script>
    var inputElem = document.querySelector('input[name="tags"]') // the 'input' element which will be transformed into a Tagify component
    var tagify = new Tagify(inputElem, {
    // A list of possible tags. This setting is optional if you want to allow
    // any possible tag to be added without suggesting any to the user.
    whitelist: ['foo', 'bar', 'and baz', 0, 1, 2]
    })
</script>
@endpush