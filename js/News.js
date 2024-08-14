function openModal(newsData) {
	document.getElementById('modalBanner').src = newsData.Banner
	document.getElementById('modalTitle').innerText = newsData.Title
	document.getElementById('modalText').innerHTML = newsData.Text
	document.getElementById('newsModal').style.display = 'block'
}

function closeModal() {
	document.getElementById('newsModal').style.display = 'none'
}

window.onclick = function (event) {
	var modal = document.getElementById('newsModal')
	if (event.target == modal) {
		modal.style.display = 'none'
	}
}
