<?php
	
$palette = array(
	'Primary palette' => array(
		'green1' => array('Olive green', 'ceca13'),
		'green2' => array('Dark olive green', 'a29f06'),
		'orange2' => array('Pale orange', 'ec7139'),
		'black' => array('Black', '000000'),
		'white' => array('White', 'ffffff'),
	),
	'Highlight palette' => array(
		'green' => array('Green', '859900'),
		'yellow' => array('Yellow', 'b58900'),
		'orange' => array('Orange', 'cb4b16'),
		'red' => array('Red', 'dc322f'),
		'magenta' => array('Magenta', 'd33682'),
		'violet' => array('Violet', '6c71c4'),
		'blue' => array('Blue', '268bd2'),
		'cyan' => array('Cyan', '2aa198'),
	),
	'Code sample backgrounds' => array(
		'base03' => array('Base03', '002b36'),
		'base02' => array('Base02', '073642'),
		'base2' => array('Base2', 'eee8d5'),
		'base3' => array('Base3', 'fdf6e3'),
	),
	'Code sample foregrounds' => array(
		'base01' => array('Base01', '586e75'),
		'base00' => array('Base00', '657b83'),
		'base0' => array('Base0', '839496'),
		'base1' => array('Base1', '93a1a1'),
	),
	'Grey shades' => array(
		'grey4' => array('Platinum', 'e6e6e6'),
		'grey3' => array('Light grey', 'd2d2d2'),
		'grey2' => array('Medium grey', 'b2b2b2'),
		'grey5' => array('Dim grey', '848484'),
		'grey1' => array('Graphite', '636363'),
		'grey7' => array('Jet', '404040'),
	)
);

?>
<table class="palette">
	<thead>
		<tr>
			<th scope="col">Colour</th>
			<th scope="col">RGB (Hex)</th>
			<th scope="col">RGB (Decimal)</th>
		</tr>
	</thead>
	<tbody>
<?php

foreach($palette as $section => $colours)
{
	echo '<tr><th scope="col" colspan="3">' . $section . '</th></tr>';
	foreach($colours as $id => $info)
	{
		$r = $g = $b = 0;
		sscanf($info[1], '%02x%02x%02x', $r, $g, $b);
		echo '<tr>';
		echo '<td class="col ' . $id . '"><span class="swatch ' . $id . '"></span>' . $info[0] . '</td>';
		echo '<td><code>#' . $info[1] . '</code></td>'; 
		echo '<td><code>' . $r . '</code>, <code>' . $g . '</code>, <code>' . $b . '</code></td>';
		echo '</tr>';
	}
}
		
?>
	</tbody>
</table>
