$(document).ready(function() {
	reporte.init();
	/*$('form').submit(function(event){
		event.preventDefault();
		$('input[name="user_id"]').val($('input[name="user_id"]').val().split('-')[0]);
		alert($(this).serialize());
		this.reset();
		reporte.init();
	});*/
});


let reporte = {
	cont : 0,
	secciones : [ $('#paciente'),
				  $('#antropometria'),
				  $('#analisis-bio'),
				  $('#tratamiento-medico'),
				  $('#valor-nutricional'),
				  $('#indicaciones-nutricionales'),
				],
	close : false,
	init : function(){
		this.cont = 0;
		for(i in this.secciones){
			this.secciones[i].hide();
		}
		this.secciones[0].show();
		$('.btn-white').html('Cerrar');
		$('.btn-default').html('Siguiente');
	},
	next : function(){
		if((this.secciones.length-1) == this.cont){
			$('input[name="user_id"]').val($('input[name="paciente_id"]').val().split('-')[0]);
			$('form').submit();
			this.init();
			$('#modal_nuevo').hide();
		}else{
			this.secciones[this.cont].hide();
			this.cont++;
			this.secciones[this.cont].show();
		}
		if((this.secciones.length-1) == this.cont){
			$('.btn-default').html('Guardar');
			$('.btn-white').html('Atras');
			this.close = false;
		}else{
			this.close = false;
			$('.btn-default').html('Siguiente');
			$('.btn-white').html('Atras');
		}
	},
	back : function(){
		if(this.cont == 0){
			$('.btn-white').html('Cerrar');
			$('.btn-default').html('Siguiente');
			this.close = true;
		}else{
			this.close = false;
			$('.btn-white').html('Atras');
			$('.btn-default').html('Siguiente');
			this.secciones[this.cont].hide();
			this.cont--;
			this.secciones[this.cont].show();
			if(this.cont == 0){
				$('.btn-white').html('Cerrar');
				$('.btn-default').html('Siguiente');
			}
		}
		if(this.close){
			$('.close').click();
		}
	},
	check : function(){
		if(this.cont == 0){
			$('.btn-white').html('Cerrar');
			$('.btn-default').html('Siguiente');
		}else if((this.secciones.length-1) == this.cont){
			$('.btn-default').html('Guardar');
			$('.btn-white').html('Atras');

		}else{
			$('.btn-white').html('Atras');
			$('.btn-default').html('Siguiente');
		}
	}
};