@extends('layouts.backend')
@section('title','Sample | Categories')

@section('head_title','Category')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('categories.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Category</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('categories.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Table</span>
        </a>
    </li>   
@endsection

@section('content')
<div class="box">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Category Table<small>List of categories</small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-20">
                <form method="POST" action="{{route('categories.search')}}">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-4">                                
                                    @csrf
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" name="search" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch" required>
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span><i class="la la-search"></i></span>
                                        </span>                                           
                                    </div>                                        
                                
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-danger">Search</button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{route('categories.index')}}" class="btn btn-danger">Show All</a>
                            </div>                           
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="{{route('categories.create')}}" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus"></i>
                                <span>Create</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
                </form>
            </div>

            <!--end: Search Form -->


            <!-- Tree Dialog Start -->
            <div class="mb-4">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#treeView">Tree View</button>
            </div>
            <!-- Tree Dialog End -->

            <!--begin: Datatable -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="html_table" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th title="Field #1" data-field="No">No</th>
                            <th title="Field #2" data-field="Name">Name</th>
                            <th title="Field #2" data-field="Name">Path</th>
                            <th title="Field #3" data-field="Email">Description</th>
                            <th title="Field #3" data-field="Role">Photo</th>
                            <th title="Field #3" data-field="Role">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key=>$category)
                    	<tr>
                    		<td class="text-center">{{ $key+ $categories->firstItem() }}</td>
                            <td>{{$category->category_infos[0]->name}}  </td>
                            @if($category->parents == 0)
                                <td>{{$category->category_infos[0]->name}}</td>
                            @else
                                <td>                            
                            @if($category->parents != 0)
                                @include('backend.categories.nested_parent', ['category' => $category->parent])
                            @endif
                                {{$category->category_infos[0]->name}}
                                </td>
                            @endif
                            @if(!$category->category_infos[0]->description)
                                <td class="text-center"><span class="text-danger">null</span>
                            @else
                    		  <td>{{Str::limit($category->category_infos[0]->description, 20)}}</td>
                            @endif
                    		<td class="text-center"><img src="{{url(\Storage::url('uploads/category_imgs/'.$category->image))}}" class="img-rounded" alt="Cinque Terre" width="60" height="60"></td>
                            <td class="text-center">
                            	<a class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('categories.show', $category->id)}}">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('categories.edit', $category->id)}}"><i class="fa fa-edit"></i></a>

                                <form action="{{route('categories.destroy', $category->id)}}" method="POST" style="display:inline;">
                                      @csrf                                        
                                    <button type="submit" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" onclick="return confirm('Are you sure to delete it?')"><i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                    	</tr>
                        @endforeach 
                    </tbody>                                     
                </table>    
                {{ $categories->links() }}                   
            </div>

            <!--end: Datatable -->
        </div>
        
    </div>
</div>


<!-- Tree Modal -->

<div class="modal fade" id="treeView" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Category Tree View</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <tree-component :categories="{{json_encode($category_array)}}"></tree-component>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<!-- End Tree Modal -->
@endsection