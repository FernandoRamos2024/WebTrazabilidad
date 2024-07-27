document.getElementById('clearFilters').addEventListener('click', function() {
	var form = document.getElementById('searchForm');
	
	// Limpiar todos los campos del formulario
	form.querySelectorAll('input').forEach(function(input) {
		input.value = '';
	});

	form.querySelectorAll('select').forEach(function(select) {
		select.selectedIndex = 0;
	});

	// Enviar el formulario
	form.submit();
});