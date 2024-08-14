$(document).ready(function () {
	function fetchUserData() {
		$.ajax({
			type: 'GET',
			url: 'php/GetUserData.php',
			success: function (response) {
				try {
					var userData = JSON.parse(response)
					if (userData.error) {
						showErrorMessage(userData.error)
					} else {
						$('#FullName').text(userData.FullName)
						$('#userFullName').text(userData.FullName)
						$('#userPhoneNumber').text(userData.PhoneNumber)
						$('#userLogin').text(userData.Login)
					}
				} catch (error) {
					console.error('Ошибка при парсинге JSON:', error)
					showErrorMessage()
				}
			},
			error: function () {
				showErrorMessage()
			},
		})
	}

	function showErrorMessage(
		message = 'Произошла ошибка при загрузке данных пользователя. Пожалуйста, попробуйте позже.'
	) {
		alert(message)
		window.location.href = '../login.php'
	}

	$('#edit-user-info').on('click', function () {
		$('#editFullName').val($('#userFullName').text())
		$('#editPhoneNumber').val($('#userPhoneNumber').text())
		$('#edit-user-info-modal').show()
	})

	$('#close-edit-popup').on('click', function () {
		$('#edit-user-info-modal').hide()
	})

	$('#link-vk').on('click', function () {
		$('#link-vk-modal').show()
	})

	$('#close-link-vk').on('click', function () {
		$('#link-vk-modal').hide()
	})

	$('#confirm-link-vk').on('click', function () {
		const vkAuthUrl =
			'https://oauth.vk.com/authorize?client_id= &display=page&redirect_uri= &scope=email&response_type=code&v=5.199'
		window.location.href = vkAuthUrl
	})

	$('#edit-user-info-form').on('submit', function (e) {
		e.preventDefault()
		const formData = {
			FullName: $('#editFullName').val(),
			PhoneNumber: $('#editPhoneNumber').val(),
			Password: $('#editPassword').val(),
			ConfirmPassword: $('#confirmPassword').val(),
		}

		$.ajax({
			url: 'php/UpdateUserData.php',
			method: 'POST',
			data: formData,
			success: function (data) {
				try {
					const response = JSON.parse(data)
					if (response.error) {
						alert(response.error)
					} else {
						alert(response.success)
						$('#userFullName').text(formData.FullName)
						$('#userPhoneNumber').text(formData.PhoneNumber)
						$('#edit-user-info-modal').hide()
					}
				} catch (error) {
					console.error('Ошибка при парсинге JSON:', error)
					alert('Ошибка при обновлении данных пользователя.')
				}
			},
			error: function () {
				alert('Ошибка при обновлении данных пользователя.')
			},
		})
	})
	fetchUserData()
})
