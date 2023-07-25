fetch(authApi.root + 'wp-auth-api/v1/login', {
	method: 'GET',
	headers: {
		'X-WP-Nonce': authApi.nonce,
	},
})
	.then(function (response) {
		return response.json();
	})
	.then(function (response) {
		const urlParams = new URLSearchParams(window.location.search);
		const nextJsAdminRedirect = urlParams.get('nextJsAdminRedirect');

		if (response?.isLoggedIn && nextJsAdminRedirect) {
			window.location = nextJsAdminRedirect;
		}
	});

console.log('authApi', authApi);
