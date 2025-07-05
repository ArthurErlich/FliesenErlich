// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
	modules: [
		"@nuxt/eslint",
		"@nuxt/fonts",
		"@nuxt/icon",
		"@nuxt/image",
		"@nuxtjs/seo",
		"@nuxtjs/tailwindcss",
	],
	devtools: { enabled: true },
	app: {
		head: {
			link: [
				{ rel: "icon", type: "image/png", href: "/favicon/erlich-fliesen-favicon-64.png" },
				{ rel: "icon", type: "image/png", href: "/favicon/erlich-fliesen-favicon.png" },
			],
		},
		pageTransition: { name: "page", mode: "out-in" },
	},
	css: ["~/assets/css/main.css"],
	compatibilityDate: "2025-05-15",
	eslint: {
		config: {
			stylistic: {
				semi: true,
				quotes: "double",
				commaDangle: "always-multiline",
				indent: "tab",
			},
		},
	},
	tailwindcss: {
		cssPath: [`assets/css/tailwind.css`, { injectPosition: "first" }],
		editorSupport: true,
		configPath: "tailwind.config.js",
		config: {},
		viewer: true,
		exposeConfig: true,
	},
});
