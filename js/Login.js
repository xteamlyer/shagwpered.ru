const VKID = window.VKIDSDK

VKID.Config.set({
	app: '',
	redirectUrl: '',
	state: 'dj29fnsadjsd82...',
})
function handleClick() {
	VKID.Auth.login()
}

const button = document.getElementById('VKIDSDKAuthButton')
if (button) {
	button.onclick = handleClick
}

function hideErrorMessage() {
	var errorMessage = document.getElementById('error-message')
	if (errorMessage) {
		errorMessage.style.display = 'none'
	}
}

function toggleForm() {
	hideErrorMessage()
	var authForm = document.getElementById('authForm')
	var regForm = document.getElementById('regForm')
	var formTitle = document.getElementById('formTitle')
	var switchFormText = document.getElementById('switchForm')

	if (authForm.style.display === 'none') {
		authForm.style.display = 'flex'
		regForm.style.display = 'none'
		formTitle.innerText = 'Авторизация'
		switchFormText.innerText = 'Нет аккаунта? Регистрация'
	} else {
		authForm.style.display = 'none'
		regForm.style.display = 'flex'
		formTitle.innerText = 'Регистрация'
		switchFormText.innerText = 'Уже есть аккаунт? Авторизация'
	}
}
