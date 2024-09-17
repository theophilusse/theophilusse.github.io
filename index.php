<!DOCTYPE html>
<html>
	<body>
		<!--    W  A  V  E  S   -->
		<!-- Author: ttrossea   -->
		<!-- Date  : 06/04/2023 -->
		<wavebackground></wavebackground>
		<div id="waveTitle">
			<h1>Bienvenue sur mon portfolio</h1>
			<a href="/snake/snake.html">Snake</a>
		</div>
		<h2 id="waveAuthor">ttrossea</h2>
		<script>
			var preConst = parseInt(Math.random() * 2);
		
			function waves(x, oscillationNumber)
			{
				return Math.sin(x * 3.1415 * oscillationNumber);
			}

			function createGrid(dimX, dimY, scale, clock)
			{
				let x;
				let y;
				let originX = -100;
				let originY = -180;
				let z;
				var point = new Array;
				var baseColor = [ <?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?> ];
				var deltaX;
				var deltaY;
				var prevValue_x = 0;
				var prevValue_y = 0;
				z = 0;
				y = 0;
				while (y < dimY)
				{
					x = 0;
					while (x < dimX)
					{
						let clock_x = x + clock;
						let clock_y = y + clock;
						let waveValue_x = waves((1 / dimY) * clock_y, <?php echo rand(0, 8); ?>.<?php echo rand(0, 9); ?>);
						let waveValue_y = waves((1 / dimX) * clock_x, <?php echo rand(0, 7); ?>.<?php echo rand(0, 9); ?>);
						let ptX = originX + (x + waveValue_x) * scale;// + Math.random() * 15;
						let ptY = originY + (y + waveValue_y * <?php rand(1, 2) ?>.<?php rand(0, 9) ?>) * scale;// + Math.random() * 15;

						deltaX = waveValue_x - prevValue_x;
						deltaY = waveValue_y - prevValue_y;

						//{% if random(1) == 1 %}
						if (preConst == 0)
							colorFactor = deltaY + 1;
						else //{% else %}
							colorFactor = ((waveValue_y + 1.5) / 2);
						//{% endif %}

						//colorFactor = ((deltaX + deltaY) / 2) + 1;
						//colorFactor += deltaY + 1;
						//waveValue_y *= -1;
						//colorFactor += ((waveValue_x + 1) / 5);
						//colorFactor += (waveValue_y / waveValue_x) + 1;
						//colorFactor += (waveValue_x / waveValue_y);
						//colorFactor += ((waveValue_x + 1) / ((waveValue_y + 1) / 2));
						let color = "rgb(" + (colorFactor * baseColor[0]) + "," + (colorFactor * baseColor[1]) + "," + (colorFactor * baseColor[2]) + ");";
						point.push({
							x: ptX,
							y: ptY,
							id: z,
							color: color
						});
						x++;
						z++;
						prevValue_x = waveValue_x;
						prevValue_y = waveValue_y;
					}
					y++;
				}
				return point;
			}

			function buildPolyline(name, dimX, dimY)
			{
				var rootSvg;
				var index;
				var list;
				var x;
				var y;

				list = [];
				index = 0;
				y = 0;
				while (y < dimY)
				{
					x = 0;
					while (x < dimX)
					{
						elm = document.createElement('polyline');
						elm.setAttribute('id', 'pt-'+index);
						list.push(elm);
						index++;
						x++;
					}
					y++;
				}
				return list;
			}

			function refreshSvg()
			{
				var svgName = 'svgBg';
				var rootSvg = document.createElement('svg');
				rootSvg.setAttribute('id', svgName);
				var dimX = <?php echo rand(20, 30); ?>;
				var dimY = <?php echo rand(18, 28); ?>;
				var scale = 50;
				var point = createGrid(dimX, dimY, scale, clock);
				var svgCopy;
				var polyline = buildPolyline(svgName, dimX, dimY);
				var offsetA;
				var offsetB;
				var offsetC;
				var offsetD;
				var coordX = -1;
				var coordY = 0;
				var index = 0;

				while (index < polyline.length)
				{
					coordX++;
					if (coordX >= dimX - 1)
					{
						coordY++;
						coordX = 0;
						if (coordY >= dimY - 1)
						index = polyline.length;
					}
					offsetA = coordY * dimX + coordX;
					offsetB = (coordY + 1) * dimX + coordX;
					offsetC = (coordY + 1) * dimX + (coordX + 1);
					offsetD = coordY * dimX + (coordX + 1);
					if (offsetA < point.length && offsetB < point.length)
					{
						polyline[index].setAttribute('points',
						point[offsetA].x + ',' + point[offsetA].y + ' ' +
						point[offsetB].x + ',' + point[offsetB].y + ' ' +
						point[offsetC].x + ',' + point[offsetC].y + ' ' +
						point[offsetD].x + ',' + point[offsetD].y);
						polyline[index].setAttribute('style', 'fill: ' + point[offsetA].color);
					}
					index++;
				}
				index = 0;
				while (index < polyline.length)
				rootSvg.appendChild(polyline[index++]);
				document.getElementsByTagName('wavebackground')[0].innerHTML = "<svg id='svgBg' viewbox='0 0 800 500' width='800' height='500' preserveAspectRatio='none'>" + rootSvg.innerHTML + "</svg>";
				clock += 0.0<?php echo rand(0, 9); ?><?php echo rand(0, 9); ?><?php echo rand(0, 9); ?>;
			}

			var clock = 0;
			var timeout = 20;
			setInterval(refreshSvg, timeout);
		</script>
		<style>
			svg {
				position: absolute;
				top: 0px;
				left: 0px;
				width: 100%;
				height: 100%;
				background-color: black;
			}

			<?php
				$colorRed_fg = rand(0, 255);
				$colorGreen_fg = rand(0, 255);
				$colorBlue_fg = rand(0, 255);
				$colorRed_bg = rand(0, 255);
				$colorGreen_bg = rand(0, 255);
				$colorBlue_bg = rand(0, 255);
			?>

			polyline {
				stroke: rgb(<?php echo $colorRed_fg; ?>, <?php echo $colorGreen_fg; ?>, <?php echo $colorBlue_fg; ?>);
				stroke-width: 1px;
			}

			#waveTitle {
				position: relative;
				background-color: rgba(<?php echo $colorRed_bg; ?>, <?php echo $colorGreen_bg; ?>, <?php echo $colorBlue_bg; ?>, 0.5);
				width: 25%;
				left: 38%;
				top: 25vh;
				padding: 15px;
				border-radius: 15px;
				border: 3px solid black;
			}

			#waveTitle h1 {
				font-family: 'Brush Script MT',cursive;
				color: rgb(<?php echo $colorRed_fg; ?>, <?php echo $colorGreen_fg; ?>, <?php echo $colorBlue_fg; ?>);
				text-shadow: 3px 3px rgb(<?php echo 255 - $colorRed_fg; ?>, <?php echo 255 - $colorGreen_fg; ?>, <?php echo 255 - $colorBlue_fg; ?>);
				font-size: 5vh;
				position: relative;
				display: block;
				text-align: center;
			}

			#waveTitle a {
				background-color: rgb(<?php echo 255 - $colorRed_bg; ?>, <?php echo 255 - $colorGreen_bg; ?>, <?php echo 255 - $colorBlue_bg; ?>);
				color: rgb(<?php echo $colorRed_bg; ?>, <?php echo $colorGreen_bg; ?>, <?php echo $colorBlue_bg; ?>);
				padding: 10px 10% 10px 10%;
				border-radius: 30px;
				border: 3px solid rgb(<?php echo $colorRed_fg; ?>, <?php echo $colorGreen_fg; ?>, <?php echo $colorBlue_fg; ?>);
				display: block;
				text-align: center;
				text-shadow: 2px 2px black;
			}

			#waveTitle a:hover {
				background-color: rgb(<?php echo $colorRed_bg; ?>, <?php echo $colorGreen_bg; ?>, <?php echo $colorBlue_bg; ?>);
				color: rgb(<?php echo 255 - $colorRed_bg; ?>, <?php echo 255 - $colorGreen_bg; ?>, <?php echo 255 - $colorBlue_bg; ?>);
				border: 3px solid rgb(<?php echo 255 - $colorRed_fg; ?>, <?php echo 255 - $colorGreen_fg; ?>, <?php echo 255 - $colorBlue_fg; ?>);
				text-shadow: 1px 1px black;
			}

			#waveAuthor {
				position: fixed;
				bottom: 0px;
				right: 0px;
				margin: 0;
				font-size: 15px;
				background-color: rgba(255, 255, 255, 0.5);
				padding: 2px;
				color: black;
				line-height: 15px;
			}
		</style>
	</body>
</html>