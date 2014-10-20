<?php

////////////////////////////////////////////////////////////////////////////
require_once __DIR__."/../vendor/autoload.php";

////////////////////////////////////////////////////////////////////////////
define("REDDIT_API_URL","http://api.reddit.com/hot");
define("CACHE_PATH",__DIR__."/../lib/cache/");

////////////////////////////////////////////////////////////////////////////
class myPlugin {

	private $config;

	public function config_loaded(&$settings) {
		$this->config = $settings;
	}

	public function before_render(&$twig_vars, &$twig, &$template)
	{
		if($template == "myPlugin") {
			$twig_vars["reddits"] = $this->getReddits();
		}
	}

	private function getReddits() {
		//var_dump($this->config);
		$cache = new Gilbitron\Util\SimpleCache();
		$cache->cache_path = CACHE_PATH;
		$cache->cache_time = 1000;
		$reddits = unserialize($cache->get_cache("reddits"));
		if($reddits == "")
		{
			try {
				$request = Requests::get(REDDIT_API_URL);
				$cache->set_cache("reddits", serialize(json_decode($request->body)->data->children));
			}
			catch(Exception $e) {
				$cache->cache_time = 99999999999999999999999999999;
				$reddits = unserialize($cache->get_cache("reddits"));
			}
		}
		return $reddits;
	}
}

?>