
document.querySelector('form').addEventListener('submit', function(e) {
	e.preventDefault(); // Prevent the form from submitting normally
	const searchTerm = document.querySelector('input[type="search"]').value.toLowerCase();
	const headings = document.querySelectorAll('.card-header h4 button');

	headings.forEach(heading => {
		if (heading.textContent.toLowerCase().includes(searchTerm)) {
			heading.scrollIntoView({ behavior: 'smooth' });
			heading.click(); // Expand the collapsed section
		}
	});
});