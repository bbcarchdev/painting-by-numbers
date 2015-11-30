<?php

$logo = array(
	'res-logo-full' => 'Complete full-colour logo',
	'res-logo-full-mono' => 'Complete monochrome logo',
	'res-logo-min-olive-grey' => 'Minimal full-colour logo',
	'res-logo-min-olive' => 'Minimal colour logo on a transparent background',
	'res-logo-min-white-grey' => 'Minimal white-on-grey logo',
	'res-logo-min-black' => 'Minimal monochrome logo on a transparent background',
	'res-logo-min-white-black' => 'Minimal monochrome logo on a black background',
);

echo '<div class="clear">';
foreach($logo as $name => $title)
{
	echo '<figure class="third">';
	echo '<a href="logo/' . _e($name) . '.svg">' ;
	echo '<img src="logo/' . _e($name) . '.png" alt="' . _e($title) . '">';
	echo '</a>';
	echo '<figcaption>' . _e($title) . ' (';
	echo '<a href="logo/' . _e($name) . '.png">PNG</a>, ';
	echo '<a href="logo/' . _e($name) . '.svg">SVG</a>, ';
	echo '<a href="logo/' . _e($name) . '.pdf">PDF</a>';
	echo ')</figcaption>';
	echo '</figure>';
}
echo '</div>';
