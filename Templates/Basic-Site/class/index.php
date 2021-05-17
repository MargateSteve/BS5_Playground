<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//nicePrint_r($data, 'Data');
require_once 'T_Basic.php';
$t = new T_Basic;


$t->set_body_class('');
$t->render_titles(['page_title'=>'CENTER (FLUID  COLUMN)']);
$t->set_crumbs();
$t->set_content('aaa');
$t->set_js_files([]);
$t->render();

