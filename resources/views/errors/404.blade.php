@extends('errors::minimal')

@section('title', __('general.title404'))
@section('code', '404')
@section('message', $exception->getMessage())
