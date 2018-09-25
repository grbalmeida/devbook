const token = function() {
	return document.querySelector('meta[name="csrf-token"]').getAttribute('content')
}