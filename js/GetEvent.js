document.addEventListener('DOMContentLoaded', function () {
	$.ajax({
		type: 'GET',
		url: 'php/GetEvent.php',
		success: function (response) {
			if (response.error) {
				console.error('Ошибка при получении событий:', response.error)
				window.location.href = '../login.php'
			} else {
				var eventsData = response.events
				var calendarManager = new CalendarManager(eventsData)
			}
		},
		error: function (xhr, status, error) {
			console.error('Произошла ошибка при получении событий:', error)
		},
	})
})
