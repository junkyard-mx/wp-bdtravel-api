<div class="content-summary" id="<?php echo $hotel_id ?>">
	<div class="left-info">
		<div class="hotel-image">
			<a href="<?php echo $hotel_endpoint . '?promedio='.$precioPromedio.'&h=' . $hotel_id; ?>"><img src="<? echo $HImage ?>" /></a></div>
		<h2 class="hotel-name">
			<a href="<?php echo $hotel_endpoint . '?promedio='.$precioPromedio.'&h=' . $hotel_id; ?>"> <?php echo $HName ?> </a></h2>
		<div class="category stars <?php echo $HCategory ?>"></div>
		<div class="rating"><i class="fa fa-comment-o"></i> <?php echo $HRating ?><span class="rating-small">/5 de Calificación</span></div>
		<ul class="more-details">
			<li class="location"><i class="fa fa-location-arrow"></i> <?php echo $HLocation ?></li>
			<!-- <li><?php echo $tipoHabitacion ?></li> -->
			<li class="plan-alimentos"><?php echo $planAlimentos ?></li>
		</ul>
	</div>
	<div class="right-info">
		<div class="normal-price"><span style="font-size:9px;">MXN$</span> <?php echo round($precio_sin_promocion, 2) ?></div>
		<div class="price"><span style="font-size:14px;">MXN$</span> <?php echo round($precioPromedio, 2) ?></div>
		<p>Precio por Noche</p>
		<p>Impuestos incluidos</p>
		<a href="<?php echo $hotel_endpoint . '?promedio='.$precioPromedio.'&h=' . $hotel_id; ?>">
			<div class="bd-button">Reservar</div>
		</a>
	</div>	
	<? echo $counter; ?>
</div>
<div class="divider"></div>