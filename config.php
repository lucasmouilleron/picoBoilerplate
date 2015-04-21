<?php 

////////////////////////////////////////////////////////////////////
date_default_timezone_set("Europe/Paris");

////////////////////////////////////////////////////////////////////
$config["site_title"] = "picoBoilerplate";
$config["theme"] = "custom-theme";
#$config["base_url"] = "picoBoilerplate";

////////////////////////////////////////////////////////////////////
#$config["date_format"] = 'd/m/Y';

////////////////////////////////////////////////////////////////////
$config["custom_meta_values"] = array(
    "status" => "Status",
    "category" => "Category",    
    "thumbnail" => "Thumbnail",
    "order" => "Order",
    "tags" => "Tags"
    );

////////////////////////////////////////////////////////////////////
$config["twig_config"] = array(
    "cache" => CACHE_DIR,
    "autoescape" => false,
    "debug" => true
    );

?>