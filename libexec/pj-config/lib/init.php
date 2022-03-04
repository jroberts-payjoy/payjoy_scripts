<?php

define('_PJ_ROOT', getenv('_PJ_ROOT'));

// Grab required files for parsing YAML config
require(_PJ_ROOT .'/libexec/pj-config/lib/yaml-parser/Yaml.php');
require(_PJ_ROOT .'/libexec/pj-config/lib/yaml-parser/Parser.php');
require(_PJ_ROOT .'/libexec/pj-config/lib/yaml-parser/Inline.php');
require(_PJ_ROOT .'/libexec/pj-config/lib/yaml-parser/Unescaper.php');

require(_PJ_ROOT .'/libexec/pj-config/lib/yaml-parser/Exception/ExceptionInterface.php');
require(_PJ_ROOT .'/libexec/pj-config/lib/yaml-parser/Exception/RuntimeException.php');
require(_PJ_ROOT .'/libexec/pj-config/lib/yaml-parser/Exception/ParseException.php');


/**
 * Gets the config array
 *
 * @return array
 * @author Jake A. Smith
 **/
function config()
{
	static $return;

	if(!is_array($return))
	{
		// Grab tracked settings
		$file = _PJ_ROOT .'/conf/settings.yaml';
		$settings = Symfony\Component\Yaml\Yaml::parse($file);

		// Grab gitignored config
		$file = _PJ_ROOT .'/conf/config.yaml';
		$config = Symfony\Component\Yaml\Yaml::parse($file);

		// Ensure we are always dealing with arrays
		if(!is_array($settings))
			$settings = array($settings);
		if(!is_array($config))
			$config = array($config);

		// Merge them and clean up
		$return = array_merge_multi_dimension($settings, $config);
	}

	return $return;
}

function array_merge_multi_dimension() {
    $params = func_get_args();
    $merged = array_shift($params); // using 1st array as base

    foreach ($params as $array) {
        foreach ($array as $key => $value) {
            if (isset($merged[$key]) && is_array($value) && is_array($merged[$key]))
                $merged[$key] = array_merge_multi_dimension($merged[$key], $value);
            else
                $merged[$key] = $value;
        }
    }
    return $merged;
}