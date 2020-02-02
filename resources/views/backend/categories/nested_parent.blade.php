@if($category->parents != 0)
    @include('backend.categories.nested_parent', ['category' => $category->parent])
@endif
 {{$category->name}} >> 
