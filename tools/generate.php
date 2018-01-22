<?php

/*
 Author: Mo McRoberts <mo.mcroberts@bbc.co.uk>

 Copyright (c) 2014 BBC

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
*/


error_reporting(E_ALL);
ini_set('display_errors', 'On');

$stderr = fopen('php://stderr', 'w');

if(count($argv) < 2)
{
	fprintf($stderr, "Usage: %s TEMPLATE [OPTIONS]\n", $argv[0]);
	exit(1);
}
if(count($argv) > 2)
{
	for($c = 2; $c < $argc; $c++)
	{
		switch($argv[$c])
		{
			case 'nofonts':
				define('NOFONTS', true);
				break;
			default:
				fprintf($stderr, "%s: invalid option '%s'\n", $argv[0], $argv[$c]);
				exit(1);
		}
	}
}

require($argv[1]);

function path_is_absolute($path)
{
	return substr($path, 0, 1) == '/';
}

/* Return the path to a sample */
function sample_path($name)
{
	return path_is_absolute($name)
		? $name
		: realpath(dirname(__FILE__) . '/../components/' . $name);
}

/* Return a literal sample with no decoration */
function literal($file)
{
	return file_get_contents(sample_path($file));
}

function el($name, $attrs = '', $body = '', $xml = false)
{
	return $xml
		? xml_element($name, $attrs, $body)
		: html_element($name, $attrs, $body);
}

function html_element($name, $attrs = '', $body = '')
{
	// arguments must be escaped already
	return tag($name, $attrs) . $body . tag('/' . $name);
}

function xml_element($name, $attrs = '', $body = '')
{
	// arguments must be escaped already
	return $body
		? tag($name, $attrs) . $body . tag('/' . $name)
		: tag($name, $attrs ? $attrs . ' /' : '/'); // self-closing tag
}

function tag($name, $attrs = '')
{
	// arguments must be escaped already
	return '<' . $name . ($attrs ? ' ' . $attrs : '') . '>';
}

function _e($text)
{
	return htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');
}

function _e_attr($text)
{
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function todo($summary = '')
{
	return el('aside', 'class="caution TODO"', 'TODO' . ($summary ? ': ' . $summary : '')) . "\n";
}

function keyword($text)
{
	return el('span', 'class="keyword"', $text);
}

function string($text)
{
	return el('span', 'class="string"', $text);
}

/* Return a literal sample block as HTML */
function sample($file, $header = 'Sample', $header_level = 2)
{
	return el('h' . (int) $header_level, '', _e($header)) . el('aside', 'class="example"', literal($file));
}

/* Return a code block as pretty HTML */
function code($language, $file)
{
	return el('pre', 'class="code ' . $language . '"', el('code', '', pretty_file($language, $file)));
}

function pretty_file($language, $file)
{
	return pretty_literal($language, literal($file));
}

function pretty_literal($language, $literal)
{
	switch($language)
	{
		case 'html':
		case 'xml':
		case 'docbook':
			return pretty_html($literal);
		default:
			return _e($literal);
	}
}

/* Pretty-print some HTML */
function pretty_html($html)
{
	/* Note that this is not intended to be foolproof; it's entirely possible
	 * that a poorly-crafted sample will cause invalid output, but samples
	 * are a trusted source in this context.
	 */
	$html = str_replace('&', '&amp;', $html);
	$c = 0;
	while(true)
	{
		while(true)
		{
			$s = strpos($html, '<', $c);
			$e = strpos($html, '>', $c);
			if($e === false || ($s !== false && $e > $s))
			{
				break;
			}
			$html = substr($html, 0, $e) . '&gt;' . substr($html, $e + 1);
		}
		if($s === false)
		{
			break;
		}
		if($e !== false)
		{
			$tag = substr($html, $s + 1, $e - $s - 1);
			$buf = pretty_html_tag($tag);
			$html = substr($html, 0, $s) . $buf . substr($html, $e + 1);
			$c = $s + strlen($buf);
		}
		else
		{
			$tag = substr($html, $s);
			$html = substr($html, 0, $s) . pretty_html_tag($tag);
			break;
		}
	}
	return $html;
}

function pretty_html_tag($tag)
{
	if(substr($tag, 0, 1) == '/')
	{
		return '&lt;/' . keyword(_e(substr($tag, 1))) . '&gt;';
	}
	$matches = array();
	preg_match('!^\s*(\S+)(\s+(.+))?$!misU', _e($tag), $matches);
	$tag = '&lt;' . keyword($matches[1]);
	$list = array();
	if(isset($matches[3]))
	{
		$attrs = $matches[3];
		$c = 0;
		$l = strlen($attrs);
		while($c < $l)
		{
			$s = strcspn($attrs, "= \t\r\n", $c);
			if(!$s)
			{
				$c++;
				continue;
			}
			$name = substr($attrs, $c, $s);
			$ch = substr($attrs, $c + $s, 1);
			$a = keyword($name);
			$c += $s + 1;
			if($ch == '=')
			{
				$c++;
				/* Attribute has a value */
				$q = substr($attrs, $c - 1, 1);
				$start = $c;
				if($q == '"' || $q == '\'')
				{
					$vlen = strcspn($attrs, $q, $c);
					$c++;
				}
				else
				{
					$vlen = strcspn($attrs, "\t\r\n " , $c);
				}
				$a .= '="' . string(substr($attrs, $start, $vlen)) . '"';
				$c += $vlen;
			}
			$list[] = $a;
		}
		if(count($list))
		{
			$tag .= ' ' . implode(' ', $list);
		}
	}
	$tag .= '&gt;';
	return $tag;
}
