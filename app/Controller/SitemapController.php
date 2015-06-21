<?php

class SitemapController extends AppController
{

    public $layout = 'xml/default';
    public $uses = ['Post'];
    public $helpers = ['Time'];
    public $components = ['RequestHandler'];

    function index()
    {
    }
}

?>