<?php
		$date = date("d/m/Y");
		// show current day of the week in portuguese
		$day = date("l");
		$day_array = array(
			'Monday' => 'Segunda-feira',
			'Tuesday' => 'Terça-feira',
			'Wednesday' => 'Quarta-feira',
			'Thursday' => 'Quinta-feira',
			'Friday' => 'Sexta-feira',
			'Saturday' => 'Sábado',
			'Sunday' => 'Domingo'
		);
		$day = $day_array[$day];
