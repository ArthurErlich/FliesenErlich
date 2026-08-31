import * as Sentry from '@sentry/astro';

Sentry.init({
	dsn: 'https://af3bf28d0707c86ba4a01561dfe138c0@sentry.arthurerlich.de/4',
	dataCollection: {
		// To disable sending user data and HTTP bodies, uncomment the lines below. For more info visit:
		// https://docs.sentry.io/platforms/javascript/guides/astro/configuration/options/#dataCollection
		userInfo: false,
		// httpBodies: [],
	},
});
