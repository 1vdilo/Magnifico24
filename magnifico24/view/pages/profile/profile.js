document.addEventListener('DOMContentLoaded', function () {
	const orderItems = document.querySelectorAll('.order-item');

	orderItems.forEach(orderItem => {
					const detailsButton = orderItem.querySelector('.details-button');
					const orderDetails = orderItem.querySelector('.order-details');
					const arrow = detailsButton.querySelector('.arrow-down');

					detailsButton.addEventListener('click', function () {
									orderDetails.classList.toggle('hidden');
									detailsButton.classList.toggle('open');

									if (!orderDetails.classList.contains('hidden')) {
													orderDetails.style.maxHeight = orderDetails.scrollHeight + 'px';
									} else {
													orderDetails.style.maxHeight = null;
									}
					});
	});
});