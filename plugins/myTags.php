<?php

//////////////////////////////////////////////////////////////////////////////////////
define("TAG_TEMPLATE", "tag");
define("TAGS_TEMPLATE", "tags");

class myTags {

    //////////////////////////////////////////////////////////////////////////////////////
    private $baseURL;
    private $currentURL;
    private $currentTag;
    private $isTag;
    private $isTags;
    private $currentMeta;

    //////////////////////////////////////////////////////////////////////////////////////
    private function read_file_meta($content) {
        $headers = array("tags" => "Tags");
        foreach ($headers as $field => $regex) {
            if (preg_match("/^[ \t\/*#@]*" . preg_quote($regex, "/") . ":(.*)$/mi", $content, $match) && $match[1]){
                $headers[ $field ] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", "", $match[1]));
            } else {
                $headers[ $field ] = "";
            }
        }
        if (strlen($headers["tags"]) > 1) $headers["tags"] = array_map("trim", explode(",", $headers["tags"]));
        else $headers["tags"] = NULL;
        return $headers;
    }

    //////////////////////////////////////////////////////////////////////////////////////
    public function request_url(&$url) {
        $this->currentURL = $url;
        $this->isTag = (substr($this->currentURL, 0, 4) == "tag/");
        $this->isTags = (substr($this->currentURL, 0, 4) == "tags");
        if ($this->isTag) $this->currentTag = substr($this->currentURL, 4);
    }

    //////////////////////////////////////////////////////////////////////////////////////
    public function after_load_content(&$file, &$content) {
        $this->currentMeta = $this->read_file_meta($content);
    }

    //////////////////////////////////////////////////////////////////////////////////////
    public function config_loaded(&$settings) {
        $this->baseURL = $settings["base_url"];
    }

    //////////////////////////////////////////////////////////////////////////////////////
    public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page) {
        if ($this->isTag) {
            $newPages = array();
            foreach ($pages as $page) {
                $tags = array_map("trim", explode(",", $page["tags"]));
                if(in_array($this->currentTag, $tags)) {
                    $page["tags"] = $tags;
                    array_push($newPages, $page);
                }
            }
            $pages = $newPages;
        }
        else if ($this->isTags) {
            $theTags = array();
            $newPages = array();
            foreach ($pages as $page) {
                $tags = array_map("trim", explode(",", $page["tags"]));
                foreach($tags as $tag) {
                    if($tag != "") {
                        if(!array_key_exists($tag, $theTags)) {
                            $theTags[$tag] = array();
                        }
                        array_push($theTags[$tag],$page);
                    }    
                }
            }
            $this->tags = $theTags;
            $pages = $newPages;
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////
    public function before_render(&$twig_vars, &$twig, &$template) {
        if ($this->isTag) {
            $template = TAG_TEMPLATE;
            $twig_vars["meta"]["title"] = "#" . $this->currentTag;
            $twig_vars["meta"]["currentTag"] = $this->currentTag;
        }
        else if ($this->isTags) {
            $template = TAGS_TEMPLATE;
            header($_SERVER["SERVER_PROTOCOL"]." 200 OK");
            $twig_vars["meta"]["title"] = "tags";
            $twig_vars["tags"] = $this->tags;
        }
        else {
            $twig_vars["meta"] = array_merge($twig_vars["meta"], $this->currentMeta);
            $twig_vars["page"]["tags"] = $this->currentMeta["tags"];
        }
    }
}

?>