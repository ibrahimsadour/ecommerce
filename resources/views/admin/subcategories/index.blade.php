
@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> الاقسام ألفرعية </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> الاقسام ألفرعية
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">جميع الاقسام ألفرعية </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <table
                                            class="table display nowrap table-striped table-bordered scroll-horizontal">
                                            <thead class="">
                                            <tr>
                                                <th>Name </th>
                                                <th>Main catergories </th>
                                                <th> Slug </th>
                                                <th> language</th>
                                                <th>Status</th>
                                                <th>Category image</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($sub_categories)
                                                @foreach($sub_categories as $sub_category)
                                                    <tr>
                                                        <td>{{$sub_category -> name}}</td>
                                                        <td>{{$sub_category ->mainCategory-> name}}</td> <!--Relation betwen sub cayegory and Main Category -->
                                                        <td>{{$sub_category -> slug}}</td>
                                                        <td>{{get_default_lang()}}</td>
                                                        <td>
                                                         @if($sub_category -> getActive() === "active") 
                                                         <b class="success">{{$sub_category -> getActive() }}
                                                         @else  
                                                         <b class="warning">{{$sub_category -> getActive()}}</b>
                                                        @endif
                                                        </td>
                                                        <td> <img style="width: 150px; height: 100px;" src="{{$sub_category -> 	photo}}"></td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <a href="{{route('admin.subcategories.edit',$sub_category -> id)}}"
                                                                   class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">Edit</a>


                                                                <a href="{{route('admin.subcategories.delete',$sub_category -> id)}}"
                                                                   class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">Remove</a>

                                                                   @if($sub_category -> active == 0)
                                                                    <a href="{{route('admin.subcategories.status',$sub_category -> id)}}"
                                                                   class="btn btn-outline-success btn-min-width box-shadow-3 mr-1 mb-1">active</a>
                                                                        @else
                                                                    <a href="{{route('admin.subcategories.status',$sub_category -> id)}}"
                                                                   class="btn btn-outline-warning btn-min-width box-shadow-3 mr-1 mb-1">
                                                                   Deactivate</a>
                                                                    @endif


                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @stop
