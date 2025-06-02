document.addEventListener('DOMContentLoaded', () => {
	const decrementButtons = document.querySelectorAll('.decrement')
	const incrementButtons = document.querySelectorAll('.increment')

	decrementButtons.forEach(button => {
		button.addEventListener('click', () => {
			const input = button.nextElementSibling
			let quantity = parseInt(input.value, 10)
			if (quantity > 1) {
				input.value = quantity - 1
			}
		})
	})

	incrementButtons.forEach(button => {
		button.addEventListener('click', () => {
			const input = button.previousElementSibling
			let quantity = parseInt(input.value, 10)
			input.value = quantity + 1
		})
	})
})