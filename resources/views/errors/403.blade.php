@extends('errors::layout')

@section('title', __('Página Prohibida'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
