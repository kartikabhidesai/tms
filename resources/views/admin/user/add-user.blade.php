@extends('layouts.app')
@section('content')
@include('layouts.include.body_header')
<div class="container">
    <div class="row u-mb-large">
        <div class="col-12">
            <div class="c-tabs">
                <div class="c-tabs__content tab-content" id="nav-tabContent">
                    <div class="c-tabs__pane active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form name="add-user" id="addUser" action="{{ route('add-user') }}" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="c-field u-mb-small">
                                        <label class="c-field__label" for="firstName">First Name</label> 
                                        <input class="c-input" type="text" name="first_name" id="first_name" placeholder="First Name"> 
                                        <input class="c-input" type="hidden" name="_token" id="_token" value="{{ csrf_token() }}"> 
                                    </div>
                                    <div class="c-field u-mb-small">
                                        <label class="c-field__label" for="customer_number">Email</label>   
                                        <input class="c-input" type="email" name="email" id="customer_number" placeholder="email"> 
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="c-field u-mb-small">
                                        <label class="c-field__label" for="company">Password</label> 
                                        <input class="c-input" type="password" name="password" id="password" placeholder="password"> 
                                    </div>
                                    <div class="c-field u-mb-small">
                                        <label class="c-field__label" for="company">Conform Password</label> 
                                        <input class="c-input" type="password" name="cpassword" id="cpassword" placeholder="Conform password"> 
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="col u-mb-medium">
                                        <input type="submit" class="c-btn c-btn--info c-btn--fullwidth" value="Add">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- // .col-12 -->
    </div>
</div><!-- // .container -->
<style>
    input.has-error {
        border-color: red;
    }
</style>
@endsection
