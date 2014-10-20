<?php

class myMetas {

    ////////////////////////////////////////////////////////////////////////////
    private $meta_values = array(
        "slug" => "Slug",
        "category" => "Category",
        "status" => "Status",
        "type" => "Type",
        "thumbnail" => "Thumbnail",
        "icon" => "Icon",
        "tpl" => "Tpl"
        );
    private $content = null;
    private $config = null;
    private $custom_meta_enabled = false;
    private $meta = array();

    ////////////////////////////////////////////////////////////////////////////
    public function before_load_content(&$file) {

        if (file_exists($file))
            $this->content = file_get_contents($file);
    }

    ////////////////////////////////////////////////////////////////////////////
    public function config_loaded(&$settings) {

        $this->config = $settings;
        if (isset($settings["custom_meta_values"]))
            $this->meta_values = $settings["custom_meta_values"];
    }

    ////////////////////////////////////////////////////////////////////////////
    public function before_read_file_meta(&$headers) {
        $this->file_meta();
        foreach ($this->meta_values as $key => $value) {
            $headers[$key] = $value;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function get_page_data(&$data, $page_meta) {
        foreach ($page_meta as $key => $value) {
            $data[$key] = $value ;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function before_render(&$twig_vars, &$twig) {
        $twig_vars["my_meta"] = $this->file_meta();
    }

    ////////////////////////////////////////////////////////////////////////////
    private function file_meta() {
        $content = $this->content;
        $config = $this->config;

        if (!isset($this->config)) {
            $config = array();
        }

        $headers = $this->meta_values;

        foreach ($headers as $field => $regex) {
            if (preg_match("/^[ \t\/*#@]*" . preg_quote($regex, "/") . ":(.*)$/mi", $content, $match) && $match[1]) {
                $headers[$field] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", "", $match[1]));
            } else {
                $headers[$field] = "";
            }
        }
        return $headers;
    }

}