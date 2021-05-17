<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//nicePrint_r($data, 'Data');
require_once 'T_Admin.php';
$t = new T_Admin;


$t->set_body_class('bg-info');
$t->render_titles(['page_title'=>'CENTER (FLUID  COLUMN)']);
$t->set_crumbs();
$t->set_content('<canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>');
$t->set_js_files(['remote/chart-js','local/chartdata']);
$t->render();

