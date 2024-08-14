$(document).ready(function () {
	var $theme = $('#theme')
	var $instructor = $('#instructor')
	var $eventDate = $('#event-date')
	var $eventTime = $('#event-time')
	var $addEventButton = $('#add-event-btn')

	loadDropdowns()

	var calendarManager = new CalendarManager()

	function loadDropdowns() {
		$theme.empty()
		$instructor.empty()

		$.when(
			$.ajax({
				url: 'php/GetDirections.php',
				method: 'GET',
				dataType: 'json',
			}),
			$.ajax({
				url: 'php/GetInstructors.php',
				method: 'GET',
				dataType: 'json',
			})
		).done(function (directionsData, instructorsData) {
			$.each(directionsData[0], function (key, value) {
				$theme.append(
					$('<option></option>')
						.attr('value', value.ID_Direction)
						.text(value.Name)
				)
			})

			$.each(instructorsData[0], function (key, value) {
				$instructor.append(
					$('<option></option>')
						.attr('value', value.ID_Instructor)
						.text(value.FullName)
				)
			})
			$eventDate.on('change', function() {
				calendarManager.clearSelections()
				loadTimeSlots()
			})
			$instructor.on('change', loadTimeSlots)
		})

		$eventTime.on('change', function () {
			if ($eventTime.val() !== '') {
				$addEventButton.prop('disabled', false)
			} else {
				$addEventButton.prop('disabled', true)
			}
		})
	}

	function loadTimeSlots() {
		var date = $eventDate.val()
		var instructorId = $instructor.val()
		if (date && instructorId) {
			$.ajax({
				url: 'php/GetTime.php',
				method: 'GET',
				data: {
					date: date,
					instructor: instructorId,
				},
				dataType: 'json',
				success: function (data) {
					$eventTime.empty()
					if (data.error) {
						$eventTime.append(
							$('<option></option>').attr('value', '').text(data.error)
						)
						$addEventButton.prop('disabled', true)
					} else {
						$.each(data, function (key, value) {
							$eventTime.append(
								$('<option></option>').attr('value', value).text(value)
							)
						})
						$addEventButton.prop('disabled', false)
					}
				},
				error: function (xhr, status, error) {
					console.error('Ошибка загрузки временных слотов:', error)
					$addEventButton.prop('disabled', true)
				},
			})
		} else {
			$addEventButton.prop('disabled', true)
		}
	}
})

function CalendarManager() {
	this.initializeCalendar()
	this.setupEventHandlers()
	this.setupForm()
}

CalendarManager.prototype.initializeCalendar = function () {
	var calendarEl = document.getElementById('calendar')
	this.calendar = new FullCalendar.Calendar(calendarEl, {
		initialView: 'dayGridMonth',
		locale: 'ru',
		firstDay: 1,
		selectable: true,
		views: {
			dayGridMonth: {
				titleFormat: {
					year: 'numeric',
					month: 'short',
				},
			},
		},
		buttonText: {
			today: 'Сегодня',
			month: 'Месяц',
			week: 'Неделя',
			day: 'День',
		},
		events: function (fetchInfo, successCallback, failureCallback) {
			$.ajax({
				url: 'php/GetEvent.php',
				method: 'GET',
				dataType: 'json',
				success: function (data) {
					if (data.error) {
						alert(data.error)
					} else {
						successCallback(data.events)
					}
				},
				error: function (xhr, status, error) {
					failureCallback(error)
					console.error('Ошибка загрузки событий:', error)
				},
			})
		},
		eventClick: this.handleEventClick.bind(this),
		select: this.handleSelect.bind(this),
	})
	this.calendar.render()
}

CalendarManager.prototype.setupEventHandlers = function () {
	var openAddEventModal = function () {
		$('#add-event-modal').show()
	}
	$('#add-event-button').click(function () {
		$('body').addClass('modal-open')
		openAddEventModal()
	})
	$('#close-add-popup').click(function () {
		$('body').removeClass('modal-open')
		$('#add-event-modal').hide()
	})
	this.calendar.on('dateClick', function (info) {
		$('body').addClass('modal-open')
		$('#event-date').val(info.dateStr)
		openAddEventModal()
		this.clearSelections() // Clear selections when date is clicked
	}.bind(this))
	$('#close-popup').click(function () {
		$('body').removeClass('modal-open')
		$('#event-info').hide()
	})
}

CalendarManager.prototype.setupForm = function () {
	$('#add-event-form')
		.off('submit')
		.on('submit', event => {
			event.preventDefault()

			var formData = $(event.target).serialize()
			$.ajax({
				type: 'POST',
				url: 'php/AddEvent.php',
				data: formData,
				success: function (response) {
					var jsonMatch = /{.*}/.exec(response)
					if (jsonMatch) {
						var jsonResponse = JSON.parse(jsonMatch[0])
						if (jsonResponse.status === 'success') {
							this.calendar.refetchEvents()
							alert('Занятие успешно добавлено!')
							$('body').removeClass('modal-open')
							$('#add-event-modal').hide()
						} else {
							alert(
								'Произошла ошибка при добавлении занятия: ' +
									jsonResponse.message
							)
						}
					} else {
						alert('Произошла ошибка при добавлении занятия: ' + response)
					}
				}.bind(this),
				error: function (xhr, status, error) {
					if (xhr.status === 409) {
						alert('На указанную дату и время уже существует занятие.')
					} else {
						alert('Произошла ошибка при добавлении занятия: ' + error)
					}
				},
			})
		})
}

CalendarManager.prototype.handleEventClick = function (info) {
	$('#event-date-info').text(info.event.start.toLocaleString())
	$('#event-title').text(info.event.title)
	$('#event-info').show()

	$('#delete-event')
		.off('click')
		.on('click', function () {
			var eventId = info.event.id
			console.log('Event ID to delete:', eventId)
			if (confirm('Вы уверены, что хотите удалить это занятие?')) {
				$.ajax({
					type: 'POST',
					url: 'php/DeleteEvent.php',
					data: { event_id: eventId },
					success: function (response) {
						var jsonMatch = /{.*}/.exec(response)
						if (jsonMatch) {
							var jsonResponse = JSON.parse(jsonMatch[0])
							if (jsonResponse.status === 'success') {
								alert('Занятие успешно удалено.')
								info.event.remove()
								$('#event-info').hide()
							} else {
								alert(
									'Произошла ошибка при удалении занятия: ' +
										jsonResponse.message
								)
							}
						} else {
							alert('Произошла ошибка при удалении занятия: ' + response)
						}
					},
					error: function (xhr, status, error) {
						alert('Произошла ошибка при удалении занятия: ' + error)
					},
				})
			}
		})
}

CalendarManager.prototype.handleSelect = function (info) {
	$('#event-date').val(info.startStr)
	$('body').addClass('modal-open')
	$('#add-event-modal').show()
	this.clearSelections() // Clear selections when a new date is selected
}

CalendarManager.prototype.clearSelections = function() {
	$('#instructor').val('')
	$('#theme').val('')
	$('#event-time').empty()
	$('#add-event-btn').prop('disabled', true)
}
