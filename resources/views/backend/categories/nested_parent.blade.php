@if($category->parents != 0)
    @include('backend.categories.nested_parent', ['category' => $category->parent])
@endif
 {{$category->category_infos[0]->name}} >> 
