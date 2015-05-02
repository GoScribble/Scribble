<?php namespace Scribble\Contracts;

interface ProviderContract
{
    public function __construct($config);
    public function create($data);
}
